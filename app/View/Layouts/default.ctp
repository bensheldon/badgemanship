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

  <div id="container">
    <header>
      <h1><a href="/">Badgemanship</a></h1>
      <a href="/activities/add" id="add-activity">+</a>
    </header>
    <div id="main" role="main">
      <?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
    </div>

    <footer>

	    <?php echo $this->element('sql_dump'); ?>
    </footer>
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="js/libs/jquery-1.6.2.min.js"><\/script>')</script>

  <!-- mathiasbynens.be/notes/async-analytics-snippet Change UA-XXXXX-X to be your site's ID -->
  <script>
    var _gaq=[["_setAccount","UA-XXXXX-X"],["_trackPageview"]];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
    g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
    s.parentNode.insertBefore(g,s)}(document,"script"));
  </script>

</body>
</html>
