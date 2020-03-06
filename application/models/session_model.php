<?php
/**
 * Class definition for session_Model. Model extends CI_Model.
 *
 * Class definition for session_Model. Model includes methods
 * to handle listing, inserting, editing and deleting sessions.
 * Extends CI_Model.
 * 
 * @author Daniel Goss copyright #December 2016
 */

class session_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Insert session into the ci_sessions table.
     * 
     * a new unique session id should also be saved otherwise this will fail     
     * @param <array> $data ci_sessions data
     * @return int Returns the primary key of the new session entry. 
     */    
    public function create($data)
    {
        if (empty($data['username']))
        {
            $data['username'] = 'nobody';
        }
        
        $this->db->insert('ci_sessions',$data);
        return $this->db->insert_id();
    }
    
    /**
     * Read student from the student table using primary key.
     * 
     * @param int $id Primary key of the student
     * @return <array> student data 
     */    
    public function read_session($id)
    {
        $this->db->where('session_id',$id);
        $query=$this->db->get('ci_sessions');
        return $query->result();
    }
    
    /**
     * Read all the sessions
     * 
     * @return <array> ci_sessions data 
     */
    public function read_sessions()
    {
        $query=$this->db->get('ci_sessions');
        return $query->result();
    }
    
    public function update($data)
    {
        if (empty($data['username']))
        {
            $data['username'] = 'nobody';
        }

        $this->db->where('session_id',$data['id']);
        $query=$this->db->update('ci_sessions',$data) ;
    }
    
    /**
     * Delete a student from the student table.
     * 
     * @param int $id Primary key of the student to delete. 
     */    
    public function delete($id)
    {
        $this->db->where('session_id',$id);
        $this->db->delete('ci_sessions');
    }
    
    /**
     * Find a session from the ci_sessions table.
     *  
     */    
    public function find($field,$criteria)
    {
        $this->db->select('ci_sessions.session_id AS id,'.
          'CI_Sessions.created,'.
          'ci_sessions.ip_address AS ipaddr,'.
          'ci_sessions.user_agent AS useragent,'.
          'CI_Sessions.username,'.
          'ci_sessions.firstname,'.
          'ci_sessions.lastname,'.
          'ci_sessions.logged_in,'.
          'ci_sessions.last_activity,'.
          'ci_sessions.user_data,'.
          'ci_sessions.passkey,');
        $this->db->from('ci_sessions');
        $this->db->like($field,$criteria);
        $this->db->order_by("ci_sessions.username", "asc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>