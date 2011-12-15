<?php

class Badge extends AppModel {
  var $name = 'Badge';
  var $order = array("Badge.modified" => "DESC");
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id',
      'counterCache' => true,
    ),
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id',
      'counterCache' => true,
    ),
    'Project' =>array(
      'className'    => 'Project',
      'foreignKey'   => 'project_id',
      'counterCache' => true,
    ),
  );
  
  function beforeSave() {
    // Associate Badge[measure_id] and unset Badge[measure] 
    if (empty($this->data['Badge']['measure_id'])) {
      $measure = $this->Measure->saveMeasure($this->data['Badge']['measure'], $this->data['Badge']['quantity_goal']);
      $this->data['Badge']['measure_id'] = $measure['Measure']['id'];
      unset($this->data['Badge']['measure']); // the Measure's text isn't saved
    }
  
    return TRUE;
  }
  
  /**
   * Function findUserProgress
   *
   * Returns a list of badges that can be earned for a 
   * specific user based on the parameters; sorted by 
   * highest completion percentage DESC.
   *
   * @param $user_id 
   *   The user_id of the person who we are seeking badges for
   * @param $whose
   *   Are we looking for the user's own badges ('self') or 'all'
   *    self  : only return badges created by the user_id
   *    other : only return badges NOT created by the user_id
   *    all   : return all badges 
   * @param $find
   *   CakePHP's find parameter, e.g. all, first, etc.
   * @param $project_id
   *   Find badges that have been assigned to a particular project
   *     NULL = find all badges (even those assigned to projects
   *     FALSE = only find badges not assigned to any project
   * @param $measure_id
   *   Find badges only for a particular measure
   * @param $lt_quantity
   *   Find badges whose quantity goal is less than this value
   *
   * @return object Badge(s)
   */
  function findUserProgress($user_id, $whose = 'self', $find = 'all', $project_id = NULL, $measure_id = NULL, $lt_quantity = NULL) {
    // bind the User's Awarded badge to the model, so it's joined on Find()... though we'll set a condition to disregard Badges that have an AwardedBadge since we're looking for *unawarded badges*
    $this->bindModel(
      array('hasOne' => array(
        'AwardedBadge' => array(
          'className' => 'AwardedBadge',
          'foreignKey' => 'badge_id',
          'conditions' => array('AwardedBadge.user_id' => $user_id), 
        ),
      )
    ));
    
    //Bind measure's sum (User, then Project) so we know progress
    $this->bindModel(
      array('hasOne' => array(
        'MeasuresSumUser' => array(
          'className' => 'MeasuresSum',
          'foreignKey' => FALSE, 
          'conditions' => array(
            'MeasuresSumUser.parent_type' => 'user',
            'MeasuresSumUser.parent_id' => $user_id,
            'MeasuresSumUser.measure_id = Badge.measure_id', 
        ),
      )
    )));
    $this->bindModel(
      array('hasOne' => array(
        'MeasuresSumProject' => array(
          'className' => 'MeasuresSum',
          'foreignKey' => FALSE, 
          'conditions' => array(
            'MeasuresSumProject.parent_type' => 'project',
            'MeasuresSumProject.parent_id = Badge.project_id',
            'MeasuresSumProject.measure_id = Badge.measure_id', 
        ),
      )
    ))); 
    
    // Order by how close (percentage) we are to earning the Badge. Coalesce returns the first Not-NULL Value, so we'll try to sort by the Project's progress (which is null if no project), otherwise the User's progress, which should make a smooth/comprehensive ordering
    $order = 
      'COALESCE( (MeasuresSumProject.quantity_sum / Badge.quantity_goal), (MeasuresSumUser.quantity_sum / Badge.quantity_goal ) ) DESC';
    
    $conditions = array(
      'AND' => array(
        'AwardedBadge.id' => '', // we're looking for UN-awarded badges
      ),
    );
    
    // 
    if ($whose = 'self') {
       $conditions['AND']['Badge.user_id'] = $user_id;
    }
    elseif($whose = 'others') {
      $conditions['AND']['Badge.user_id <>' . $user_id];
    }
    elseif ($whose = 'all') {
      //no conditions, we're looking for everyone's badges
    }
    
    // Add the Project ID if set
    elseif (is_null($project_id)) {
      // do nothing
    }
    elseif (is_numeric($project_id)) {
      $conditions['AND']['Badge.project_id'] = $project_id;
    }
    elseif($project_id == FALSE) {
      // return 
      $conditions['AND']['Badge.project_id'] = '';
    }
    
    // Add the Measure ID if set
    if ($measure_id) {
      $conditions['AND']['Badge.measure_id'] = $measure_id;
    }
    
    // Add the Quantity Threshold if set
    if ($lt_quantity) {
      $conditions['AND']['Badge.quantity_goal < ' . $lt_quantity];
    }
    
    $badges = $this->find(
      $find, array(
        'conditions' => $conditions,
        'order' => $order,
    ));
    
    return $badges;
  }
  
  
  /**
   * Function findUserAwarded
   *
   * Returns a list of badges that have been awarded.
   *
   * @param $user_id 
   *   The user_id of the person who we are seeking badges for
   * @param $whose
   *   Are we looking for the user's own badges ('self') or 'all'
   * @param $find
   *   CakePHP's find parameter, e.g. all, first, etc.
   * @param $project_id
   *   Find badges that have been assigned to a particular project
   * @param $measure_id
   *   Find badges only for a particular measure
   * @return object Badge(s)
   */
  function findUserAwarded($user_id, $whose = 'self', $find = 'all', $project_id = NULL, $measure_id = NULL) {
    
    App::uses('AwardedBadge', 'Model');
    $this->AwardedBadge = new AwardedBadge;
    
    
  
  }
  
  function earnable($activity) {
    $user_id = $activity['Activity']['user_id'];
    $measure_id = $activity['Activity']['measure_id'];
    
    // 1. Try to find an unawarded badge for that user & project; can earn multiple badges
      if ( (isset($activity['Activity']['project_id'])) 
            && ($activity['Activity']['project_id' != 0]) ) {
        
        $badge = $this->find(
          'all', array('conditions' => 
            array('Measure.measure_si' => $find_measure))
        );
      
      
      }
    
    
    // 2. Try to find an unawarded badge just for that user; can earn multiple badges
    
    // 3. Try to find an unawarded badge for the measure in general; can earn just 1 badge
  
  }
}
