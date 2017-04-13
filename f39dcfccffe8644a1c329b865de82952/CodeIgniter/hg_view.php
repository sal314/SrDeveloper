<?php


    echo <<< EOT
<!DOCTYP html>
<html>
  <head>
    <title>Hourglass</title>
    <style type="text/css">
      h2 {
        margin-left: 50px;
        margin-top: 50px;
      }
      label {
        width: 100px;
        float: left;
      }
      input[type='number'] {
        float: left;
      }
      .clear {
        clear: both;
      }
      .hourglass {
        margin: 20px 0 0 100px;
      }
      .hg {
        font-family: Courier;
      }
    </style>

  </head>

  <body>
    <h2>Hourglass Calculation</h2>
    <form id="hourForm" action="/index.php/hourglass" method="post">
      <div>
        <label>Size:</label>
        <input type="number" id="size" name="size" min="2" max="10" required />
      </div>
      <div class="clear"></div>
      <div>
        <label>Percent:</label>
        <input type="number" id="percent" name="percent" min="0" max="100" required />
      </div>
      <div class="clear"></div>
      <div>
        <input type="submit" id="okay" name="okay" value="Ok" />
      </div>
    </form>
    <div class="hourglass">
EOT;

    if (isset($result)) {
      echo "      <pre>\n";
      echo $result;
      echo "      </pre>\n";
    }


    echo <<< EOS
    </div>
  </body>
</html>
EOS;

