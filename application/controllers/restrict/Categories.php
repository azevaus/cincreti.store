<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Categories extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){ //consertado
        $data = array(
            'titulo' => 'Categorias cadastradas',
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
            'categorias' => $this->core_model->get_all('categories'),
        );
        /*echo '<pre>';
        print_r($data);
        exit();*/
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/categories/index');
        $this->load->view('restrict/layout/footer');
    }
    public function core($categorie_id = NULL){
        $categorie_id = (int)$categorie_id;
        if (!$categorie_id) {
            //cadastrando...
            $this->form_validation->set_rules('categorie_name', 'Nome da categoria', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria');
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'categorie_name',
                        'categorie_active',
                        'master_id'
                    ),
                    $this->input->post()
                );
                $data['categorie_meta_link'] = url_amigavel($data['categorie_name']);

                $data = html_escape($data);
                $this->core_model->insert('categories', $data);
                redirect('restrict/categories');
            } else {
                //erro de validacao...
                $data = array(
                    'titulo' => 'Cadastrar categoria',
                    'masters' => $this->core_model->get_all('masters', array('master_active' => 1))
                );
                $this->load->view('restrict/layout/header', $data);
                $this->load->view('restrict/categories/core');
                $this->load->view('restrict/layout/footer');
            }
        } else {
            if (!$categoria = $this->core_model->get_by_id('categories', array('categorie_id' => $categorie_id))) {
                $this->session->set_flashdata('erro', 'Esta categoria nao foi encontrada');
                redirect('restrict/categories');
            } else {
                //editando...
                $this->form_validation->set_rules('categorie_name', 'Nome da categoria', 'trim|required|min_length[4]|max_length[40]|callback_valida_nome_categoria');
                if ($this->form_validation->run()) {
                    $data = elements(
                        array(
                            'categorie_name',
                            'categorie_active',
                            'master_id'
                        ),
                        $this->input->post()
                    );
                    $data['categorie_meta_link'] = url_amigavel($data['categorie_name']);
                    $data = html_escape($data);
                    $this->core_model->update('categories', $data, array('categorie_id' => $categorie_id));
                    redirect('restrict/categories');
                } else {
                    //erro de validacao...
                    $data = array(
                        'titulo' => 'Editar categoria',
                        'categorias' => $categoria,
                        'masters' => $this->core_model->get_all('masters', array('master_active' => 1))
                    );

                    $this->load->view('restrict/layout/header', $data);
                    $this->load->view('restrict/categories/core');
                    $this->load->view('restrict/layout/footer');
                }
            }
        }
    }
    public function valida_nome_categoria($categorie_name){
        $categorie_id = (int)$this->input->post('categorie_id');
        if (!$categorie_id) {
            //cadastrando...
            if ($this->core_model->get_by_id('categories', array('categorie_name' => $categorie_name))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            //editando...
            if ($this->core_model->get_by_id('categories', array('categorie_name' => $categorie_name, 'categorie_id != ' => $categorie_id))) {
                $this->form_validation->set_message('valida_nome_categoria', 'Essa categoria já existe');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    public function delete($categorie_id = NULL){
        $categorie_id = (int)$categorie_id;
        if (!$categorie_id || !$this->core_model->get_by_id('categories', array('categorie_id' => $categorie_id))) {
            $this->session->set_flashdata('erro', 'Essa categoria nao existe');
            redirect('restrict/categories');
        }
        if ($this->core_model->get_by_id('categories', array('categorie_id' => $categorie_id, 'categorie_active' => 1))) {
            $this->session->set_flashdata('erro', 'Nao é permitido excluir uma categoria ativa');
            redirect('restrict/categories');
        }
        $this->core_model->delete('categories', array('categorie_id' => $categorie_id));
        redirect('restrict/categories');
    }
}
