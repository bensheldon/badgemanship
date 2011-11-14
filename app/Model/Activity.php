<?php

class Activity extends AppModel {
  var $name = 'Activity';
  
  var $order = array("Activity.created" => "DESC");
  
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id'
    ),
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id'
    ),
  );
  
  function beforeSave() {
    App::uses('Measure', 'Model');
    
     //Add the User_id if not set
//    if (empty($this->data['Activity']['user_id'])) {
//      $this->data['Activity']['user_id'] =  $this->Auth->user('id');
//    }
     
    // Associate a Measure if not set
    if (empty($this->data['Activity']['measure_id'])) {
      $measure = $this->Measure->saveMeasure($this->data['Activity']['measure'], $this->data['Activity']['quantity']);
      $this->data['Activity']['measure_id'] = $measure['Measure']['id'];
    }
  
    return TRUE;
  }
  
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
  
  function afterSave() {
    App::uses('UserMeasure', 'Model');
    $this->UserMeasure = new UserMeasure;
    //Add to the User's totals
    $this->UserMeasure->addMeasure(
      $this->data['Activity']['user_id'],
      $this->data['Activity']['measure_id'],
      $this->data['Activity']['quantity'],
      $this->data['Activity']['created']);
    return TRUE;
  } 
}
