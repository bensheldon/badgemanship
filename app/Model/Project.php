<?php

class Project extends AppModel {
  var $name = 'Project';
  var $order = array("Project.modified" => "DESC");
  var $actsAs = array('Containable');
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id'
    ),
  );
  var $hasMany =  array(
    'Activity' => array(            
      'className'    => 'Activity',            
      'foreignKey'   => 'project_id',
    ),
  );
  
  /**
   * beforeSave function
   */
//  function beforeSave() {
//    return TRUE;
//  }
  
  /**
   * afterSave function
   */
//  function afterSave() {
//    return TRUE;
//  } 
  
  /**
   * Called when an Activity is added to a Project
   */
  public function addActivity($activity) {
    if( (isset($activity['project_id'])) && ($activity['project_id'] != 0) ) {
      $this->read(null, $activity['project_id']);
      $this->set('activity_sum', $this->data['Project']['activity_sum'] + 1);
      $this->set('modified', $activity['created']);
      $this->save($this->data);
    }  
    return TRUE;  
  }
  
}
