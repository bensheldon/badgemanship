<div id="page-header">
    <?php echo $this->element('nav-add', array('active' => 'project')); ?>
</div>

<div id="page-content">

  <?php
    echo $this->Form->create('Project');
    echo $this->Form->input('title', array('rows' => '1'));
    echo $this->Form->input('description', array('rows' => '3'));
    echo $this->Form->end('Save Project');
  ?>

</div>