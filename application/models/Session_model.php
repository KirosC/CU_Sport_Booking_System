<?php
/**
 *
 */
class Session_model extends CI_Model
{
    //Attribute
    public $session_id;     //Primary Key
    public $name;
    public $start_time;
    public $end_time;
    public $location_id;

    //Function
    //New Session (New Entry)
    public function new_session($name, $start_time, $end_time, $location_id)
    {
        //session_id will be generated automatically
        $this->name = $name;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->location_id = $location_id;

        $this->db->insert('session', $this);
    }

    //Update Session (Update Entry)
    public function update_session($session_id, $name, $datetime, $location)
    {
        $this->$name = $name;
        $this->$datetime = $datetime;
        $this->$location = $location;

        $this->db->where('session_id', $session_id);
        $this->db->update('session', $this);
    }

    //Delete Session (Delete Entry)
    public function delete_session($session_id)
    {
        $this->db->where('session_id', $session_id);
        $this->db->delete('session');
    }

    public function get_available_session()
    {
      $this->db->select('*');
      $this->db->from('session');
      $this->db->join('reserve', 'session.session_id = reserve.session_id', 'left');
      $query = $this->db->get();

      $allsession = $query->result();
      $available = array();

      foreach ($allsession as $session) {
        if ($session->email == NULL) {
          array_push($available, $session);
        }
      }
      return $available;
    }

    //Get Name
    public function get_name($session_id)
    {
        $this->db->select('name');
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('session');

        return $query->result();
    }

    //Get DateTime
    public function get_datetime($session_id)
    {
        $this->db->select('datetime');
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('session');

        return $query->result();
    }

    //Get Location
    public function get_location($session_id)
    {
        $this->db->select('location');
        $this->db->where('session_id', $session_id);
        $query = $this->db->get('session');

        return $query->result();
    }
}
