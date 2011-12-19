<?php 
  $progress_percentage = ($badge['MeasuresSumUser']['quantity_sum'] / $badge['Badge']['quantity_goal']) * 100;
  $awarded = FALSE;
  if ($progress_percentage >= 100) {
    $progress_percentage = 100;
    $awarded = TRUE;
  }
?>

<?php //debug($badge); ?>


<article id="badge-<?php echo $badge['Badge']['id'] ?>" class="badge<?php  echo $awarded ? ' awarded' : ''?>">
  <h1><?php echo $badge['Badge']['title'] ?></h1>
  
  <div class="progress-meter">
    <div class="progress-meter-current" style="min-width:<?php echo $progress_percentage ?>%">
      <span>
        <?php if ($awarded) : ?>
          <?php echo $badge['Badge']['quantity_goal'] ?> <?php echo ($badge['Badge']['quantity_goal'] == 1 ? $badge['Measure']['measure_si'] : $badge['Measure']['measure_pl']) ?>   
        <?php else : ?>
          <?php echo $badge['MeasuresSumUser']['quantity_sum'] ?> <?php echo ($badge['MeasuresSumUser']['quantity_sum'] == 1 ? $badge['Measure']['measure_si'] : $badge['Measure']['measure_pl']) ?>
        <?php endif; ?>
        </span>
    </div>
  </div>




</article>