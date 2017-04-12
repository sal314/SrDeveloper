<?php

$size = isset($_POST['size']) ? trim($_POST['size']) : "0";
$per = isset($_POST['percent']) ? trim($_POST['percent']) : "0";



function calcHourglass($s, $p) {
  // Some constants
  $base = "---------------------";
  $blanks = "                    ";

  $width = ($s * 2) + 1;                  //Total width of the hourglass
  $xs = pow($s, 2.0);                     //Total number of spaces for sand in the hourglass
  $top = round($xs * ($p / 100));         //Number of 'x' in the top part
  $bot = $xs - $top;                      //Number of 'x' in the bottom

  // Calculate the top of the hourglass (upside down array - gravity)
  $rowx = array();
  for ($i = 0; $i < $s; $i++) {                             //Loop thru each row
    $row = substr($blanks, 0, ($s - ($i + 1))) . "\\";      //Pad the beginning of the line
    $x = $i * 2 + 1;                                        //Number of spaces in this row
    if ($x > $top) {                                        //If row is wider than number left
      $part = $x - $top;                                    //Number of blanks in the middle
      $part1 = $part2 = floor(($x - $part) / 2);            //Number of 'x' on each side
      if (($x - $part) & 1) {                               //If it's an odd number
        $part2 += 1;                                        //Add one to the 2nd half
      }
      for ($j = 0; $j < $part1; $j++) {                     //Put 'x' in the first part
        $row .= "x";
      }
      for ($j = 0; $j < $part; $j++) {                      //Put blanks in the middle
        $row .= " ";
      }
      for ($j = 0; $j < $part2; $j++) {                     //Put 'x' in the last part
        $row .= "x";
      }
      $row .= "/";                                          //End of the row
      $top = 0;                                             //No more 'x' left
    }
    else {                                                  //If this is a full row
      for ($j = 0; $j < $x; $j++) {                         //Fill the row with 'x'
        $row .= "x";
      }
      $row .= "/";                                          //End of the row
      $top -= $x;                                           //Remove those 'x' from the total
    }
    array_push($rowx, $row);                                //Add this row to the array
  }
  array_push($rowx, substr($base, 0, $width));              //Add the top of the hourglass
  $rowx = array_reverse($rowx);                             //Reverse the array for the display

  //Calculate the bottom of the hourglass (upside down array)
  $rowb = array();
  array_push($rowb, substr($base, 0, $width));              //Add the bottom of the hourglass
  for ($i = $s-1; $i >= 0; $i--) {                          //Loop thru the rows of the bottom (backwards)
    $row = substr($blanks, 0, ($s - ($i + 1))) . "/";       //Pad the front of the row
    $x = $i * 2 + 1;                                        //Number of spaces in this row
    if ($x > $bot) {                                        //If there are more spaces than 'x' left
      $part = $x - $bot;                                    //Number of spaces to add
      $part1 = $part2 = floor($part / 2);                   //Half before and half after
      if (($part) & 1) {                                    //If odd number of spaces
        $part1 += 1;                                        //Put one more in the front
      }
      for ($j = 0; $j < $part1; $j++) {                     //Add spaces to the 1st part
        $row .= " ";
      }
      for ($j = 0; $j < $bot; $j++) {                       //Add 'x' to the row
        $row .= "x";
      }
      for ($j = 0; $j < $part2; $j++) {                     //Add spaces to the end
        $row .= " ";
      }
      $row .= "\\";                                         //End of the row
      $bot = 0;                                             //No more 'x' left
    }
    else {                                                  //Fill the row with 'x'
      for ($j = 0; $j < $x; $j++) {
        $row .= "x";
      }
      $row .= "\\";                                         //End of the row
      $bot -= $x;                                           //Subtract those 'x' from the total
    }
    array_push($rowb, $row);                                //Add the row to the array
  }
  $rowb = array_reverse($rowb);                             //Reverse this array
  $rowx = array_merge($rowx, $rowb);                        //And merge it with the top

  return $rowx;
}
  
?>

<!DOCTYPE html>
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
    <form id="hourForm" action="hourglass.php" method="post">
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

<?php
if ($size > 0) {
  echo "      <pre class='hg'>\n";
  $out = calcHourglass($size, $per);

  for ($i = 0; $i < count($out); $i++) {
    echo $out[$i] . "\n";
  }
  echo "      </pre>\n";
}
?>
  </body>

</html>
