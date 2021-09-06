<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Confirmation extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('codigo_recebido');        
    }
    public function index($cliente_user_id = null){
        $cliente_user_id = (int)$this->session->userdata('last_id');
        $data = array(
            'titulo' => 'Confirmacao de cadastro',
            'cliente' => $this->core_model->confirmacao($cliente_user_id),
        );

        $this->load->view('web/layout/header', $data);
        $this->load->view('web/confirmation');
        $this->load->view('web/layout/footer');
    }
    public function confirmacao_email($cliente_id = null){
        $cliente_id = (int)$this->session->userdata('last_id');;
        $this->form_validation->set_rules('codigo_digitado', 'Digite o codigo completo', 'trim|required');
        if($this->form_validation->run()){
            $data = elements(
                array(                    
                    'client_id' => $cliente_id,
                    'codigo_digitado' 
                ),$this->input->post()
            );
            $codigo_digitado = $this->input->post('codigo_digitado');
            if($data['confirmacao'] = $this->codigo_recebido->verifica_codigo($codigo_digitado)){
                $cliente_id = (int)$this->session->userdata('last_id');
                $data = array(
                    'active' => 1,
                    'user' => $this->core_model->confirmacao_teste($cliente_id)
                );

                $this->core_model->update('users', array('cliente_user_id' => $cliente_id));
                $this->session->set_flashdata('sucesso', 'Seu cadastro foi confirmado com sucesso!');    
                redirect('login');          
            }else{
                $this->session->set_flashdata('erro', 'Se ainda não recebu o código, clique aqui');    
                redirect('confirmation');
            }            
            $this->load->view('web/layout/header', $data);
		    $this->load->view('web/confirmation');
		    $this->load->view('web/layout/footer');
        }else{
            //erro de validacao
        }
    }
}