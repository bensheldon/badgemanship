<?php

foreach($measures as $measure) {
  //debug($measure);
  echo "<p>";
  if ($measure['MeasuresSum']['quantity_sum'] == 1) {
    echo $measure['Measure']['measure_si'];
  }
  else {
    echo $measure['Measure']['measure_pl'];
  }
  
  echo ' x ' . $measure['MeasuresSum']['quantity_sum'];
  echo ' (' . $measure['MeasuresSum']['activity_count'] .' activities)';
  echo "</p>";
}