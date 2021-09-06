<?php
defined('BASEPATH') OR exit('Açao nao permitida');
class Home_model extends CI_Model{
    public function get_soma_total_vendas(){
        $this->db->select([
            'SUM(transacoes.transacao_valor_liquido) as total_vendas'
        ]);
        $this->db->where('transacoes.transacao_status', 3);
        return $this->db->get('transacoes')->row();
    }
}