<h1>Add Activity</h1>
<?php
echo $this->Form->create('Project');
echo $this->Form->input('title', array('rows' => '1'));
echo $this->Form->input('description', array('rows' => '3'));
echo $this->Form->end('Save Project');
?>