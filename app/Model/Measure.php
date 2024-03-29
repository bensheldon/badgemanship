<?php

class Measure extends AppModel {
  var $name = 'Measure';
  
  var $hasMany = array(
    'Activity' => array(
                'className'     => 'Activity',
                'foreignKey'    => 'measure_id',
                'order'         => 'Activity.created DESC',
                'limit'         => '5',
                'dependent'     => false,
                )
    );
  
  public $virtualFields = array(
      'users_count' => 'Measure.measures_sum_count'
  );
  
  //var $order = array("Measure.id" => "DESC");
  
  
  public function saveMeasure($find_measure = '', $quantity = 0) {
    App::uses('Core','Inflector');
    
    // Strip out double spaces, tabs and newlines
    $find_measure = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $find_measure);
  
    if ($isSingle = $this->isSingle($quantity)) {
      $measure = $this->find(
        'first', array('conditions' => 
          array('Measure.measure_si' => $find_measure))
      );
    }
    else {
      $measure = $this->find(
        'first', array('conditions' => 
          array('Measure.measure_pl' => $find_measure)
      ));
    }
    
    if ($measure) {
      return $measure;
    }
    else {
      $this->create();
      if ($isSingle) {
        $this->set('measure_si', $find_measure);
        $this->set('measure_pl', Inflector::pluralize($find_measure));
      }
      else {
        $this->set('measure_pl', $find_measure);
        $this->set('measure_si', Inflector::singularize($find_measure));
      }
      $this->save();
      return $this->read();
    }
  }
  
  private function isSingle($quantity) {
    if ( (int) $quantity == 1 ) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }
}
