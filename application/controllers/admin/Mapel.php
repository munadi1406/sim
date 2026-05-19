<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mapel extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function index($offset = 0) {
        $filters = [
            'search'  => $this->input->get('search'),
            'guru_id' => $this->input->get('guru_id'),
        ];

        $per_page = 10;
        $config['base_url']             = base_url('admin/mapel/index');
        $config['total_rows']           = $this->Mapel_model->count_all($filters);
        $config['per_page']             = $per_page;
        $config['uri_segment']          = 4;
        $config['reuse_query_string']   = TRUE;
        $config['full_tag_open']        = '<nav><ul class="pagination">';
        $config['full_tag_close']       = '</ul></nav>';
        $config['first_link']           = 'Awal';
        $config['last_link']            = 'Akhir';
        $config['next_link']            = '›';
        $config['prev_link']            = '‹';
        $config['cur_tag_open']         = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']        = '</span></li>';
        $config['num_tag_open']         = '<li class="page-item">';
        $config['num_tag_close']        = '</li>';
        $config['attributes']           = ['class' => 'page-link'];

        $this->pagination->initialize($config);

        $data['title']      = 'Mata Pelajaran';
        $data['mapel']      = $this->Mapel_model->get_all_with_guru($filters, $per_page, $offset);
        $data['pagination'] = $this->pagination->create_links();
        $data['guru_list']  = $this->Guru_model->get_all();
        $data['filters']    = $filters;

        $this->load->view('admin/layouts/header', $data);
        $this->load->view('admin/layouts/sidebar', $data);
        $this->load->view('admin/mapel/index', $data);
        $this->load->view('admin/layouts/footer', $data);
    }

    public function tambah() { $this->require_admin(); $data['title']='Tambah Mapel'; $data['mapel']=null; $data['guru']=$this->Guru_model->get_all(); $this->load->view('admin/layouts/header',$data); $this->load->view('admin/layouts/sidebar',$data); $this->load->view('admin/mapel/form',$data); $this->load->view('admin/layouts/footer',$data); }
    public function simpan() { $this->require_admin(); $this->form_validation->set_rules('kode','Kode','required|trim|is_unique[mata_pelajaran.kode]'); $this->form_validation->set_rules('nama','Nama','required|trim'); if($this->form_validation->run()===FALSE){$this->session->set_flashdata('error',validation_errors()); redirect('admin/mapel/tambah');} $this->Mapel_model->insert(['kode'=>strtoupper($this->input->post('kode',TRUE)),'nama'=>$this->input->post('nama',TRUE),'guru_id'=>$this->input->post('guru_id')?:null]); $this->session->set_flashdata('success','Mapel ditambahkan!'); redirect('admin/mapel'); }
    public function edit($id) { $this->require_admin(); $data['title']='Edit Mapel'; $data['mapel']=$this->Mapel_model->get_by_id($id); $data['guru']=$this->Guru_model->get_all(); if(!$data['mapel'])show_404(); $this->load->view('admin/layouts/header',$data); $this->load->view('admin/layouts/sidebar',$data); $this->load->view('admin/mapel/form',$data); $this->load->view('admin/layouts/footer',$data); }
    public function update($id) { $this->require_admin(); $this->form_validation->set_rules('nama','Nama','required|trim'); if($this->form_validation->run()===FALSE){$this->session->set_flashdata('error',validation_errors()); redirect('admin/mapel/edit/'.$id);} $this->Mapel_model->update($id,['nama'=>$this->input->post('nama',TRUE),'guru_id'=>$this->input->post('guru_id')?:null]); $this->session->set_flashdata('success','Mapel diperbarui!'); redirect('admin/mapel'); }
    public function hapus($id) { $this->require_admin(); $this->Mapel_model->delete($id); $this->session->set_flashdata('success','Mapel dihapus!'); redirect('admin/mapel'); }
}
