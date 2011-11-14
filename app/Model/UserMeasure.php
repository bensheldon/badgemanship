<?php
class UserMeasure extends AppModel {
  var $name = 'UserMeasure';
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'user_id',
    ),
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id',
    ),
  );
  
  public function addMeasure($user_id, $measure_id, $quantity, $created = false) {
    //Try to load the existing UserMeasure
    $user_measure = $this->find(
      'first', array('conditions' => 
        array(
          'UserMeasure.user_id' => $user_id,
          'UserMeasure.measure_id' => $measure_id,
        ))
    );
          
    if ($user_measure) {
      $this->create($user_measure);
      $this->set('quantity_sum', $this->data['UserMeasure']['quantity_sum'] + $quantity);
      $this->set('activity_sum', $this->data['UserMeasure']['activity_sum'] + 1);
      if ($created) {
        $this->set('modified', $created);
      }
      $this->save($this->data);
    }
    else {
      //Doesn't exist, need to create it
      $this->create();
      $this->set('measure_id', $measure_id);
      $this->set('user_id', $user_id);
      $this->set('quantity_sum', $quantity);
      $this->set('activity_sum', 1);
      if ($created) {
        $this->set('modified', $created);
      }
      $this->save($this->data);
    }
    return true;  
  }
}