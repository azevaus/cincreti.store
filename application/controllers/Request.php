<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Request extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
    }
    public function index(){
        $cliente_user_id = $this->session->userdata('cliente_user_id');
        if($cliente_user_id){
            $data = array(
                'titulo' => 'Meus Pedidos',
                'pedidos' => $this->pedidos_model->get_all_pedidos_by_cliente($cliente_user_id),
            );           
        }      
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/request');
        $this->load->view('web/layout/footer');
    }
}