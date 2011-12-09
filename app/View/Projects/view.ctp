<?php debug($project) ?>
<h2>Project: <?php echo $project['Project']['title'] ?></h2>

<?php foreach ($project['Activity'] as $activity): ?>
  <?php
    $activity['Activity'] = $activity;
    $activity['User'] = $project['User'];
    $activity['Project'] = $project['Project'];
    echo $this->element('activity', array(
      "activity" => $activity
    )); 
  ?>
<?php endforeach; ?>