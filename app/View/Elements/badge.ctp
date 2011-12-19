<?php 
  $progress_percentage = ($badge['MeasuresSumUser']['quantity_sum'] / $badge['Badge']['quantity_goal']) * 100;
  if ($progress_percentage >= 100) {
    $progress_percentage = 100;
  }
?>

<?php //debug($badge); ?>


<article id="badge-<?php echo $badge['Badge']['id'] ?>" class="badge">
  <h1><?php echo $badge['Badge']['title'] ?></h1>
  
  <div class="progress-meter">
    <div class="progress-meter-current" style="min-width:<?php echo $progress_percentage ?>%">
      <span><?php echo $badge['MeasuresSumUser']['quantity_sum'] ?> <?php echo ($badge['MeasuresSumUser']['quantity_sum'] == 1 ? $badge['Measure']['measure_si'] : $badge['Measure']['measure_pl']) ?></span>
    </div>
  </div>




</article>