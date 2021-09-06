<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Brand extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index($marca_meta_link = NULL){
        if(!$marca_meta_link || !$marca = $this->core_model->get_by_id('brands', array('brand_meta_link' => $marca_meta_link))){
            redirect('/');
        }else{
            $data = array(
                'titulo' => 'Produtos da '.$marca->brand_name,
                'marca' => $marca->brand_name,
                'produtos' => $this->produtos_model->get_all_by(array('brand_meta_link' => $marca_meta_link))
            ); 
            
            $this->load->view('web/layout/header', $data);
		    $this->load->view('web/brand');
		    $this->load->view('web/layout/footer');
        }
    }
}