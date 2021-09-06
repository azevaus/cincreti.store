<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();        
    }
    public function index(){
        $data = array(
            'titulo' => 'Acesso ao Adm',
            //'login' => $this->core_model->login(),
        );
        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/login/index');
        $this->load->view('restrita/layout/footer');
    }
    public function auth(){
        $identity = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = ($this->input->post('remember' ? TRUE : FALSE));
        if ($this->ion_auth->login($identity, $password, $remember)) {
            $this->session->set_flashdata('sucesso', 'Seja bem-vindo(a)');
            redirect('restrita');            
        } else {
            $this->session->set_flashdata('erro', 'Verifique seu usuário e/ou senha');
            redirect('restrita/login');
        }
    }
    public function logout(){
        $this->ion_auth->logout();
        redirect('restrita/login');
    }
}