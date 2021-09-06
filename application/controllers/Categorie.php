<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Categorie extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index($categoria_meta_link = NULL){
        if(!$categoria_meta_link || !$categoria = $this->core_model->get_by_id('categories', array('categorie_meta_link' => $categoria_meta_link))){
            redirect('/');
        }else{
            $data = array(
                'titulo' => 'Produtos da categoria '.$categoria->categorie_name,
                'categoria' => $categoria->categorie_name,
                'produtos' => $this->produtos_model->get_all_by(array('categorie_meta_link' => $categoria_meta_link)),
                
            );   
            foreach($data['produtos'] as $produto){
                $data['categoria_pai_nome'] = $produto->master_name;
                $data['categoria_pai_meta_link'] = $produto->master_meta_link;
            } 
            /*echo '<pre>';
            print_r($data['produtos']);
            exit();*/
            $this->load->view('web/layout/header', $data);
		    $this->load->view('web/categorie');
		    $this->load->view('web/layout/footer');
        }
    }
}