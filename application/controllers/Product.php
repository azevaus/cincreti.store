<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Product extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index($pro_meta_link = NULL){
        if(!$pro_meta_link || !$produto = $this->produtos_model->get_by_product($pro_meta_link)){
            redirect('/');
        }else{
            $data = array(
                'titulo' => 'Descriçao do produto ',
                'produto' => $produto,
                'scripts' => array(
                    'mask/jquery.mask.min.js',
                    'mask/custom.js', 
                    'js/add_produto.js',                    
                ),
                'avaliacoes' => $this->store_model->get_avaliacoes('notes', array('note_product_id' => $produto->pro_id)),  
                'cliente' => $this->session->userdata()                
            );    

            $data['fotos_produto'] = $this->core_model->get_all('products_photos', array('photo_pro_id' => $produto->pro_id)); 
            $this->load->view('web/layout/header', $data);
            $this->load->view('web/single_product');
            $this->load->view('web/layout/footer');
        }
    }
    public function favoritos($produto_id = NULL){
        $data = array(
            'titulo' => 'Meus favoritos',
                'scripts' => array(
                    'mask/jquery.mask.min.js',
                    'mask/custom.js',
                    'js/carrinho.js', 
                ),
            );
            $favoritos = array(
                'favoritos'=> $this->favoritos_compras->get_all(),
            );
            
            $this->load->view('web/layout/header', $data);
            $this->load->view('web/favoritos', $favoritos);
            $this->load->view('web/layout/footer');
    }
}