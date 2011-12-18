<div id="page-header">
    <?php echo $this->element('nav-add', array('active' => 'activity')); ?>
</div>

<div id="page-content">

  <?php
    echo $this->Form->create('Activity');
    echo $this->Form->input('description', array('rows' => '3'));
    echo $this->Form->input('quantity');
    echo $this->Form->input('measure');

    echo $this->Form->end('Save Activity');
  ?>

</div>