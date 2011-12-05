<?php
class vdpi_Model  extends CI_Model  {
	
	function __construct()
    {
        parent::__construct();
    }

	function getSumFromTable($table,$column,$where){
		if(!is_null($where)){
			$this->db->where($where);
		}
		$this->db->select_sum($column);
		return $this->db->get($table);
	}

	function getCountFromTable($table,$column = '*',$where){
		if(!is_null($where)){
			$this->db->where($where);
		}
		$this->db->count_all($column);
		return $this->db->get($table);
	}

}
?>