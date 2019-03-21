<?php
/**
 *
 */
class SBooking_Controller extends CI_Controller
{
  private $page_url, $image_url, $css_url, $js_url;
  private $header_data;

  public function __construct()
  {
    parent::__construct();
    $this->page_url = base_url().'index.php/';
    $this->image_url = base_url().'image/';
    $this->css_url = base_url().'css/';
    $this->js_url = base_url().'js/';

    $this->header_data = array(
      'title' => '',
      'page_url' => $this->page_url,
      'image_url' => $this->image_url,
      'css_file' => array(),
      'js_file' => array()
    );
  }

  protected function setTitle($title)
  {
    $this->header_data['title'] = $title;
  }

  protected function getHeaderData()
  {
    return $this->header_data;
  }

}

?>