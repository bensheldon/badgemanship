<div id="add-nav" class="secondary-nav">
  
  <ul>
      <li>Add: </li>
      <?php if ($active == 'activity') : ?>
        <li class="active"><span>Activity</span></li>
      <?php else : ?>
        <li><?php echo $this->Html->link('Activity', array('controller' => 'activities', 'action' => 'add')) ?></li>
      <?php endif; ?>
  
    <?php if ($active == 'badge') : ?>
      <li class="active"><span>Badge</span></li>
    <?php else : ?>
      <li><?php echo $this->Html->link('Badge', array('controller' => 'badges', 'action' => 'add')) ?></li>
    <?php endif; ?>
  </ul>
</div>