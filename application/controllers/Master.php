<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Master extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index($categoria_pai_meta_link = NULL){
        if(!$categoria_pai_meta_link || !$master = $this->core_model->get_by_id('masters', array('master_meta_link' => $categoria_pai_meta_link))){
            redirect('/');
        }else{
            $data = array(
                'titulo' => 'Produtos da categoria '.$master->master_name,
                'categoria'=> $master->master_name,
                'produtos' => $this->produtos_model->get_all_by(array('master_meta_link' => $categoria_pai_meta_link))
            );    
            $this->load->view('web/layout/header', $data);
		    $this->load->view('web/master');
		    $this->load->view('web/layout/footer');
        }
    }
}