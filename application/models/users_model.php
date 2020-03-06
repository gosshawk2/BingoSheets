<?php
/**
 * Class definition for users_Model. Model extends CI_Model.
 *
 * Class definition for users_Model. Model includes methods
 * to handle listing, inserting, editing and deleting progress entries.
 * Extends CI_Model.
 * date("Y-m-d H:i:s",$subhour);
 * @author Daniel Goss December 2016
 */

class users_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function create($data)
    {
    	$subhour = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
        $result = $subhour->format('ddd dd-mm-YYYY H:i:s');
        if (empty($data['created']))
        {
          $data['created'] = $result;
        }
        if (empty($data['updated']))
        {
          $data['updated'] = $result;
        }
        $this->db->insert('bingo_users',$data);
        return $this->db->insert_id();
    }
    
    public function update($data)
    {
        $subhour = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
        $result = $subhour->format('ddd dd-mm-YYYY H:i:s');
        if (empty($data['updated']))
        {
            $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
            $data['updated'] = $result;
        }

        if(!empty($data['id']))
        {
          $this->db->where('id',$data['id']);
          $query=$this->db->update('bingo_users',$data);
        }
        else
        {
          $this->db->insert('bingo_users',$data);
          
        }
        return $this->db->insert_id();
    }
    
    /**
     * @param int $id Primary key of the progress entry
     * @return <array> progress data 
     */    
    public function read_users($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('bingo_users');
        return $query->result();
    }

    /**
     */
    public function read_all_users()
    {
        $query=$this->db->get('bingo_users');
        return $query->result();
    }
    
    public function read_users_with_criteria($criteria)
    {
        $this->db->select('bingo_users.userid AS userid,'.
        	'bingo_users.nickname,'.
        	'bingo_users.username,'.
        	'bingo_users.firstname,'.
        	'bingo_users.lastname,'.
        	'bingo_users.jobtitle,'.
        	'bingo_users.department,'.
        	'bingo_users.emailaddress,'.
        	'bingo_users.password,'.
        	'bingo_users.contactnumber,'.
        	'bingo_users.passkey,'.
        	'bingo_users.created,'.
            'bingo_users.Updated');
        if (!empty($criteria))
            $this->db->where($criteria);
        $this->db->from('bingo_users');
        $this->db->order_by("bingo_users.firstname", "asc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Update progress entry in the progress table.
     */    
    
    
    /**
     * Delete a progress entry from the progress table.
     * 
     * @param int $id Primary key of the progress entry to delete. 
     */    
    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('bingo_users');
    }
    
    /**
     * Find a progress entry from the progress table.
     *  
     */    
    public function find($field,$criteria)
    {
        $this->db->select('bingo_users.userid AS userid,'.
        	'bingo_users.nickname,'.
        	'bingo_users.username,'.
        	'bingo_users.firstname,'.
        	'bingo_users.lastname,'.
        	'bingo_users.jobtitle,'.
        	'bingo_users.department,'.
        	'bingo_users.emailaddress,'.
        	'bingo_users.password,'.
        	'bingo_users.contactnumber,'.
        	'bingo_users.passkey,'.
        	'bingo_users.created,'.
            'bingo_users.Updated');
        $this->db->from('bingo_users');
        $this->db->like($field,$criteria);
        $this->db->order_by("bingo_users.firstname", "desc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>