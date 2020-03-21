<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
    function index(){
        $this->load->helper('url');

        if(!empty(isset($_POST['cek'])) || !empty(isset($_GET['del']))){

            $data = "";
            if(!empty(isset($_POST['cek']))){
                if($_POST['cek'] == 'insert'){
                    $urll = site_url('/rest/insert');
                    $data = ['keyword' => $this->input->post('keyword'), 'volume' => $this->input->post('volume'), 'cpc' => $this->input->post('cpc')];
                }else if($_POST['cek'] == 'edit'){
                    $urll = site_url('/rest/edit');
                    $data = ['id' => $this->input->post('id'), 'keyword' => $this->input->post('keyword'), 'volume' => $this->input->post('volume'), 'cpc' => $this->input->post('cpc')];
                }
            }

            if(!empty(isset($_GET['del']))){
                $data = ['id' => $this->input->get('del')];
                $urll = site_url('/rest/delete');
            }
            
            $ch = curl_init($urll);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respon = curl_exec($ch);
            curl_close($ch);
            $okeh = json_decode($respon, false);
            $this->session->set_flashdata('msg', $okeh->msg);
            $this->session->set_flashdata('status', $okeh->status);

            // redirect(site_url(),'refresh');
        }

        $this->load->view('home');
    }
}