<?php

class Project extends AppModel {
  var $name = 'Project';
  var $order = array("Project.modified" => "DESC");
  var $actsAs = array('Containable');
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id',
      'counterCache' => true,
    ),
  );
  var $hasMany =  array(
    'Activity' => array(            
      'className'    => 'Activity',            
      'foreignKey'   => 'project_id',
    ),
  );
  
  public $virtualFields = array(
      'measures_count' => 'Project.measures_sum_count'
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
    // Save the project info
    if( (isset($activity['project_id'])) && ($activity['Activity']['project_id'] != 0) ) {
      $this->read(null, $activity['Activity']['project_id']);
      $this->set('activity_sum', $this->data['Project']['activity_sum'] + 1);
      $this->set('modified', $activity['Activity']['created']);
      $this->save($this->data);
    }
    
    //Add to the Project's Measures totals
    $this->MeasuresSum = new MeasuresSum;
    $this->MeasuresSum->addMeasure(
      'project',
      $activity['Activity']['project_id'],
      $activity['Activity']['measure_id'],
      $activity['Activity']['quantity'],
      $activity['Activity']['created']);
    
    
    return TRUE;  
  }
  
}
