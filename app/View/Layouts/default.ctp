<!doctype html>
<html>
<head>
  <meta charset="utf-8">

  <title><?php echo $title_for_layout; ?></title>

  <!-- Mobile viewport optimization http://goo.gl/b9SaQ -->
  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Mobile IE allows us to activate ClearType technology for smoothing fonts for easy reading -->
  <meta http-equiv="cleartype" content="on">

  <!-- Main Stylesheet -->
  <?php   	  	
    // echo $this->Html->css('cake.generic');
    echo $this->Html->css('style');
		echo $scripts_for_layout;
	?>

</head>

<body>
    <?php echo $this->element('topbar'); ?>

<<<<<<< .merge_file_Wftk9y
  <?php echo $this->element('topbar'); ?>

  <div class="container">

    <div id="main" role="main">
      <?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
    </div>
=======
   <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Page name <small>Supporting text or tagline</small></h1>
        </div>
      <div id="main" role="main">
        <?php echo $this->Session->flash(); ?>
  			<?php echo $content_for_layout; ?>
      </div>
>>>>>>> .merge_file_exvM5B

    <footer>

	    <?php echo $this->element('sql_dump'); ?>
    </footer>
  </div> <!--! end of ./container -->


  <!-- JavaScript at the bottom for fast page loading -->

<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.0.min.js"><\/script>')</script>

  <?php
    // echo $this->Html->css('cake.generic');
    echo $this->Html->script('libs/bootstrap-dropdown.js');
    echo $this->Html->script('scripts');
  ?>

  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
  <script>
    var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>





</body>
</html>
