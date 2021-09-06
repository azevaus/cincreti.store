<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Brands extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){ //corrigido
        $data = array(
            'titulo' => 'Marcas cadastradas',
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
            'marcas' => $this->core_model->get_all('brands'),
        );
        /*echo '<pre>';
        print_r($data);
        exit();*/
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/brands/index');
        $this->load->view('restrict/layout/footer');
    }
    public function core($brand_id = NULL){
        if (!$brand_id) {
            //cadastrando
            $this->form_validation->set_rules('brand_name', 'Nome da marca', 'trim|required|min_length[2]|max_length[40]|callback_valida_nome_marca');
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'brand_name',
                        'brand_active',
                    ),
                    $this->input->post()
                );
                $data['brand_meta_link'] = url_amigavel($data['brand_name']);
                $data = html_escape($data);
                $this->core_model->insert('brands', $data);
                redirect('restrict/brands');
            } else {
                //erro de validaacao
                $data = array(
                    'titulo' => 'Cadastrar marca',
                );

                $this->load->view('restrict/layout/header', $data);
                $this->load->view('restrict/brands/core');
                $this->load->view('restrict/layout/footer');
            }
        } else {
            if (!$brand = $this->core_model->get_by_id('brands', array('brand_id' => $brand_id))) {
                $this->session->flashdata('erro', 'A marca nao foi encontrada');
                redirect('restrict/brands');
            } else {
                //editando...
                $this->form_validation->set_rules('brand_name', 'Nome da marca', 'trim|required|min_length[2]|max_length[40]|callback_valida_nome_marca');
                if ($this->form_validation->run()) {
                    $data = elements(
                        array(
                            'brand_name',
                            'brand_active',
                        ),
                        $this->input->post()
                    );
                    $data['brand_meta_link'] = url_amigavel($data['brand_name']);
                    $data = html_escape($data);
                    $this->core_model->update('brands', $data, array('brand_id' => $brand_id));
                    redirect('restrict/marcas');
                } else {
                    //erro de validaacao
                    $data = array(
                        'titulo' => 'Editar marca',
                        'marcas' => $brand,
                    );

                    $this->load->view('restrict/layout/header', $data);
                    $this->load->view('restrict/brands/core');
                    $this->load->view('restrict/layout/footer');
                }
            }
        }
    }
    public function valida_nome_marca($brand_name){
        $brand_id = $this->input->post('brand_id');
        if (!$brand_id) {
            //cadastrando
            if ($this->core_model->get_by_id('brands', array('brand_name' => $brand_name))) {
                $this->form_validation->set_message('valida_nome_marca', 'Essa marca já existe');
                return false;
            } else {
                return true;
            }
        } else {
            //editando
            if ($this->core_model->get_by_id('brands', array('brand_name' => $brand_name, 'brand_id !=' => $brand_id))) {
                $this->form_validation->set_message('valida_nome_marca', 'Essa marca já existe');
                return false;
            } else {
                return true;
            }
        }
    }
    public function delete($brand_id = NULL){
        $brand_id = (int) $brand_id;
        if (!$brand_id || !$this->core_model->get_by_id('brands', array('brand_id' => $brand_id))) {
            $this->session->set_flashdata('erro', 'A marca nao foi encontrada');
            redirect('restrict/brands');
        }
        if ($this->core_model->get_by_id('brands', array('brand_id' => $brand_id, 'brand_active' => 1))) {
            $this->session->set_flashdata('erro', 'Nao é possivel excluir uma marca ativa');
            redirect('restrict/brands');
        }
        $this->core_model->delete('brands', array('brand_id' => $brand_id));
        redirect('restrict/brands');
    }
}
