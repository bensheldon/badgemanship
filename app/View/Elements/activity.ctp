
<article id="activity_<?php echo $activity['Activity']['id'] ?>" class="activity">
  <p class="description"><?php echo $activity['Activity']['description'] ?></p>
  <dl>
    <dt><?php echo $activity['Activity']['measure'] ?></dt>
    <dd><?php echo $activity['Activity']['quantity'] ?></dd>
  </dl>
  <footer>
    <img src="<?php echo $activity['User']['image'] ?>" alt="<?php echo $activity['User']['screen_name'] ?>'s avatar"><?php echo $activity['User']['screen_name'] ?>
  </footer>
  
</article>