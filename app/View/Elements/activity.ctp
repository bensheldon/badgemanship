
<article id="activity_<?php echo $activity['Activity']['id'] ?>" class="activity">
  <p class="description"><?php echo $activity['Activity']['description'] ?></p>
  
  <footer>
    <p class="measure">
      <span class="label"><?php echo $activity['Activity']['measure'] ?></span>
       x 
      <span class="quantity"><?php echo $activity['Activity']['quantity'] ?></span>
    </p>
    <?php if ($activity['Project']['title']) : ?>
      <p class="project">
        <?php echo $this->Html->link($activity['Project']['title'], array('controller' => 'projects', 'action' => 'view', $activity['Project']['id'])) ?>
      </p> 
    <?php endif; ?>  
    <p class="author"><img src="<?php echo $activity['User']['image'] ?>" alt="<?php echo $activity['User']['screen_name'] ?>'s avatar"><?php echo $activity['User']['screen_name'] ?></p>
    <p class="published">
      <?php echo $this->Html->link(
              $this->Time->timeAgoInWords($activity['Activity']['created'], array('format' => 'd-m-Y', 'end' => '+1 month')),
              array('controller' => 'activity', 'action' => 'view', $activity['Activity']['id']),
              array('title' => 'Permalink')
        ) ?>
    </p>
    
  </footer>
</article>