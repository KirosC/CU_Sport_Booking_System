<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//course controller handle course page and all functions relate to course
class Course extends SBooking_Controller
{

  //course main page
  public function course_main()
  {
    $this->load->model('Course_model');
    $this->load->model('Participate_model');

    $this->setTitle('Course');
    $this->setNav('course');

    $this->loadCSS('libraries/material-clear.css');
    $this->loadCSS('libraries/material-combobox.css');
    $this->loadCSS('libraries/material-textbox.css');
    $this->loadCSS('libraries/material-form.css');
    $this->loadCSS('course_listing.css');

    $data = $this->getHeaderData();

    $data['courses'] = $this->Course_model->course_search();//get all the course from db
    $data['seat_remain'] = array();//an array that store the remaining seats of each courses

    //calculae the remaining seats of each courses
    foreach ($data['courses'] as $course) {
      $data['date'] = substr($course->start_time, 0, 10);
      $data['start_time'] = substr($course->start_time, 11, 5);
      $data['end_time'] = substr($course->end_time, 11, 5);
      $seat_remain = $course->seats - $this->Participate_model->get_participate_by_id($course->course_id, 1);//total seats available - total participated user in that course
      array_push(
        $data['seat_remain'],
        $seat_remain
      );
    }

    $data['detail_url'] = $data['page_url'] . 'course/id/';

    $this->load->view('header', $data);
    $this->load->view('course', $data);
    $this->load->view('footer');
  }

  //course detail page
  public function detail()
  {
    $this->load->model('Course_model');
    $this->load->model('Participate_model');

    $this->setNav('course');

    $this->loadCSS('course_detail.css');
    $data = $this->getHeaderData();
    $course_id = $this->uri->segment(3);//get the course_id on the uri

    $data['course'] = $this->Course_model->get_course_detail_by_courseid($course_id);//get the detail information of the course
    $data['seat_remain'] = $data['course']->seats - $this->Participate_model->get_participate_by_id($course_id, 1);

    //get the date, time of the course
    $data['date'] = substr($data['course']->start_time, 0, 10);
    $data['start_time'] = substr($data['course']->start_time, 11, 5);
    $data['end_time'] = substr($data['course']->end_time, 11, 5);

    $this->setTitle('Course');
    $this->load->view('header', $data);
    $this->load->view('course_detail', $data);
    $this->load->view('footer');
  }

  //coach add course page
  public function add_course_page()
  {
    $this->load->model('College_model');
    $this->load->model('Sports_model');
    $this->load->model('Venue_model');
    $this->load->model('Level_model');
    $this->load->model('Session_model');

    $this->setNav('course');

    $this->loadCSS('libraries/bootstrap-table.min.css');
    $this->loadCSS('court_booking.css');
    $this->loadJS('libraries/bootstrap-table.min.js');
    $this->loadJS('libraries/moment.js');
    $this->loadJS('court_booking.js');
    $data = $this->getHeaderData();

    $data['colleges'] = $this->College_model->college_search();//get all the college name
    $data['sports'] = $this->Sports_model->get_sports();//get all the sport name
    $data['venues'] = $this->Venue_model->venue_search();//get all the venue name
    $data['sessions'] = $this->Session_model->get_available_session();//get all the session that is not booked
    $data['levels'] = $this->Level_model->getLevel();//get the level

    $this->load->view('header', $data);
    $this->load->view('course_add', $data);
    $this->load->view('footer');
  }

  //coach add course payment page
  public function check_add_course()
  {
    $this->load->model('Venue_model');
    $this->load->model('Level_model');

    $this->setNav('course');

    $this->loadCSS('course_add_payment.css');

    $data = $this->getHeaderData();

    $data['title'] = $_POST['title'];
    $data['level'] = $_POST['level'];
    $data['level_name'] = $this->Level_model->get_name($data['level'])->description;
    $data['description'] = $_POST['description'];
    $data['course_price'] = $_POST['price'];
    $data['course_seat'] = $_POST['people'];

    $data['date'] = $_POST['date'];
    $year = substr($data['date'], 0, 4);
    $month = substr($data['date'], 5, 2);
    $day = substr($data['date'], 8, 2);

    $data['venue_id'] = $_POST['venue'];
    $data['venue'] = $this->Venue_model->get_name($_POST['venue'])->venue;
    $data['sessions_time'] = array();
    //calculate the start_time and end_time base on selected time slot
    foreach ($_POST['time'] as $value) {
      $time = 8+substr($value, 5);
      $data['end_time'] = ($time + 1).":00";
      $start_time = date("Y-m-d H:i:s", mktime($time, 0, 0, $month, $day, $year));
      array_push($data['sessions_time'], $start_time);
    }
    $data['start_time'] = substr($data['sessions_time'][0], 11, 5);

    $price = $this->Venue_model->get_venue_price($data['venue_id'])->price;
    $data['court_price'] = $price * sizeof($data['sessions_time']);

    $data['sessions_time'] = json_encode($data['sessions_time']);

    $this->load->view('header', $data);
    $this->load->view('course_add_payment', $data);
    $this->load->view('footer');

  }

  //add course to the db
  public function course_add_payment_finish()
  {
    $this->load->model('Course_model');
    $this->load->model('Session_model');
    $this->load->model('Reserve_model');
    $this->load->model('Course_session_model');

    $title = $_POST['title'];
    $level_id = $_POST['level_id'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $seat = $_POST['seat'];
    $venue_id = $_POST['venue_id'];
    $sessions_time = $_POST['sessions_time'];
    $start = $_POST['date']." ".$_POST['start_time'].":00";
    $end = $_POST['date']." ".$_POST['end_time'].":00";

    //mark the selected time slot as reserve in db
    foreach ($sessions_time as $start_time) {
      $session_id = $this->Session_model->get_session_id($venue_id, $start_time)->session_id;
      $this->Reserve_model->new_reserve($_SESSION['email'], $session_id);
    }

    //add course to db
    $this->Course_model->new_course($title, $start, $end, $price, $seat, $description, $level_id, $_SESSION['email']);
    $course_id = $this->Course_model->get_course_id($title, $start, $end, $_SESSION['email'])->course_id;

    //add the linking of course and session
    foreach ($sessions_time as $start_time) {
      $session_id = $this->Session_model->get_session_id($venue_id, $start_time)->session_id;
      $this->Course_session_model->new_course_session($course_id, $session_id);
    }
  }

  //student apply course payment page
  public function apply_check()
  {
    $this->load->model('Course_model');
    $this->load->model('Participate_model');

    $this->setNav('course');

    $this->loadCSS('course_apply_payment.css');

    $data = $this->getHeaderData();

    $course_id = $this->uri->segment(3);

    $participates = $this->Participate_model->get_participate_by_id($course_id, 0);

    //check if user already apply the selected course
    foreach ($participates as $participate) {
      if ($_SESSION['email'] == $participate->email) {
        echo '<script>alert("You Have Already Join This Course!");</script>';
        redirect('course', 'refresh');
      }
    }
    $data['course'] = $this->Course_model->get_course_detail_by_courseid($course_id);
    $data['course_id'] = $course_id;

    $this->load->view('header', $data);
    $this->load->view('course_apply_payment', $data);
    $this->load->view('footer');
  }

  //add student participate the course to db
  public function course_apply_payment_finish()
  {
    $this->load->model('Participate_model');
    $this->Participate_model->new_participate($_SESSION['email'], $_POST['course_id']);
    redirect('course', 'refresh');

  }
}

?>
