<div id="page-content">
  <?php foreach ($activities as $activity): ?>
    <?php echo $this->element('activity', array(
      "activity" => $activity
      )); ?>
  <?php endforeach; ?>
</div>