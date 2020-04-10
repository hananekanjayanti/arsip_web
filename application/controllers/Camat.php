<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Camat extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mainmodel','m');
	}
	
	function index()
	{
		$data['title'] = "Arsip | Camat-Dashboard";
		$this->load->view('camat/header',$data);
		$this->load->view('kasubag/dashboard');
		$this->load->view('camat/footer');
	}


	function masuk()
	{
		$data['title']   = "Arsip | Manage Surat Masuk";
		$data['masuk'] = $this->m->get_table('masuk');
		$this->load->view('camat/header', $data);
		$this->load->view('camat/masuk');
		$this->load->view('camat/footer');
	}

	function detmasuk($id)
	{
		
		$data['title']= "Arsip | Surat Masuk Detail";
		$data['lama'] = $this->m->get_where('masuk', ['id' => $id])->result();
		$this->load->view('camat/header', $data);
		$this->load->view('camat/detmasuk');
		$this->load->view('camat/footer');		
	}

	function keluar()
	{
		$data['title']   = "Arsip | Manage Surat Keluar";
		$data['keluar'] = $this->m->get_table('keluar');
		$this->load->view('camat/header', $data);
		$this->load->view('camat/keluar');
		$this->load->view('camat/footer');
	}

	function detkeluar($id)
	{
		$data['title']= "Arsip | Surat Keluar Detail";
		$data['lama'] = $this->m->get_where('keluar', ['id' => $id])->result();
		$this->load->view('camat/header', $data);
		$this->load->view('camat/detailkeluar');
		$this->load->view('camat/footer');		
	}

	function disposisi()
	{
		$data['title']   = "Arsip | Disposisi Surat";
		$this->load->view('camat/header', $data);
		$this->load->view('camat/disposisi');
		$this->load->view('camat/footer');
	}

	function add_disposisi()
	{
		$this->m->insert('disposisi',[
			'no_surat'	=>	$this->input->post('no_surat'),
			'diteruskan'	=>	$this->input->post('diteruskan'),
			'tgl_diterima'	=>	$this->input->post('tgl_diterima'),
			'tgl_surat'	=>	$this->input->post('tgl_surat'),
			'catatan'	=>	$this->input->post('catatan'),
			'perihal'	=>	$this->input->post('perihal'),
			'sifat'	=>	$this->input->post('sifat'),
			'dgn_hormat'	=>	$this->input->post('dgn_hormat'),
			'sifat'	=>	$this->input->post('sifat'),
			'dari'	=>	$this->input->post('dari'),
		]);

		$this->session->set_flashdata('success', 'Disposisi berhasil di tambahkan');
		redirect($this->agent->referrer());

	}


	function laporan()
	{
		$data['title']   = "Arsip | Laporan Rekapitulasi";
		$this->load->view('camat/header', $data);
		$this->load->view('camat/laporan');
		$this->load->view('camat/footer');	
	}

	function rekap()
	{
		$data['masuk']  = $this->db->where("tgl_masuk BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('masuk')->num_rows();
		$data['keluar']  = $this->db->where("tgl_keluar BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('keluar')->num_rows();
		$data['disposisi']  = $this->db->where("tgl_diterima BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('disposisi')->num_rows();
		$data['title']   = "Arsip | Laporan Rekapitulasi";
		$this->load->view('camat/header', $data);
		$this->load->view('camat/rekap');
		$this->load->view('camat/footer');	
	}

	public function getData($no_surat)
	{
		$surat = $this->m->get_where('masuk',['no_surat'=>$no_surat])->row();
		$dari = $surat->pengirim;
		$tgl_masuk = $surat->tgl_masuk;
		echo  json_encode(array($dari,$tgl_masuk));
	}
}



/* End of file Camat.php */
/* Location: ./application/controllers/Camat.php */