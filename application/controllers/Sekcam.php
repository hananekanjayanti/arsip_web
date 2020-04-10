<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekcam extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mainmodel','m');
	}
	function index()
	{
		$data['title'] = "Arsip | Sekcam-Dashboard";
		$this->load->view('sekcam/header',$data);
		$this->load->view('kasubag/dashboard');
		$this->load->view('sekcam/footer');
	}


	function masuk()
	{
		$data['title']   = "Arsip | Manage Surat Masuk";
		$data['masuk'] = $this->m->get_table('masuk');
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/masuk');
		$this->load->view('sekcam/footer');
	}

	function detmasuk($id)
	{
		
		$data['title']= "Arsip | Surat Masuk Detail";
		$data['lama'] = $this->m->get_where('masuk', ['id' => $id])->result();
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/detmasuk');
		$this->load->view('sekcam/footer');		
	}

	function keluar()
	{
		$data['title']   = "Arsip | Manage Surat Keluar";
		$data['keluar'] = $this->m->get_table('keluar');
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/keluar');
		$this->load->view('sekcam/footer');
	}

	function detkeluar($id)
	{
		$data['title']= "Arsip | Surat Keluar Detail";
		$data['lama'] = $this->m->get_where('keluar', ['id' => $id])->result();
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/detailkeluar');
		$this->load->view('sekcam/footer');		
	}

	function disposisi()
	{
		$data['title']   = "Arsip | Disposisi Surat";
		$data['list'] 	 = $this->m->get_table('disposisi');
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/disposisi');
		$this->load->view('sekcam/footer');
	}

	function detail($id)
	{
		$data['title']   = "Arsip | Detail Disposisi Surat";
		$data['list'] 	 = $this->m->get_where('disposisi',['id'=>$id])->row();
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/detail');
		$this->load->view('sekcam/footer');
	}

	function laporan()
	{
		$data['title']   = "Arsip | Laporan Rekapitulasi";
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/laporan');
		$this->load->view('sekcam/footer');	
	}

	function rekap()
	{
		$data['masuk']  = $this->db->where("tgl_masuk BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('masuk');
		$data['keluar']  = $this->db->where("tgl_keluar BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('keluar');
		$data['disposisi']  = $this->db->where("tgl_diterima BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('disposisi');
		
		$data['dari'] = $this->input->post('dari');
		$data['sampai'] = $this->input->post('sampai');
		$data['title']   = "Arsip | Laporan Rekapitulasi";
		$this->load->view('sekcam/header', $data);
		$this->load->view('sekcam/rekap');
		$this->load->view('sekcam/footer');	
	}
}

/* End of file Sekcam.php */
/* Location: ./application/controllers/Sekcam.php */