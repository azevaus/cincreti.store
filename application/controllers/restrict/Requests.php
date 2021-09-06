<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Requests extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->is_admin()) {
            redirect('restrict/login');
        }
    }
    public function index(){
        $data = array(
            'titulo' => 'Pedidos feitos',
            'styles' => array(
                'bundles/datatables/datatables.min.css',
                'bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'bundles/datatables/datatables.min.js',
                'bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
                'bundles/jquery-ui/jquery-ui.min.js',
                'js/page/datatables.js'
            ),
            'pedidos' => $this->pedidos_model->get_all(),
        );
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/resquests/index');
        $this->load->view('restrict/layout/footer');
    }
    public function imprimir($pedido_codigo = NULL){
        if(!$pedido_codigo || !$pedido = $this->pedidos_model->get_by_codigo($pedido_codigo)){
            $this->session->set_flashdata('erro', 'O pedido nao foi encontrado');
            redirect('restrict/resquests');
        }else{
            $data = array(
                'titulo' => 'Detalhes do pedido '.$pedido_codigo,
                'pedido' => $pedido,
            );
            $data['pedido_produtos'] = $this->core_model->get_all('requests_products', array('request_id' => $pedido->pedido_id));
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/resquests/imprimir');
            $this->load->view('restrict/layout/footer');
        }        
    }
    public function diarias(){
        $data = array(
            'titulo' => 'Relatório de vendas diárias - '.date('d/m/y'),
        );
        if($pedidos = $this->pedidos_model->get_vendas_hoje()){
            $data['pedidos'] = $pedidos;
        }
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/resquests/diarias');
        $this->load->view('restrict/layout/footer');
    }
    public function vendidos(){
        $data = array(
            'titulo' => 'Relatório de produtos mais vendidos',
        );
        if($pedidos = $this->pedidos_model->get_produtos_mais_vendidos()){
            $data['produtos'] = $pedidos;
        }
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/resquests/vendidos');
        $this->load->view('restrict/layout/footer');
    }
}