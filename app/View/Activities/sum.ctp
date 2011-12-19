
<div id="page-content">
  <table class="bordered-table zebra-striped">
     <thead>
      <tr>
        <th>Measure</th>
        <th>Sum</th>
        <th># of Activities</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($measures as $measure) {
        //debug($measure);
        echo "<tr>";
        if ($measure['MeasuresSum']['quantity_sum'] == 1) {
          echo '<td>' .  $measure['Measure']['measure_si'] . '</td>';
        }
        else {
          echo '<td>' . $measure['Measure']['measure_pl'] . '</td>';
        }
        
        echo '<td>' . $measure['MeasuresSum']['quantity_sum'] . '</td>';
        echo '<td>' . $measure['MeasuresSum']['activity_count'] .'</td>';
        echo "</tr>";
      } ?>
    </tbody>
  </table>
</div>