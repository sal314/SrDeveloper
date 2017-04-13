<?php

class Hourglass extends CI_controller {

  public $data;

  public function __construct() {
    parent::__construct();
    $this->load->model('hg_model');
  }

  public function view() {
    $this->data = array();
    if ($this->input->post('size') != NULL) {
      $this->data['size'] = $this->input->post('size');
      $this->data['percent'] = $this->input->post('percent');
      $this->data['result'] = $this->hg_model->calcHourglass($this->data);
    }

    $this->load->view('hg_view', $this->data);
  }
}
?>
