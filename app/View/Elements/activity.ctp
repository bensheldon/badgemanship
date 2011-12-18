
<article id="activity_<?php echo $activity['Activity']['id'] ?>" class="activity">
  <p class="description"><?php echo $activity['Activity']['description'] ?></p>
  
  <footer>
    <p class="measure">
      <span class="label"><?php echo $activity['Activity']['measure'] ?></span>
       x 
      <span class="quantity"><?php echo $activity['Activity']['quantity'] ?></span>
    </p>

    <p class="author"><img src="<?php echo $activity['User']['image'] ?>" alt="<?php echo $activity['User']['username'] ?>'s avatar"><?php echo $activity['User']['username'] ?></p>
    <p class="published">
      <?php echo $this->Html->link(
              $this->Time->timeAgoInWords($activity['Activity']['created'], array('format' => 'd-m-Y', 'end' => '+1 month')),
              array('controller' => 'activity', 'action' => 'view', $activity['Activity']['id']),
              array('title' => 'Permalink')
        ) ?>
    </p>
    
  </footer>
</article>