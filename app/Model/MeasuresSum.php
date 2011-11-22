<?php
class MeasuresSum extends AppModel {
  var $name = 'MeasuresSum';
  var $actsAs = array('Containable');
  
  var $belongsTo =  array(
    'Measure' =>array(
      'className'    => 'Measure',
      'foreignKey'   => 'measure_id',
      'counterCache' => true,
      'counterScope' => array('MeasuresSum.parent_type' => 'user'), // Only count users
    ),
    'User' => array(            
      'className'    => 'User',            
      'foreignKey'   => 'parent_id',
      'conditions' => array('parent_type' => 'user'),
      'counterCache' => true,
      'counterScope' => array('MeasuresSum.parent_type' => 'user'),
    ),
    'Project' => array(            
      'className'    => 'Project',            
      'foreignKey'   => 'parent_id',
      'conditions' => array('parent_type' => 'project'),
      'counterCache' => true,
      'counterScope' => array('MeasuresSum.parent_type' => 'project'),
    ),
  );
  
  public function addMeasure($parent_type, $parent_id, $measure_id, $quantity, $created = false) {
    //Try to load the existing UserMeasure
    $measures_sum = $this->find(
      'first', array('conditions' => 
        array(
          'MeasuresSum.parent_type' => $parent_type,
          'MeasuresSum.parent_id' => $parent_id,
          'MeasuresSum.measure_id' => $measure_id,
        ))
    );
          
    if ($measures_sum) {
      $this->create($measures_sum);
      $this->set('quantity_sum', $this->data['MeasuresSum']['quantity_sum'] + $quantity);
      $this->set('activity_count', $this->data['MeasuresSum']['activity_count'] + 1);
      if ($created) {
        $this->set('modified', $created);
      }
      $this->save($this->data);
    }
    else {
      //Doesn't exist, need to create it
      $this->create();
      $this->set('measure_id', $measure_id);
      $this->set('parent_type', $parent_type);
      $this->set('parent_id', $parent_id);
      $this->set('quantity_sum', $quantity);
      $this->set('activity_count', 1);
      if ($created) {
        $this->set('modified', $created);
      }
      $this->save($this->data);
    }
    return true;  
  }
}