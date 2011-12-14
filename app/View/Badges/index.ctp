<div id="page-content">
  <?php foreach ($badges as $badge): ?>
    <?php echo $this->element('badge', array(
      "badge" => $badge,
      )); ?>
  <?php endforeach; ?>
</div>