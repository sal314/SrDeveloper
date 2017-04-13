<?php
class Hg_model extends CI_model {
  public function __construct() {
    parent::__construct();
  }


  public function calcHourglass($inp) {
    //Check to see if this has been run before
    $result = $this->checkResults($inp);
    if ($result != NULL) {
      return $result;
    }

    // Some constants
    $base = "---------------------";
    $blanks = "                    ";

    $data = $this->getGeometry($inp['size']);
    $data['percent'] = $inp['percent'];

    $width = ($data['size'] * 2) + 1;       //Total width of the hourglass
    $xs = $data['sand'];                    //Total number of spaces for sand in the hourglass
    $top = round($xs * ($inp['percent'] / 100));         //Number of 'x' in the top part
    $bot = $xs - $top;                      //Number of 'x' in the bottom

    // Calculate the top of the hourglass (upside down array - gravity)
    $rowx = array();
    for ($i = 0; $i < $data['size']; $i++) {                  //Loop thru each row
      $row = substr($blanks, 0, ($data['size'] - ($i + 1))) . "\\";      //Pad the beginning of the line
      $x = $data['lines'][$i];                                //Number of spaces in this row
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
    for ($i = $data['size']-1; $i >= 0; $i--) {               //Loop thru the rows of the bottom (backwards)
      $row = substr($blanks, 0, ($data['size'] - ($i + 1))) . "/";       //Pad the front of the row
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

    $result = "";
    for ($i = 0; $i < count($rowx); $i++) {
      $result .= $rowx[$i] . "\n";
    }

    $this->saveResults($data, $result);

    return $result;
  }




  public function getGeometry($size) {
    $this->load->database();

    $str = "SELECT * FROM size_geometry " .
               "WHERE hg_size = " . $size;
    $query = $this->db->query($str);

    $ret = array();
    $ret['lines'] = array();
    foreach ($query->result_array() as $row) {
      $ret['size'] = $row['hg_size'];
      $ret['sand'] = $row['hg_spaces'];
    }

    $str = "SELECT * FROM lines_geometry " .
               "WHERE l_number <= " . $size . " " .
               "ORDER BY l_number";
    $query = $this->db->query($str);

    foreach($query->result_array() as $row) {
      array_push($ret['lines'], $row['l_size']);
    }

    $this->db->close();

    return $ret;
  }


  private function checkResults($data) {
    $this->load->database();

    $str = "SELECT * FROM results " .
               "WHERE hg_size = " . $data['size'] . " " .
               "AND hg_percent = " . $data['percent'];
    $query = $this->db->query($str);

    $ret = NULL;
    foreach ($query->result_array() as $row) {
      $ret = $row['string'];
    }

    $this->db->close();
    return $ret;
  }


  private function saveResults($data, $result) {
    $this->load->database();

    $tbl = array('hg_size' => $data['size'],
                 'hg_percent' => $data['percent'],
                 'string' => $result);
    $this->db->insert('results', $tbl);
    return;
  }
}
?>
