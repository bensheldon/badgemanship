<div id="page-header">
    <?php echo $this->element('nav-add', array('active' => 'activity')); ?>
</div>

<div id="page-content">

  <form action="/activities/add" id="ActivityAddForm" method="post" accept-charset="utf-8">
    <div class="quantity-measure">
      <div class="input-quantity">
        <label for="ActivityQuantity">Quantity</label>
        <input name="data[Activity][quantity]"id="ActivityQuantity" placeholder="# of...">
      </div>
      
      <div class="label-x">X</div>
      
      <div class="input-measure">
        <label for="ActivityMeasure">Measure</label>
        <input name="data[Activity][measure]" id="ActivityMeasure" placeholder="label e.g. cats, hours of sleep...">
      </div>
      
      <div class="input-description">
        <label for="ActivityDescription">Desription</label>
        <textarea name="data[Activity][description]" rows="3" id="ActivityMeasure" placeholder="a description of the event or data..."></textarea>
      </div>
      
      <div class="submit"><input type="submit" value="Save Activity"></div>
      
  </form>
</div> <!-- /#page-content -->