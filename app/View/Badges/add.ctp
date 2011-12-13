<div id="page-header">
    <?php echo $this->element('nav-add', array('active' => 'badge')); ?>
</div>

<div id="page-content">

  <?php
    echo $this->Form->create('Badge');
    echo $this->Form->input('title');
    echo $this->Form->input('description', array('rows' => '3'));
    echo $this->Form->input('quantity_goal');
    echo $this->Form->input('measure');
    //debug($projects);
    $project_select = array();
    foreach($projects as $project) {
      $project_select[$project['Project']['id']] = $project['Project']['title'];
    }
    
    echo $this->Form->input('project_id', array('options' => $project_select, 'empty' => '--Select Project--'));
    echo $this->Form->end('Save Badge');
  ?>

</div>