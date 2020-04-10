<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		$this->load->model('Mainmodel','m');
		// if ($this->session->userdata('id_admin')!==null) {
		// 	redirect('admin');
		// }
	}
	function index()
	{
		$data['title'] = "Arsip | Admin-Dashboard";
		$this->load->view('admin/header',$data);
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}

	function carilama($i)
	{
		$kata = str_replace('%20', ' ', $i);
		$cek  = $this->db->where(array('password' => $kata))->where('id',$this->session->userdata('id_admin'))->get('pegawai');
		if ($cek->num_rows() > 0) {
			echo '0';
            // echo $cek->num_rows();
		} else {
			echo '1';
            // echo $cek->num_rows();
		}
	}

	function cariusername($i)
	{
		$kata = str_replace('%20', ' ', $i);
		$cek  = $this->db->where(array('username' => $kata))->get('pegawai');
		if ($cek->num_rows() > 0) {
			echo '1';
            // echo $cek->num_rows();
		} else {
			echo '0';
            // echo $cek->num_rows();
		}
	}

	function gantiPass()
	{
		$this->m->update('pegawai',['id'=>$this->session->userdata('id_admin')],['password'=>$this->input->post('password')]);
		$this->session->set_flashdata('success', 'Password berhasil di ganti');
		redirect($this->agent->referrer());
	}

	function gantiUser()
	{
		$this->m->update('pegawai',['id'=>$this->session->userdata('id_admin')],['username'=>$this->input->post('username')]);
		$this->session->set_flashdata('success', 'Username berhasil di ganti');
		redirect($this->agent->referrer());
	}


	function pegawai()
	{
		$data['title']   = "Arsip | Manage pegawai";
		$data['pegawai'] = $this->m->get_table('pegawai');
		$this->load->view('admin/header', $data);
		$this->load->view('admin/pegawai');
		$this->load->view('admin/footer');
	}

	function carinip($i)
	{
		$kata = str_replace('%20', ' ', $i);
		$cek  = $this->db->where(array('nip' => $kata))->get('pegawai');
		if ($cek->num_rows() > 0) {
			echo '1';
            // echo $cek->num_rows();
		} else {
			echo '0';
            // echo $cek->num_rows();
		}
	}

	function addpegawai()
	{
		$this->m->insert('pegawai',[
			'nip'	=>	$this->input->post('nip'),
			'nama'	=>	$this->input->post('nama'),
			'tmp_lahir'	=>	$this->input->post('tmp_lahir'),
			'tgl_lahir'	=>	$this->input->post('tgl_lahir'),
			'jk'	=>	$this->input->post('jk'),
			'status'	=>	$this->input->post('status'),
			'agama'	=>	$this->input->post('agama'),
			'jabatan'	=>	$this->input->post('jabatan'),
			'pangkat'	=>	$this->input->post('pangkat'),
			'no_hp'	=>	$this->input->post('no_hp'),
			'password'	=>	$this->input->post('password'),
			'username'	=>	$this->input->post('username'),
			'akses'	=>	$this->input->post('akses'),
		]);
		$this->session->set_flashdata('success', 'Pegawai berhasil di tambahkan!');
		redirect($this->agent->referrer());
	}


	function updpegawai($id)
	{
		$this->m->update('pegawai',['id'=>$id],[
			'nip'	=>	$this->input->post('nip'),
			'nama'	=>	$this->input->post('nama'),
			'tmp_lahir'	=>	$this->input->post('tmp_lahir'),
			'tgl_lahir'	=>	$this->input->post('tgl_lahir'),
			'jk'	=>	$this->input->post('jk'),
			'status'	=>	$this->input->post('status'),
			'agama'	=>	$this->input->post('agama'),
			'jabatan'	=>	$this->input->post('jabatan'),
			'pangkat'	=>	$this->input->post('pangkat'),
			'no_hp'	=>	$this->input->post('no_hp'),
			'password'	=>	$this->input->post('password'),
			'username'	=>	$this->input->post('username'),
			'akses'	=>	$this->input->post('akses'),
		]);
		$this->session->set_flashdata('success', 'Pegawai berhasil di ubah!');
		redirect($this->agent->referrer());
	}

	function delpegawai($di)
	{
		$this->m->drop('pegawai',['id'=>$di]);
		$this->session->set_flashdata('success', 'Pegawai berhasil di hapus!');
		redirect($this->agent->referrer());	
	}

	function masuk()
	{
		$data['title']   = "Arsip | Manage Surat Masuk";
		$data['masuk'] = $this->m->get_table('masuk');
		$this->load->view('admin/header', $data);
		$this->load->view('admin/masuk');
		$this->load->view('admin/footer');
	}

	function carinosurat($i)
	{
		$kata = str_replace('%20', ' ', $i);
		$cek  = $this->db->where(array('no_surat' => $kata))->get('masuk');
		if ($cek->num_rows() > 0) {
			echo '1';
            // echo $cek->num_rows();
		} else {
			echo '0';
            // echo $cek->num_rows();
		}
	}

	function addmasuk()
	{
		$config['upload_path']="upload/masuk/"; //path folder file upload
        $config['allowed_types']='gif|jpg|png|jpeg'; //type file yang boleh di upload
        $judul = "Surat_".$this->input->post('no_surat');
        $config['file_name'] = $judul;
        
        $this->load->library('upload',$config); 

        if($this->upload->do_upload("foto")){ 
        	$data = array('upload_data' => $this->upload->data()); 
        	$foto= $data['upload_data']['file_name']; 

        	$data = array(
        		'no_surat'			=> $this->input->post('no_surat'),
        		'kode_surat'			=> $this->input->post('kode_surat'),
        		'pengirim'			=> $this->input->post('pengirim'),
        		'isi'			=> $this->input->post('isi'),
        		'tgl_masuk'			=> $this->input->post('tgl_masuk'),
        		'disposisi'			=> $this->input->post('disposisi'),
        		'keterangan'			=> $this->input->post('keterangan'),
        		'foto'			=> $foto
        	);
        	$this->m->insert('masuk',$data);
        	$this->session->set_flashdata('success', 'Surat masuk berhasil di tambahkan');
        	redirect($this->agent->referrer());
        }else{
        	$this->session->set_flashdata('error', $this->upload->display_errors());
        	redirect($this->agent->referrer());
        }
    }

    function updatemasuk($id)
    {
    	$lama  = $this->m->get_where('masuk', ['id' => $id])->result();

    	if(!empty($_FILES['foto']['name'])){
			$config['upload_path']="upload/masuk/"; //path folder file upload
	        $config['allowed_types']='gif|jpg|png|jpeg'; //type file yang boleh di upload
	        $judul = "Surat_".$this->input->post('no_surat');
	        $config['file_name'] = $judul;

	        $this->load->library('upload',$config); 

	        if($this->upload->do_upload("foto")){ 
	        	if (file_exists("upload/masuk/".$lama[0]->foto)) {	
	        		unlink('upload/masuk/'.$lama[0]->foto);
	        	}
	        	$data = array('upload_data' => $this->upload->data()); 
	        	$foto= $data['upload_data']['file_name']; 

	        	$data = array(
	        		'no_surat'			=> $this->input->post('no_surat'),
	        		'kode_surat'			=> $this->input->post('kode_surat'),
	        		'pengirim'			=> $this->input->post('pengirim'),
	        		'isi'			=> $this->input->post('isi'),
	        		'tgl_masuk'			=> $this->input->post('tgl_masuk'),
	        		'disposisi'			=> $this->input->post('disposisi'),
	        		'keterangan'			=> $this->input->post('keterangan'),
	        		'foto'			=> $foto
	        	);
	        	$this->m->update('masuk',['id'=>$id],$data);
	        	$this->session->set_flashdata('success', 'Data berhasil di rubah');
	        	redirect($this->agent->referrer());
	        }else{
	        	$this->session->set_flashdata('error', $this->upload->display_errors());
	        	redirect($this->agent->referrer());
	        }
	    }else{

	    	$data = array(
	    		'no_surat'			=> $this->input->post('no_surat'),
	    		'kode_surat'			=> $this->input->post('kode_surat'),
	    		'pengirim'			=> $this->input->post('pengirim'),
	    		'isi'			=> $this->input->post('isi'),
	    		'tgl_masuk'			=> $this->input->post('tgl_masuk'),
	    		'disposisi'			=> $this->input->post('disposisi'),
	    		'keterangan'			=> $this->input->post('keterangan'),
	    	);
	    	$this->m->update('masuk',['id'=>$id],$data);
	    	$this->session->set_flashdata('success', 'Data berhasil di rubah');
	    	redirect($this->agent->referrer());
	    }
	}

	function delmasuk($id)
	{
		$lama  = $this->m->get_where('masuk', ['id' => $id])->result();
		if (file_exists("upload/masuk/".$lama[0]->foto)) {	
			unlink('upload/masuk/'.$lama[0]->foto);
		}

		$this->m->drop('masuk',['id'=>$id]);
		$this->session->set_flashdata('success', 'Surat masuk berhasil di hapus');
		redirect($this->agent->referrer());
	}

	function detmasuk($id)
	{
		$data['title']= "Arsip | Surat Masuk Detail";
		$data['lama'] = $this->m->get_where('masuk', ['id' => $id])->result();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/detailmasuk');
		$this->load->view('admin/footer');		
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */