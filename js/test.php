<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="microid" content="mailto+http:sha1:566841e568e84b46c92d2291b44b836dfddc5c42" />
    <title>timeago: a jQuery plugin</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
    <script src="jquery.timeago.js" type="text/javascript"></script>
    <script src="test_helpers.js" type="text/javascript"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        prepareDynamicDates();
        $("abbr.timeago").timeago();

        /*$("#prog_date").text(jQuery.timeago(new Date()));
        $("#prog_string").text(jQuery.timeago("2008-07-17"));
        $("#prog_element").text(jQuery.timeago("2008-07-20"));*/
      });

    </script>
    
  </head>
  <body>
    <div id="content">
      
       <p class="example">
        You opened this page <abbr class="loaded timeago">when you opened the page</abbr>. <span class="help">(This will update every minute. Wait for it.)</span>
      </p>
      <p class="example">
        This page was last modified <abbr class="modified timeago">sometime before now [browser might not support document.lastModified]</abbr>.
      </p>
      <p class="example">
        Ryan was born <abbr class="timeago" title="1978-12-18T17:17:00Z">Dec 18, 1978</abbr>.
      </p>

      
    </div>
    

    

    
    
  </body>
</html>