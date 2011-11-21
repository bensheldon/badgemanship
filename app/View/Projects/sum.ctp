<?php

foreach($measures as $measure) {
  echo "<p>";
  if ($measure['UserMeasure']['quantity_sum'] == 1) {
    echo $measure['Measure']['measure_si'];
  }
  else {
    echo $measure['Measure']['measure_pl'];
  }
  
  echo ' x ' . $measure['UserMeasure']['quantity_sum'];
  echo "</p>";
}