<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Home extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){
        $data = array(
            'titulo' => 'Área administrativa',
            'vendas_concluidas' => $this->core_model->count_all_results('transacoes', array('transacao_status' => 3)),
            'vendas_canceladas' => $this->core_model->count_all_results('transacoes', array('transacao_status' => 7)),
            'total_clientes' => $this->core_model->count_all_results('clientes'),
            'total_vendas' => $this->home_model->get_soma_total_vendas(),
            'pagamentos_cartao' => $this->core_model->count_all_results('transacoes', array('transacao_tipo_metodo_pagamento' => 1)),//cartao
            'pagamentos_boleto' => $this->core_model->count_all_results('transacoes', array('transacao_tipo_metodo_pagamento' => 2)),//cartao
            'pagamentos_transferencia' => $this->core_model->count_all_results('transacoes', array('transacao_tipo_metodo_pagamento' => 3)),//cartao
        );
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/home/index');
        $this->load->view('restrict/layout/footer');
    }
}
