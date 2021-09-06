<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Search extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $busca = html_escape($this->input->post('busca'));
        $data = array(
            'titulo' => 'Busca pelo Produto '. (!empty($busca) ? $busca : 'Nenhum termo digitado'),
            'produto_buscado' => (!empty($busca) ? $busca : 'Nenhum termo digitado')
        ); 
        if($busca){
            if($produtos = $this->produtos_model->get_all_by_busca($busca)){
                $data['produtos'] = $produtos;            
            }
        }
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/search');
        $this->load->view('web/layout/footer');        
    }
}