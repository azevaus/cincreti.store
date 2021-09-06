<?php
defined('BASEPATH') or exit('Açao nao permitida');
class Transacoes_model extends CI_Model{
    public function get_by_id($transacao_id = NULL){//para detalhar a transacao
        $this->db->select([
            'transacoes.*',
            'pedidos.pedido_codigo',
            'CONCAT(clientes.cliente_nome, " ", clientes.cliente_sobrenome) as pedido_cliente_nome'
        ]);
        $this->db->where('transacoes.transacao_id', $transacao_id);
        $this->db->join('clientes', 'clientes.cliente_id = transacoes.transacao_cliente_id', 'LEFT');
        $this->db->join('pedidos', 'pedidos.pedido_id = transacoes.transacao_pedido_id', 'LEFT');
        return $this->db->get('transacoes')->row();
    }
    public function get_first_date($data_final = NULL){//recupera a primeira transaco cujo intervalo entre $data_final_banco->transacao_data e $data_inical_banco nao seja superior a 30 dias
        $this->db->select([
            'transacoes.transacao_id',
            'DATE_FORMAT(transacoes.transacao_data,"%Y-%m-%dT%H:%i") as transacao_data', false,
            'transacoes.transacao_codigo_hash',
            'transacoes.transacao_status',
        ]);
        $this->db->where("DATEDIFF('".$data_final."', transacao_data) <= 30");
        $this->db->where('transacoes.transacao_status != ', 6);//devolvida
        $this->db->where('transacoes.transacao_status != ', 7);//cancelada
        return $this->db->get('transacoes')->first_row();
    }
    public function get_last_date(){//recupera a data final para compor a consulta por intervalo de datas
        $this->db->select([
            'transacoes.transacao_id',
            'transacoes.transacao_data as transacao_data_original',
            'DATE_FORMAT(transacoes.transacao_data,"%Y-%m-%dT%H:%i") as transacao_data', false,
            'transacoes.transacao_codigo_hash',
            'transacoes.transacao_status',
        ]);
        $this->db->where('transacoes.transacao_status != ', 6);//devolvida
        $this->db->where('transacoes.transacao_status != ', 7);//cancelada
        return $this->db->get('transacoes')->last_row();
    }
    public function get_all_transacoes_intervalo($data_inical_banco = NULL){//recupera o invervalo de data
        $this->db->select([
            'transacoes.transacao_id',
            'transacoes.transacao_data',
            'transacoes.transacao_codigo_hash',
            'transacoes.transacao_status',
        ]);
        $this->db->where('transacoes.transacao_data > ', $data_inical_banco);
        $this->db->where('transacoes.transacao_status != ', 6);//devolvida
        $this->db->where('transacoes.transacao_status != ', 7);//cancelada
        return $this->db->get('transacoes')->result();
    }
}