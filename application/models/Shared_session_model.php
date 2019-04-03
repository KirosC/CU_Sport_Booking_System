<?php
/**
 *
 */
class Shared_session_model extends CI_Model
{
    //Attribute
    public $session_id;      //Primary Key
    public $available_seats;
    public $description;

    public function new_shared_session($session_id, $available_seats, $description)
    {
      $this->session_id = $session_id;
      $this->available_seats = $available_seats;
      $this->description = $description;

      $this->db->insert('shared_session', $this);
    }

    public function get_shared_session()
    {

      $this->db->select(
        'shared_session.description AS description,
         shared_session.available_seats AS seats,
         session.start_time AS start_time,
         session.end_time AS end_time,
         college.name AS college,
         venue.name AS venue,
         CONCAT(user.first_name,  " ", user.last_name) AS fullname
        ');
      $this->db->from('shared_session');
      $this->db->join('session', 'session.session_id = shared_session.session_id');
      $this->db->join('venue', 'venue.venue_id = session.venue_id');
      $this->db->join('college', 'college.college_id = venue.college_id');
      $this->db->join('reserve', 'shared_session.session_id = reserve.session_id');
      $this->db->join('user', 'reserve.email = user.email');
      $query = $this->db->get();

      return $query->result();
    }

    public function get_shared_session_by_id($session_id)
    {
      $this->db->select(
        'shared_session.description AS description,
         shared_session.available_seats AS seats,
         session.name AS court,
         session.start_time AS start_time,
         session.end_time AS end_time,
         location.name AS facility,
         location.photo AS facility_photo,
         CONCAT(user.first_name,  " ", user.last_name) AS fullname,
         student.phone_no AS phone
        ');
      $this->db->from('shared_session');
      $this->db->join('session', 'session.session_id = shared_session.session_id');
      $this->db->join('location', 'location.location_id = session.location_id');
      $this->db->join('reserve', 'shared_session.session_id = reserve.session_id');
      $this->db->join('user', 'reserve.email = user.email');
      $this->db->join('student', 'student.email = user.email');
      $this->db->where('shared_session.session_id', $session_id);
      $query = $this->db->get();

      return $query->result();
    }
}
?>
