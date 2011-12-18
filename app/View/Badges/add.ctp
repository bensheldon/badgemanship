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

    echo $this->Form->end('Save Badge');
  ?>

</div>