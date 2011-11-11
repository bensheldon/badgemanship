<h1>Add Activity</h1>
<?php
echo $this->Form->create('Activity');
echo $this->Form->input('description', array('rows' => '3'));
echo $this->Form->input('quantity');
echo $this->Form->input('measure');
echo $this->Form->end('Save Activity');
?>