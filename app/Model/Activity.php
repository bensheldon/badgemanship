<?php

class Activity extends AppModel {
  var $name = 'Activity';
  var $order = array("Activity.created" => "DESC");
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
  
  /**
   * beforeSave function
   */
  function beforeSave() {
    App::uses('Measure', 'Model');
     
    // Associate a Measure if not set
    if (empty($this->data['Activity']['measure_id'])) {
      $measure = $this->Measure->saveMeasure($this->data['Activity']['measure'], $this->data['Activity']['quantity']);
      $this->data['Activity']['measure_id'] = $measure['Measure']['id'];
    }
  
    return TRUE;
  }
  
  /**
   * afterSave function
   */
  function afterSave() {
    App::uses('MeasuresSum', 'Model');
    $this->MeasuresSum = new MeasuresSum;
    App::uses('Badge', 'Model');
    $this->Badge = new Badge;
    
    $activity = $this->data;
    
    //Add to the User's totals
    $user_sum = $this->MeasuresSum->addMeasure(
      'user',
      $activity['Activity']['user_id'],
      $activity['Activity']['measure_id'],
      $activity['Activity']['quantity'],
      $activity['Activity']['created']
    );
    $activity['MeasuresSumUser'] = $user_sum['MeasuresSum'];
      
    // if there is a Project ID, we need to associate it
    if( (isset($activity['Activity']['project_id']))
          && ($activity['Activity']['project_id'] != 0) ) {
      App::uses('Project', 'Model');
      $this->Project = new Project;
      $activity = $this->Project->addActivity($activity);
    }
    
    debug($activity);
    
    // Search for and award eligible badges
    $this->Badge->awardForActivity($activity);
    
    return TRUE;
  } 
  
  /**
   * Rebuilds a User's aggregated measure data
   */
  public function rebuildUser($user_id) {
    App::uses('Activity', 'Model');
    App::uses('Measure', 'Model');
    App::uses('UserMeasure', 'Model');
    $this->UserMeasure = new UserMeasure;
    
    // load the user's activities
    $activities = $this->find(
      'all', array(
        'conditions' => array('Activity.user_id' => $user_id),
        'order' => array('Activity.created ASC'),
      )
    );
    
    // delete all the UserMeasures's aggregated
    $this->UserMeasure->deleteAll(array('UserMeasure.user_id' => $user_id), false);
    
    foreach ($activities as $activity) {
      // Associate a Measure if not set
      if (empty($this->data['Activity']['measure_id']) || $this->data['Activity']['measure_id'] == 0) {
        $measure = $this->Measure->saveMeasure($activity['Activity']['measure'], $activity['Activity']['quantity']);
        $activity['Activity']['measure_id'] = $measure['Measure']['id'];
      }  

      $this->UserMeasure = new UserMeasure;
      $this->UserMeasure->addMeasure(
        $activity['Activity']['user_id'],
        $activity['Activity']['measure_id'],
        $activity['Activity']['quantity'],
        $activity['Activity']['created']);    
    }  
  }
}
