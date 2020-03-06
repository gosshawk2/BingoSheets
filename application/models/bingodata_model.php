<?php
/**
* Class definition for my_bingodata_Model. Model extends CI_Model.
*
* Class definition for mydiary_Model. Model includes methods
* to handle reading bingo data entries.
* Extends CI_Model.
* $data holds the data to be saved etc.
* @author Daniel Goss December 2016
*/

class bingodata_Model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	/**
	* @param int $id Primary key of the my_bingodata row entry
	* @return <array> my_bingodata data
	*/
	public function read_($id)
	{
		$this->db->where('id',$id);
		$query = $this->db->get('my_bingodata');
		return $query->result();
	}

	/**
	*/
	public function read_bingodata()
	{
		$query = $this->db->get('my_bingodata');
		return $query->result();
	}

	public function read_bingodata_with_criteria($criteria)
	{
		$this->db->select('my_bingodata.ID AS id,'.
			'my_bingodata.ASNNO,'.
			'my_bingodata.ASNDAY,'.
			'my_bingodata.PNO,'.
			'my_bingodata.SumofORDQTY,'.
			'my_bingodata.PSR,'.
			'my_bingodata.HomeSlot,'.
			'my_bingodata.Storage,'.
			'my_bingodata.UnitPerStorage,'.
			'my_bingodata.PAGES,'.
			'my_bingodata.Description,'.
			'my_bingodata.FullTote,'.
			'my_bingodata.QtyPerFullTote,'.
			'my_bingodata.HalfTote,'.
			'my_bingodata.QtyPerHalfTote,'.
			'my_bingodata.TotalQty>300,'.
			'my_bingodata.MAXQty>300,'.
			'my_bingodata.MAXPerSheet');
		if(!empty($criteria))
		{
			$this->db->where($criteria);
			$this->db->from('my_bingodata');
			$this->db->order_by("my_bingodata.ASNDAY,my_bingodata.ASNNO", "asc");
			$query = $this->db->get();
		}
		return $query->result();
	}

	/**
	* Delete an entry from the my_bingodata table.
	*
	* @param int $id Primary key of the dailydiary my_bingodata to delete.
	*/
	public function delete($id)
	{
		$this->db->where('id',$id);
		$this->db->delete('my_bingodata');
	}

	/**
	* Find a data item entry from the my_bingodata table.
	*
	*/
	public function find($field,$criteria)
	{
		$this->db->select('my_bingodata.ID AS id,'.
			'my_bingodata.ASNNO,'.
			'my_bingodata.ASNDAY,'.
			'my_bingodata.PNO,'.
			'my_bingodata.SumofORDQTY,'.
			'my_bingodata.PSR,'.
			'my_bingodata.HomeSlot,'.
			'my_bingodata.Storage,'.
			'my_bingodata.UnitPerStorage,'.
			'my_bingodata.PAGES,'.
			'my_bingodata.Description,'.
			'my_bingodata.FullTote,'.
			'my_bingodata.QtyPerFullTote,'.
			'my_bingodata.HalfTote,'.
			'my_bingodata.QtyPerHalfTote,'.
			'my_bingodata.TotalQty>300,'.
			'my_bingodata.MAXQty>300,'.
			'my_bingodata.MAXPerSheet');
		$this->db->from('my_bingodata');
		$this->db->like($field,$criteria);
		$this->db->order_by("my_bingodata.ASNDAY,my_bingodata.ASNNO", "asc");
		$query = $this->db->get();
		return $query->result();
	}

}
?>