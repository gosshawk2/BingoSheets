<?php
class CI_auth extends CI_Model {

    function __construct()
    {
        parent::__construct();
            $this->load->library('session'); 
            $this->load->database();
            $this->load->helper('url');
	    	$this->load->model(array('CI_encrypt'));
    }
	
	function process_login($login_array_input = NULL){
            if(!isset($login_array_input) OR count($login_array_input) != 2)
                return false;
            //set its variable
            $username = $login_array_input[0];
            $password = $login_array_input[1];
            // select data from database to check user exist or not?
            $query = $this->db->query("SELECT * FROM `bingo_users` WHERE `username`= '".$username."' LIMIT 1");
            if ($query->num_rows() > 0)
            {
                $row = $query->row();
                $user_id = $row->userid;
                $user_pass = $row->password;
		        $user_salt = $row->salt;
                $firstname = $row->firstname;
                $lastname = $row->lastname;
                echo "<br>Password entered=".$password.", salt=".$user_salt.", encrypted=".$this->CI_encrypt->encryptUserPwd($password,$user_salt);
                echo "<br>User stored encrypted password".$user_pass;
                if($this->CI_encrypt->encryptUserPwd( $password,$user_salt) === $user_pass){ 
                    $this->session->set_userdata('logged_user', $user_id);
                    $this->session->set_userdata('userid', $user_id);
                    $this->session->set_userdata('username', $username);
                    $this->session->set_userdata('firstname',$firstname);
                    $this->session->set_userdata('lastname',$lastname);

                    return true;
                }
                return false;
            }
            return false;
	}
	
	function check_logged(){
		return ($this->session->userdata('logged_user'))?TRUE:FALSE;
	}
	

	function logged_id(){
		return ($this->check_logged())?$this->session->userdata('logged_user'):'';
	}
}
