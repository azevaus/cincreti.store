<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Masters extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){
        $data = array(
            'titulo' => 'Categorias Master cadastradas',
            'styles' => array(
                'bundles/datatables/datatables.min.css',
                'bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'bundles/datatables/datatables.min.js',
                'bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
                'bundles/jquery-ui/jquery-ui.min.js',
                'js/page/datatables.js'
            ),
            'master' => $this->core_model->get_all('masters'),
        );        
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/masters/index');
        $this->load->view('restrict/layout/footer');
    }
    public function core($master_id = NULL){
        $master_id = (int)$master_id;
        if (!$master_id) {
            //cadastrando...
            $this->form_validation->set_rules('master_name', 'Nome da categoria Master', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria');
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'master_name',
                        'master_active'
                    ),
                    $this->input->post()
                );
                $data['master_meta_link'] = url_amigavel($data['master_name']);                
                $data = html_escape($data);                
                $this->core_model->insert('masters', $data);
                redirect('restrict/masters');
            } else {
                //erro de validacao...
                $data = array(
                    'titulo' => 'Cadastrar categoria Master',
                );

                $this->load->view('restrict/layout/header', $data);
                $this->load->view('restrict/masters/core');
                $this->load->view('restrict/layout/footer');
            }
        } else {
            if (!$master = $this->core_model->get_by_id('masters', array('master_id' => $master_id))) {
                $this->session->set_flashdata('erro', 'Esta categoria Master nao foi encontrada');
                redirect('restrict/masters');
            } else {
                //editando...
                $this->form_validation->set_rules('master_name', 'Nome da categoria Master', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria');
                if ($this->form_validation->run()) {
                    if ($this->input->post('master_active') == 0) {
                        if ($this->core_model->get_by_id('categories', array('master_id' => $master_id))) {
                            $this->session->set_flashdata('erro', 'Essa categoria Master nao pode ser desativada, pois esta vinculada a uma categoria');
                            redirect('restrict/masters');
                        }
                    }
                    $data = elements(
                        array(
                            'master_name',
                            'master_active'
                        ),
                        $this->input->post()
                    );
                    $data['master_meta_link'] = url_amigavel($data['master_name']);
                    $data = html_escape($data);                    
                    $this->core_model->update('masters', $data, array('master_id' => $master_id));
                    redirect('restrict/masters');
                } else {
                    //erro de validacao...
                    $data = array(
                        'titulo' => 'Editar categoria Master',
                        'master' => $master,
                    );

                    $this->load->view('restrict/layout/header', $data);
                    $this->load->view('restrict/masters/core');
                    $this->load->view('restrict/layout/footer');
                }
            }
        }
    }
    public function valida_nome_categoria($master_name){
        $master_id = (int)$this->input->post('master_id');
        if (!$master_id) {
            //cadastrando...
            if ($this->core_model->get_by_id('masters', array('master_name' => $master_name))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria Master já existe');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            //editando...
            if ($this->core_model->get_by_id('masters', array('master_name' => $master_name, 'master_id != ' => $master_id))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria Master já existe');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    public function delete($master_id = NULL){
        $master_id = (int)$master_id;
        if (!$master_id || !$this->core_model->get_by_id('masters', array('master_id' => $master_id))) {
            $this->session->set_flashdata('erro', 'Essa categoria nao existe');
            redirect('restrict/masters');
        }
        if ($this->core_model->get_by_id('masters', array('master_id' => $master_id, 'master_active' => 1))) {
            $this->session->set_flashdata('erro', 'Nao é permitido excluir uma categoria Master ativa');
            redirect('restrict/masters');
        }
        $this->core_model->delete('masters', array('master_id' => $master_id));
        redirect('restrict/masters');
    }
}
