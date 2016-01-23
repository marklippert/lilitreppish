<?php
header("Cache-Control: no-transform"); // Fix AT&T's wireless servers gzipping bullshit (random characters on page)
// ob_start('ob_gzhandler'); also works
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    
    <title>Lili Treppish<?php if ($PageTitle != "") echo " | " . $PageTitle; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    
    <meta name="description" content="A photo gallery of Lili Treppish, born November 6, 2011.">
    <meta name="keywords" content="">
    <meta name="author" content="Mark Lippert">
    
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="inc/main.css">
    
    <script type="text/javascript" src="inc/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="inc/jquery.cycle2.min.js"></script>
    <script type="text/javascript" src="inc/jquery.swipebox.min.js"></script>
    <link rel="stylesheet" href="inc/swipebox.css">
    <script type="text/javascript">
      $(document).ready(function() {
        $("a[href^='http'], a[href$='.pdf']").not("[href*='" + window.location.host + "']").attr('target','_blank');
        $(".swipebox").swipebox();
      });
    </script>
    
    <!--[if lt IE 9]><script src="inc/modernizr-2.6.2-respond-1.1.0.min.js"></script><![endif]-->
    <!--[if lt IE 7 ]>
    <script type="text/javascript" src="inc/dd_belatedpng.js"></script>
    <script type="text/javascript">DD_belatedPNG.fix('img, .png');</script>
    <![endif]-->
  </head>
  <body>
    
    <div id="wrap">
      <header>
        <div class="cycle-slideshow" data-cycle-speed="2000" data-cycle-timeout="6000">
          <img src="images/lili-header4.png" alt="">
          <img src="images/lili-header3.png" alt="">
          <img src="images/lili-header2.png" alt="">
          <img src="images/lili-header1.png" alt="">
        </div>
      </header>
      
      <article>
        <?php
        $main_dir = ($_SERVER['QUERY_STRING'] != "") ? $_SERVER['QUERY_STRING'] : "gallery";

        $files = scandir($main_dir);
        foreach($files as $file) {
          // Ignore non-files
          if ($file == "." || $file == "..") continue;

          // Put results into an array
          $results[] = $main_dir . "/" . $file;
        }

        natcasesort($results);
        $results = array_reverse($results, true);

        foreach($results as $result) {
          if (is_file($result)) {
            list($width, $height, $type, $attr) = getimagesize($result);

            $ratio = ceil(($width / $height) * 100);
            $adjust = ($ratio - 100) / 2;

            $adj_pos = ($width/$height > 1) ? "width: " . $ratio . "%; left: -" . $adjust . "%;" : "width: 100%; top: " . $adjust . "%;";

            $name = pathinfo(str_replace("_", " ", basename($result)), PATHINFO_FILENAME);

            echo "<div class=\"resize\"><a href=\"$result\" class=\"swipebox\"><img src=\"$result\" alt=\"$name\" style=\"$adj_pos\"></a></div>\n";
          } else {
            $name = str_replace("_", " ", basename($result));
            echo "<div class=\"resize\"><a href=\"?$result\" class=\"folder\">$name</a></div>\n";
          }
        }
        ?>

        <div style="clear: both;"></div>
      </article>
      
      <footer></footer>
    </div> <!-- END wrap -->

  </body>
</html>