<?php
/**
 * Class definition for mydiary_Model. Model extends CI_Model.
 *
 * Class definition for mydiary_Model. Model includes methods
 * to handle listing, inserting, editing and deleting dailydiary entries.
 * Extends CI_Model.
 * 
 * @author Daniel Goss November 2013
 */

class mydiary_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function create($data)
    {
        if (empty($data['userid']) OR ($data['userid']==0))
        {
          $data['userid'] = 1;
        }
        if (empty($data['dailydate']))
        {
            $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
            $data['dailydate'] = date("Y-m-d H:i:s",$subhour);
            //$today = date("Y-m-d H:i:s",now());
            //$data['dailydate'] = $today;
        }
        if (empty($data['dailybrief']))
        {
            $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
            $result = $subhour->format('dddd dd-mm-YYYY H:i:s');
            $data['dailybrief'] = $result;
        }
        if (empty($data['dailyentry']))
        {
            $data['dailyentry'] = 'no entry';
        }

        if (empty($data['dailyprivateentry']))
        {
            $data['private'] = 0;
        }
        else
        {
            $data['private'] = 1;
        }
        $this->db->insert('dailydiary',$data);
        return $this->db->insert_id();
    }
    
    public function update($data)
    {
        //$data['userid'] = 1;
        if (empty($data['dailydate']))
        {
            $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
            $data['dailydate'] = date("Y-m-d H:i:s",$subhour);
            //$today = date("Y-m-d H:i:s",now());
            //$data['dailydate'] = $today;
        }
        if (empty($data['dailybrief']))
        {
            $subhour = mktime(date("H")-1,date("i"),date("s"),date("m"),date("d"),date("Y"));
            $result = $subhour->format('dddd dd-mm-YYYY H:i:s');
            $data['dailybrief'] = $result;
        }
        if (empty($data['dailyentry']))
        {
            $data['dailyentry'] = 'no entry';
        }

        if (empty($data['dailyprivateentry']))
        {
            $data['private'] = 0;
        }
        else
        {
            $data['private'] = 1;
        }

        if(!empty($data['uniqueid']))
        {
          $this->db->where('uniqueid',$data['uniqueid']);
          $query=$this->db->update('dailydiary',$data);
        }
        else
        {
          echo "ERROR during update DailyDiary - ID empty?";
        }
    }
    
    /**
     * @param int $id Primary key of the diary entry
     * @return <array> dailydiary data 
     */    
    public function read_diary($id)
    {
        $this->db->where('uniqueid',$id);
        $query=$this->db->get('dailydiary');
        return $query->result();
    }

    public function read_userdiary($id)
    {
        $this->db->where('userid',$id);
        $query=$this->db->get('dailydiary');
        return $query->result();
    }

    /**
     */
    public function read_all()
    {
        $query=$this->db->get('dailydiary');
        return $query->result();
    }
    
    public function read_diary_with_users($criteria)
    {
        $this->db->select('dailydiary.uniqueid AS id,diaryusers.username AS username,'.
            'dailydiary.dailydate,'.
            'dailydiary.dailybrief AS brief,dailydiary.dailyentry AS entry,'.
            'dailydiary.dailyprivateentry AS privateentry,'.
            'dailydiary.private AS private,'.
            'dailydiary.userid');
        if (!empty($criteria))
            $this->db->where($criteria);
        $this->db->from('dailydiary');
        $this->db->join('diaryusers', 
                'diaryusers.userid = dailydiary.userid');
        $this->db->order_by("dailydiary.dailydate", "asc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Update diary entry in the dailydiary table.
     */    
    
    
    /**
     * Delete a diary entry from the dailydiary table.
     * 
     * @param int $id Primary key of the dailydiary entry to delete. 
     */    
    public function delete($id)
    {
        $this->db->where('uniqueid',$id);
        $this->db->delete('dailydiary');
    }
    
    /**
     * Find a daily diary entry from the dailydiary table.
     *  
     */    
    public function find($field,$criteria)
    {
        $this->db->select('dailydiary.dailydate AS date,'.
            'dailydiary.dailybrief AS brief,dailydiary.dailyentry AS entry,'.
            'dailydiary.dailyprivateentry AS privateentry,'.
            'dailydiary.private AS private,'.
            'dailydiary.userid AS userId');
        $this->db->from('dailydiary');
        $this->db->join('diaryusers', 
                'diaryusers.userid = dailydiary.userid');
        $this->db->like($field,$criteria);
        $this->db->order_by("dailydiary.dailydate", "asc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>