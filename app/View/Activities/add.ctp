<div id="page-header">

  <h1>Add Activity</h1>

</div>

<div id="page-content">

  <?php
    echo $this->Form->create('Activity');
    echo $this->Form->input('description', array('rows' => '3'));
    echo $this->Form->input('quantity');
    echo $this->Form->input('measure');
    //debug($projects);
    $project_select = array();
    foreach($projects as $project) {
      $project_select[$project['Project']['id']] = $project['Project']['title'];
    }
    
    echo $this->Form->input('project_id', array('options' => $project_select, 'empty' => '--Select Project--'));
    echo $this->Form->end('Save Activity');
  ?>

</div>