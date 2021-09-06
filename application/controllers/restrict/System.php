<?php
defined('BASEPATH') or exit('Ação não permitida.');
class System extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){
        $this->form_validation->set_rules('sistema_razao_social', 'Razao social', 'trim|required|min_length[5]|max_length[100]');
        $this->form_validation->set_rules('sistema_nome_fantasia', 'Nome fantasia', 'trim|required|min_length[5]|max_length[45]');
        $this->form_validation->set_rules('sistema_cnpj', 'CNPJ', 'trim|required|exact_length[18]');
        $this->form_validation->set_rules('sistema_ie', 'Inscriçao Estadual', 'trim|required|min_length[5]|max_length[25]');
        $this->form_validation->set_rules('sistema_telefone_fixo', 'Telefone fixo', 'trim|required|exact_length[14]');
        $this->form_validation->set_rules('sistema_telefone_movel', 'Telefone móvel', 'trim|required|min_length[14]|max_length[15]');
        $this->form_validation->set_rules('sistema_cep', 'CEP', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('sistema_endereco', 'Endereço', 'trim|required|min_length[5]|max_length[145]');
        $this->form_validation->set_rules('sistema_numero', 'Número', 'trim|required|max_length[30]');
        $this->form_validation->set_rules('sistema_cidade', 'Cidade', 'trim|required|min_length[4]|max_length[50]');
        $this->form_validation->set_rules('sistema_estado', 'UF', 'trim|required|exact_length[2]');
        $this->form_validation->set_rules('sistema_site_url', 'URL do site', 'trim|required|valid_url|max_length[100]');
        $this->form_validation->set_rules('sistema_email', 'E-mail de contato', 'trim|required|valid_email|max_length[100]');
        $this->form_validation->set_rules('sistema_produtos_destaques', 'Quantidade de produtos', 'trim|required|integer');

        if ($this->form_validation->run()) {
            $data = elements(
                array(
                    'sistema_razao_social',
                    'sistema_nome_fantasia',
                    'sistema_cnpj',
                    'sistema_ie',
                    'sistema_telefone_fixo',
                    'sistema_telefone_movel',
                    'sistema_cep',
                    'sistema_endereco',
                    'sistema_numero',
                    'sistema_cidade',
                    'sistema_estado',
                    'sistema_site_url',
                    'sistema_email',
                    'sistema_produtos_destaques',
                ),
                $this->input->post()
            );
            $data['sistema_estado'] = strtoupper($data['sistema_estado']);
            $data = html_escape($data);
            $this->core_model->update('sistema', $data, array('sistema_id' => 1));
            redirect('restrict/system');
        } else {
            //Erro de validacao
            $data = array(
                'titulo' => 'Informaçoes da loja',
                'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
                'scripts' => array(
                    'mask/jquery.mask.min.js',
                    'mask/custom.js',
                ),
            );
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/system/index');
            $this->load->view('restrict/layout/footer');
        }
    }
    public function correios(){
        $this->form_validation->set_rules('config_cep_origem', 'CEP de origem', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('config_codigo_pac', 'Serviço PAC', 'trim|required|exact_length[5]');
        $this->form_validation->set_rules('config_codigo_sedex', 'Serviço SEDEX', 'trim|required|exact_length[5]');
        $this->form_validation->set_rules('config_somar_frete', 'Somar ao frete', 'trim|required');
        $this->form_validation->set_rules('config_valor_declarado', 'Valor declarado', 'trim|required');
        if ($this->form_validation->run()) {
            $data = elements(
                array(
                    'config_cep_origem',
                    'config_codigo_pac',
                    'config_codigo_sedex',
                    'config_somar_frete',
                    'config_valor_declarado',
                ),
                $this->input->post()
            );
            $data['config_somar_frete'] = str_replace(',', '', $data['config_somar_frete']);
            $data['config_valor_declarado'] = str_replace(',', '', $data['config_valor_declarado']);
            $data = html_escape($data);
            $this->core_model->update('config_correios', $data, array('config_id' => 1));
            redirect('restrict/system/correios');
        }else{
             //Erro de validacao
             $data = array(
                'titulo' => 'Editar informacoes dos correios',
                'correio' => $this->core_model->get_by_id('config_correios', array('config_id' => 1)),
                'scripts' => array(
                    'mask/jquery.mask.min.js',
                    'mask/custom.js',
                ),
            );
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/system/correios');
            $this->load->view('restrict/layout/footer');
        }
    }
    public function pagseguro(){
        $this->form_validation->set_rules('config_email', 'Email de acesso', 'trim|required|valid_email');
        $this->form_validation->set_rules('config_token', 'Token de acesso', 'trim|required|max_length[100]');
        
        if ($this->form_validation->run()) {
            $data = elements(
                array(
                    'config_email',
                    'config_token',
                    'config_ambiente'
                ),
                $this->input->post()
            );
            $data = html_escape($data);
            $this->core_model->update('config_pagseguro', $data, array('config_id' => 1));
            redirect('restrict/system/pagseguro');
        }else{
             //Erro de validacao
             $data = array(
                'titulo' => 'Editar informacoes do PagSeguro',
                'pagseguro' => $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1)),
            );
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/system/pagseguro');
            $this->load->view('restrict/layout/footer');
        }
    }
}
