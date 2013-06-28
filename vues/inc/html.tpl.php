<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title align="left" > <?php print $titre ?> </title>
        <?php print getStyles() ?>
        <?php print getScripts() ?>
        <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.png" />
        <link rel="alternate" type="application/rss+xml" title="Les 10 derniers Chuck Norris Facts" href="xml/facts.xml" />
    </head>

    <body>
        <?php print $page ?>
        <a href="/login" class="cache">A</a>
    </body>
    <?php /*
      <script type="text/javascript">
      var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
      document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
      </script>
      <script type="text/javascript">
      try {
      var pageTracker = _gat._getTracker("UA-2082572-1");
      pageTracker._trackPageview();
      } catch(err) {}
      </script> */ ?>
</html>
