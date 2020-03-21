<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rest extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
 
	}

	public function index()
	{
		$data = $this->db->get('ubersugest')->result();
		if($data){
			echo json_encode(['status' => 1 ,'data' => $data]);
			exit();
		}
		echo json_encode(['status' => 0]);
		exit();
	}

    function insert() {

		if(!$this->input->post('keyword') || !$this->input->post('volume') || !$this->input->post('cpc')){
			echo json_encode(['status' => 0, 'msg' => 'isi dulu.']);
			exit();
		}

		$this->form_validation->set_rules('keyword', $this->input->post('keyword'), 'trim|required|is_unique[ubersugest.keyword]');

		if($this->form_validation->run() == false){
			echo json_encode(['status' => 0, 'msg' => 'keyword ada yang sama.']);
			exit();
		}

        $data = array(
                    'keyword'		=> $this->input->post('keyword'),
                    'volume'		=> $this->input->post('volume'),
					'cpc'			=> $this->input->post('cpc')
				);
        $insert = $this->db->insert('ubersugest', $data);
        if ($insert) {
			echo json_encode(['status' => 1, 'msg' => 'sukses.']);
			exit();
        } else {
            echo json_encode(['status' => 0, 'msg' => 'gagal masukkan data.']);
			exit();
		}
		
	}
	function edit() {

		if(!$this->input->post('keyword') || !$this->input->post('volume') || !$this->input->post('cpc')){
			echo json_encode(['status' => 0, 'msg' => 'isi dulu.']);
			exit();
		}

		$query = $this->db->get_where('ubersugest', array('keyword' => $this->input->post('keyword')));
    	if($query->num_rows() > 1){
    	    echo json_encode(['status' => 0, 'msg' => 'keyword ada yang sama/id tidak terkirim.']);
			exit();
    	}

		$data = array(
			'id'			=> $this->input->post('id'),
			'keyword'		=> $this->input->post('keyword'),
			'volume'		=> $this->input->post('volume'),
			'cpc'			=> $this->input->post('cpc')
		);

		$edit = $this->db->replace('ubersugest', $data);

		if ($edit) {
			echo json_encode(['status' => 1, 'msg' => 'sukses edit - '.$this->input->post('keyword').'.']);
			exit();
        } else {
            echo json_encode(['status' => 0, 'msg' => 'gagal edit data.']);
			exit();
		}
	}

	function delete(){
		
		if(!$this->input->post('id')){
			echo json_encode(['status' => 0, 'msg' => 'id tidak terdeteksi.']);
			exit();
		}

		$query = $this->db->get_where('ubersugest', array('id' => $this->input->post('id')));
		if(!$query->num_rows()){
			echo json_encode(['status' => 0, 'msg' => 'Tidak ada data untuk dihapus.']);
			exit();
		}

		foreach($query->result() as $ntod){
			$kw = $ntod->keyword;
		}

		$delete = $this->db->delete('ubersugest', array('id' => $this->input->post('id')));

		if ($delete) {
			echo json_encode(['status' => 1, 'msg' => 'sukses hapus - '.$kw.'.']);
			exit();
        } else {
            echo json_encode(['status' => 0, 'msg' => 'gagal delete data.']);
			exit();
		}
	}

}
