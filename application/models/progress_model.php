<?php
/**
 * Class definition for progress_Model. Model extends CI_Model.
 *
 * Class definition for progress_Model. Model includes methods
 * to handle listing, inserting, editing and deleting progress entries.
 * Extends CI_Model.
 * date("Y-m-d H:i:s",$subhour);
 * @author Daniel Goss December 2016
 */

class progress_Model extends CI_Model
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
        $this->db->insert('progress',$data);
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
          $query=$this->db->update('progress',$data);
        }
        else
        {
          $this->db->insert('progress',$data);
          
        }
        return $this->db->insert_id();
    }
    
    /**
     * @param int $id Primary key of the progress entry
     * @return <array> progress data 
     */    
    public function read_progress($id)
    {
        $this->db->where('id',$id);
        $query=$this->db->get('progress');
        return $query->result();
    }

    /**
     */
    public function read_all_progress()
    {
        $query=$this->db->get('progress');
        return $query->result();
    }
    
    public function read_progress_with_criteria($criteria)
    {
        $this->db->select('progress.id AS id,'.
        	'progress.Created,progress.Updated,'.
            'progress.ASN,'.
            'progress.PNO,'.
            'progress.PDF_filename,'.
            'progress.PagesGenerated,'.
            'progress.Description,'.
            'progress.Location');
        if (!empty($criteria))
            $this->db->where($criteria);
        $this->db->from('progress');
        $this->db->order_by("progress.Created", "desc"); 
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
        $this->db->delete('progress');
    }
    
    /**
     * Find a progress entry from the progress table.
     *  
     */    
    public function find($field,$criteria)
    {
        $this->db->select('progress.id AS id,'.
        	'progress.Created,progress.Updated,'.
            'progress.ASN,'.
            'progress.PNO,'.
            'progress.PDF_filename,'.
            'progress.PagesGenerated,'.
            'progress.Description,'.
            'progress.Location');
        $this->db->from('progress');
        $this->db->like($field,$criteria);
        $this->db->order_by("progress.Created", "desc"); 
        $query = $this->db->get();
        return $query->result();
    }
    
}
?>