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
   * @param $measure_id
   *   Find badges only for a particular measure
   * @param $lt_quantity
   *   Find badges whose quantity goal is less than this value
   *
   * @return object Badge(s)
   */
  function findUserProgress($user_id, $whose = 'self', $find = 'all', $measure_id = NULL, $lt_quantity = NULL) {
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
    
    //Bind measure's User Sumg
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
    
    // Order by how close (percentage) we are to earning the Badge.
    $order = '(MeasuresSumUser.quantity_sum / Badge.quantity_goal ) DESC';
    
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
   * @param $measure_id
   *   Find badges only for a particular measure
   * @return object Badge(s)
   */
  function findUserAwarded($user_id, $whose = 'self', $find = 'all', $measure_id = NULL) {
    
    App::uses('AwardedBadge', 'Model');
    $this->AwardedBadge = new AwardedBadge;
    
    
  
  }
  
  /**
   * Function awardForActivity
   *
   * Award badges for an activity
   *
   * @param $activity
   *   The activity after it has been saved and MeasuresSum appended to the object
   *
   * @return object Activity
   */
  function awardForActivity($activity) {
    $user_id = $activity['Activity']['user_id'];
    $measure_id = $activity['Activity']['measure_id'];
    $user_quantity = $activity['MeasuresSumUser']['quantity_sum'];
    
    $this->bindModel(
      array('hasOne' => array(
        'AwardedBadge' => array(
          'className' => 'AwardedBadge',
          'foreignKey' => 'badge_id',
          'conditions' => array('AwardedBadge.user_id' => $user_id), 
        ),
      )
    ));
  
    /**
     * #1. Try to find an unawarded badge for that user
     */
    $conditions = array(
      'AND' => array(
        'Badge.user_id' => $user_id,
        'Badge.measure_id' => $measure_id,
        'AwardedBadge.id' => '', // we're looking for UN-awarded badges
        'Badge.quantity_goal <=' => $user_quantity
        
      ),
    );
    
    $badges = $this->find(
      'all', array(
        'contain' => array('AwardedBadge'), //return the Badge and AwardedBadge (will be NULL)
        'conditions' => $conditions,
        //'order' => '',
    ));
        
    if (!$badges) {
      /**
       * 2. Try to find an unawarded badge for the measure in general; 
       *    can earn just 1 badge
       */
       
       // rebind the model after every find
       $this->bindModel(
         array('hasOne' => array(
           'AwardedBadge' => array(
             'className' => 'AwardedBadge',
             'foreignKey' => 'badge_id',
             'conditions' => array('AwardedBadge.user_id' => $user_id), 
           ),
         )
       ));
       
      $conditions = array(
        'AND' => array(
          'Badge.user_id <>' => $user_id,
          'AwardedBadge.id' => '', // we're looking for UN-awarded badges
        ),
      );
      
      $badges = $this->find(
        'first', array( // just return 1 badge 
          'contain' => array('AwardedBadge'), //return the Badge and AwardedBadge (will be NULL)
          'conditions' => $conditions,
          //'order' => '',
      ));
    }
    
    if (!$badges) {
      return $activity;
    }
    else {
      // unset the empty AwardedBadge data
      foreach($badges as &$badge) {
        unset($badge['AwardedBadge']);
                
        // Actually award the badges
        $this->AwardedBadge->create();
        $awarded_badge = array();
        $awarded_badge = array(
          'badge_id' => $badge['Badge']['id'],
          'user_id' => $user_id,
          'created' => $activity['Activity']['created'],
          'measure_id' => $badge['Badge']['measure_id'],
          'activity_id' => $activity['Activity']['id'],
        );
        // Save the awardedbadgea nd add it to the badge object
        $awarded_badge = $this->AwardedBadge->save($awarded_badge);
        $badge['AwardedBadge'] = $awarded_badge['AwardedBadge'];
      }
      
      //append the saved awarded badge to the $activity object
      $activity['AwardedBadge'] = $badges;
      return $activity;
    }
    
  }
}
