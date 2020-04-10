<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class Mainmodel extends CI_Model {

 	function login()
 	{
 		$username = $this->input->post('username');
 		$password = $this->input->post('password');

 		$cek = $this->db->where(array('username'=> $username,'password'=> $password))->get('pegawai');
 		if ($cek->num_rows() > 0 ) {
 			$cek = $this->db->where(array('username'=> $username,'password'=> $password))->get('pegawai')->result();
 			if ($cek[0]->akses=="Kasubag Umpeg") {
 				$array = array(
 					'kasubag_umpeg' => $cek[0]->id,
 				);
 				$this->session->set_userdata( $array );
 				return 'Kasubag Umpeg';
 			}elseif ($cek[0]->akses=="Staff Umpeg") {
 				$array = array(
 					'staff' => $cek[0]->id,
 				);
 				$this->session->set_userdata( $array );
 				return 'staff';
 			}elseif ($cek[0]->akses=="Sekcam") {
 				$array = array(
 					'sekcam' => $cek[0]->id,
 				);
 				$this->session->set_userdata( $array );
 				return 'sekcam';
 			}else{
 				$array = array(
 					'camat' => $cek[0]->id,
 				);
 				$this->session->set_userdata( $array );
 				return 'camat';
 			}
 		}else{
 			return false;
 		}
 	}	

 	function get_table($table){
 		return $this->db->get($table);
 	}
 	function get_where($table,array $where)
 	{
 		return $this->db->where($where)->get($table);
 	}
 	function drop($table,array $where){
 		return $this->db->where($where)->delete($table);
 	}

 	function insert($table,array $data){
 		return $this->db->insert($table,$data);
 	}
 	function update($table,array $where,array $data){
 		return $this->db->where($where)->update($table,$data);
 	}

    function get_all_paginate($table,$order_by,$num, $offset) {
        $this->db->order_by($order_by, "ASC");
        $query = $this->db->where('type','3')->where('id !=',$this->session->userdata('id_siswa'))->get($table, $num, $offset);
        return $query->result();
    }
 }

 /* End of file Mainmodel.php */
/* Location: ./application/models/Mainmodel.php */