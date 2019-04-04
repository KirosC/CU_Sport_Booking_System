<?php
/**
 *
 */
require_once(APPPATH . "/models/User_model.php");
class Coach_model extends CI_Model
{
    //Attribute
    public $email;                  //Primary Key
    public $self_introduction;
    public $experience;

    //Function
    //New User & Coach (New Entry)
    public function new_coach($email, $self_introduction="NA", $experience="NA")
    {
        $this->email = $email;
        $this->self_introduction = $self_introduction;
        $this->experience = $experience;

        $this->db->insert('coach', $this);
    }

    //Warning - User can't change their email
    //Update User & Coach (Update Entry)
    public function update_coach($email, $password, $username, $first_name, $last_name, $icon, $self_introduction, $experience)
    {
        $this->password = $password;
        $this->username = $username;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->icon = $icon;
        $this->self_introduction = $self_introduction;
        $this->experience = $experience;

        $this->db->where('email', $email);
        $this->db->update('user', $User_model);

        $this->db->where('email', $email);
        $this->db->update('coach', $this);

    }

    //Delete Coach (Delete Entry)
    public function delete_coach($email)
    {
        $this->db->where('email', $email);
        $this->db->delete('user');

        $this->db->where('email', $email);
        $this->db->delete('coach');
    }

    //Get Self Intro
    public function get_self_introduction($email)
    {
        $this->db->select('self_introduction');
        $this->db->where('email', $email);
        $query = $this->db->get('coach');

        return $query->result();
    }

    //Get Experience
    public function get_experience($email)
    {
        $this->db->select('experience');
        $this->db->where('email', $email);
        $query = $this->db->get('coach');

        return $query->result();
    }
}

?>
