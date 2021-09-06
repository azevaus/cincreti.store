<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Login extends CI_Controller{
    function __construct(){
        parent::__construct();
        //sessao valida
    }
    public function index(){
        $data = array(
            'titulo' => 'Login na Cincreti Store',
        );        
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/login');
        $this->load->view('web/layout/footer');
    }
   public function auth(){
        $identity = $this->input->post('email');
        $password = $this->input->post('password');
        $remember = ($this->input->post('remember' ? TRUE : FALSE));
        $login = $this->input->post('login');
        if($this->ion_auth->login($identity, $password, $remember)){
            if($this->ion_auth->is_admin()){
                redirect('restrita');
            }else{
                $cliente = $this->core_model->get_by_id('clientes', array('cliente_email' => $identity));
                $this->session->set_userdata('cliente_user_id', $cliente->cliente_id);
                $this->session->set_userdata('cliente_nome', $cliente->cliente_nome .' '. $cliente->cliente_sobrenome);
                if($login == 'login'){
                    redirect('/');
                }else{
                    redirect( 'checkout');
                } 
            }
        }else{
            $this->session->set_flashdata('erro', 'Verifique seu usuário e/ou senha');
            redirect('login');
        }
        

   }
    public function logout(){
        $this->ion_auth->logout();
        redirect('/');
    }
}
