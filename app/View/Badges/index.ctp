<div id="page-header">
    <h1>Badges</h1>
</div>


<div id="page-content">
  <?php foreach ($badges as $badge): ?>
    <?php echo $this->element('badge', array(
      "badge" => $badge,
      )); ?>
  <?php endforeach; ?>
</div>