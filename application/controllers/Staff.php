<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {

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
		$data['title'] = "Staff-Dashboard";
		$this->load->view('staff/header',$data);
		$this->load->view('kasubag/dashboard');
		$this->load->view('staff/footer');
	}


	function masuk()
	{
		$data['title']   = "APS | Manage Surat Masuk";
		$data['masuk'] = $this->m->get_table('masuk');
		$this->load->view('staff/header', $data);
		$this->load->view('kasubag/masuk');
		$this->load->view('staff/footer');
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
		$data['title']= "APS | Surat Masuk Detail";
		$data['lama'] = $this->m->get_where('masuk', ['id' => $id])->result();
		$this->load->view('staff/header', $data);
		$this->load->view('kasubag/detailmasuk');
		$this->load->view('staff/footer');		
	}

	function kategori()
	{
		$data['title']   = "APS | Manage Kategori";
		$data['kategori'] = $this->m->get_table('kategori');
		$this->load->view('staff/header', $data);
		$this->load->view('kasubag/kategori');
		$this->load->view('staff/footer');	
	}

	function addkategori()
	{
		$this->m->insert('kategori',['kategori'=> $this->input->post('kategori')]);
		$this->session->set_flashdata('success', 'Kategori berhasil di tambahkan');
		redirect($this->agent->referrer());
	}

	function updatekategori($id)
	{
		$this->m->update('kategori',['id'=> $id],['kategori'=>$this->input->post('kategori')]);
		$this->session->set_flashdata('success', 'Kategori berhasil di update');
		redirect($this->agent->referrer());
	}

	function delkategori($id)
	{
		$this->m->drop('kategori',['id'=>$id]);
		$this->session->set_flashdata('success', 'Kategori berhasil di hapus');
		redirect($this->agent->referrer());
	}

	function keluar()
	{
		$data['title']   = "APS | Manage Surat Keluar";
		$data['keluar'] = $this->m->get_table('keluar');
		$this->load->view('staff/header', $data);
		$this->load->view('kasubag/keluar');
		$this->load->view('staff/footer');
	}

	function carinosurat_keluar($i)
	{
		$kata = str_replace('%20', ' ', $i);
		$cek  = $this->db->where(array('no_surat' => $kata))->get('keluar');
		if ($cek->num_rows() > 0) {
			echo '1';
            // echo $cek->num_rows();
		} else {
			echo '0';
            // echo $cek->num_rows();
		}
	}


	function addkeluar($value='')
	{
		$config['upload_path']="upload/keluar/"; //path folder file upload
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
        		'ditujukan'			=> $this->input->post('ditujukan'),
        		'kategori'			=> $this->input->post('kategori'),
        		'tgl_keluar'			=> $this->input->post('tgl_keluar'),
        		'perihal'			=> $this->input->post('perihal'),
        		'keterangan'			=> $this->input->post('keterangan'),
        		'status'			=> $this->input->post('status'),
        		'foto'			=> $foto
        	);
        	$this->m->insert('keluar',$data);
        	$this->session->set_flashdata('success', 'Surat keluar berhasil di tambahkan');
        	redirect($this->agent->referrer());
        }else{
        	$this->session->set_flashdata('error', $this->upload->display_errors());
        	redirect($this->agent->referrer());
        }
    }

    function updatekeluar($id)
    {
    	
    	$lama  = $this->m->get_where('keluar', ['id' => $id])->result();

    	if(!empty($_FILES['foto']['name'])){
			$config['upload_path']="upload/keluar/"; //path folder file upload
	        $config['allowed_types']='gif|jpg|png|jpeg'; //type file yang boleh di upload
	        $judul = "Surat_".$this->input->post('no_surat');
	        $config['file_name'] = $judul;

	        $this->load->library('upload',$config); 

	        if($this->upload->do_upload("foto")){ 
	        	if (file_exists("upload/keluar/".$lama[0]->foto)) {	
	        		unlink('upload/keluar/'.$lama[0]->foto);
	        	}
	        	$data = array('upload_data' => $this->upload->data()); 
	        	$foto= $data['upload_data']['file_name']; 

	        	$data = array(
	        		'no_surat'			=> $this->input->post('no_surat'),
	        		'kode_surat'			=> $this->input->post('kode_surat'),
	        		'ditujukan'			=> $this->input->post('ditujukan'),
	        		'kategori'			=> $this->input->post('kategori'),
	        		'tgl_keluar'			=> $this->input->post('tgl_keluar'),
	        		'perihal'			=> $this->input->post('perihal'),
	        		'keterangan'			=> $this->input->post('keterangan'),
	        		'status'			=> $this->input->post('status'),
	        		'foto'			=> $foto
	        	);
	        	$this->m->update('keluar',['id'=>$id],$data);
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
	    		'ditujukan'			=> $this->input->post('ditujukan'),
	    		'kategori'			=> $this->input->post('kategori'),
	    		'tgl_keluar'			=> $this->input->post('tgl_keluar'),
	    		'perihal'			=> $this->input->post('perihal'),
	    		'keterangan'			=> $this->input->post('keterangan'),
	    		'status'			=> $this->input->post('status'),
	    	);
	    	$this->m->update('keluar',['id'=>$id],$data);
	    	$this->session->set_flashdata('success', 'Data berhasil di rubah');
	    	redirect($this->agent->referrer());
	    }

	}

	function detkeluar($id)
	{
		$data['title']= "APS | Surat Keluar Detail";
		$data['lama'] = $this->m->get_where('keluar', ['id' => $id])->result();
		$this->load->view('staff/header', $data);
		$this->load->view('kasubag/detailkeluar');
		$this->load->view('staff/footer');		
	}


	function delkeluar($id)
	{
		$lama  = $this->m->get_where('keluar', ['id' => $id])->result();
		if (file_exists("upload/keluar/".$lama[0]->foto)) {	
			unlink('upload/keluar/'.$lama[0]->foto);
		}

		$this->m->drop('keluar',['id'=>$id]);
		$this->session->set_flashdata('success', 'Surat keluar berhasil di hapus');
		redirect($this->agent->referrer());
	}

	function disposisi()
	{
		$data['title']   = "APS | Disposisi Surat";
		$data['list'] 	 = $this->m->get_table('disposisi');
		$this->load->view('staff/header', $data);
		$this->load->view('staff/disposisi');
		$this->load->view('staff/footer');
	}


	function detail($id)
	{
		$data['title']   = "APS | Detail Disposisi Surat";
		$data['list'] 	 = $this->m->get_where('disposisi',['id'=>$id])->row();
		$this->load->view('staff/header', $data);
		$this->load->view('staff/detail');
		$this->load->view('staff/footer');
	}

	function tugas()
	{
		$data['title']   = "APS | Monitoring Tugas";
		$data['keluar'] = $this->m->get_table('keluar');
		$this->load->view('staff/header', $data);
		$this->load->view('staff/tugas');
		$this->load->view('staff/footer');
	}


	function laporan()
	{
		$data['title']   = "APS | Laporan Rekapitulasi";
		$this->load->view('staff/header', $data);
		$this->load->view('staff/laporan');
		$this->load->view('staff/footer');	
	}

	function rekap()
	{
		$data['masuk']  = $this->db->where("tgl_masuk BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('masuk');
		$data['keluar']  = $this->db->where("tgl_keluar BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('keluar');
		$data['disposisi']  = $this->db->where("tgl_diterima BETWEEN '".$this->input->post('dari')."' and '".$this->input->post('sampai')."' ")->get('disposisi');
		$data['title']   = "Arsip | Laporan Rekapitulasi";
		$data['dari'] = $this->input->post('dari');
		$data['sampai'] = $this->input->post('sampai');
		$this->load->view('staff/header', $data);
		$this->load->view('staff/rekap');
		$this->load->view('staff/footer');	
	}

}

/* End of file Staff.php */
/* Location: ./application/controllers/Staff.php */