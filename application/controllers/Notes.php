<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Notes extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }   
    public function core($produto_meta_link = null){
        if(!$produto_meta_link || !$produto = $this->produtos_model->get_by_id($produto_meta_link)){
            redirect('/');
        }else{
            $this->form_validation->set_rules('avaliacao_nome', 'nome', 'trim|min_length[4]|max_length[40]');
            $this->form_validation->set_rules('avaliacao_email', 'e-mail', 'trim|min_length[4]|max_length[40]');
            $this->form_validation->set_rules('avaliacao_comentario', 'comentário', 'trim|required|min_length[4]|max_length[240]');
            $this->form_validation->set_rules('avaliacao_nota', 'nota', 'required');
            if($this->form_validation->run()){
                $data = elements(
                    array(
                        'avaliacao_nome',
                        'avaliacao_email',
                        'avaliacao_comentario',
                        'avaliacao_produto_id',
                        'avaliacao_cliente_id', 
                        'avaliacao_nota' 
                    ), $this->input->post()
                );
                $data = html_escape($data);
                $this->core_model->insert('avaliacoes', $data);          
                $data = array(
                    'produto' => $produto,
                    'avaliacoes' => $this->store_model->get_avaliacoes('avaliacoes', array('avaliacao_produto_id' => $produto->produto_id)),
                    'cliente' => $this->session->userdata()
                );
                $data['fotos_produtos'] = $this->core_model->get_all('produtos_fotos', array('foto_produto_id' => $produto->produto_id));
                $this->load->view('web/layout/header', $data);
                $this->load->view('web/single_product');
                $this->load->view('web/layout/footer');
            }else{
                $data = array(
                    'titulo' => 'Deixe sua avaliação.',
                    'produto' => $produto,
                    'avaliacoes' => $this->store_model->get_avaliacoes('avaliacoes', array('avaliacao_produto_id' => $produto->produto_id)),
                    'cliente' => $this->session->userdata()
                );
                $data['fotos_produtos'] = $this->core_model->get_all('produtos_fotos', array('foto_produto_id' => $produto->produto_id));
                $this->load->view('web/layout/header', $data);
                $this->load->view('web/single_product');
                $this->load->view('web/layout/footer');
                
            }
        }
    }            
}