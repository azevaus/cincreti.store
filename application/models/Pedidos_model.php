<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Pedidos_model extends CI_Model{
    public function get_all_pedidos_by_cliente($cliente_user_id = NULL){//recupera todos os pedidos do cliente logado na loja virtual
        $this->db->select([
            'requests.request_date_start',
            'requests.request_code',
            'requests.request_value_total',
            'CONCAT(clients.client_name, " ", clients.cliente_surname) as pedido_cliente_nome',
            'transacoes.transacao_status as pedido_status',
            'requests_products.request_id',
            'requests_products.product_id',
            'requests_products.product_name',
            'products_photos.photo_path',
        ]);
        $this->db->where('requests.request_client_id', $cliente_user_id);
        $this->db->join('clients', 'clients.client_id = requests.request_client_id');
        $this->db->join('transacoes', 'transacoes.transacao_pedido_id = requests.pedido_id');
        $this->db->join('requests_products', 'requests_products.request_id = requests.pedido_id');
        $this->db->join('products_photos', 'products_photos.photo_pro_id = requests_products.product_id');
        $this->db->group_by('requests.request_date_start');
        $this->db->order_by('requests.request_date_start', 'DESC');
        return $this->db->get('requests')->result();
    }
    public function get_all($cliente_user_id = NULL){//recupera todos os pedidos da area restrita
        $this->db->select([
            'requests.request_date_start',
            'requests.request_code',
            'requests.request_value_total',
            'clients.client_id',
            'CONCAT(clients.client_name, " ", clients.client_surname) as pedido_cliente_nome',
            'transacoes.transacao_status as pedido_status',            
        ]);
        $this->db->join('clients', 'clients.client_id = requests.request_client_id', 'LEFT');
        $this->db->join('transacoes', 'transacoes.transacao_pedido_id = requests.pedido_id', 'LEFT');
        $this->db->order_by('requests.request_date_start', 'DESC');
        return $this->db->get('requests')->result();
    }
    public function get_by_codigo($pedido_codigo =NULL){
        $this->db->select([
            'requests.*',
            'clients.client_id',
            'CONCAT(clients.client_name, " ", clients.client_surname) as pedido_cliente_nome',
            'clients.*',
            'transacoes.transacao_status as pedido_status',            
        ]);
        $this->db->where('requests.request_code', $pedido_codigo);
        $this->db->join('clients', 'clients.client_id = requests.request_client_id', 'LEFT');
        $this->db->join('transacoes', 'transacoes.transacao_pedido_id = requests.pedido_id', 'LEFT');
        return $this->db->get('requests')->row();

    }
    public function get_vendas_hoje(){//recupera as vendas diarias
        $this->db->select([
            'requests.*',
            'clients.client_id',
            'CONCAT(clients.client_name, " ", clients.client_surname) as pedido_cliente_nome',
            'transacoes.transacao_status as pedido_status',            
        ]);
        $this->db->join('clients', 'clients.client_id = requests.request_client_id', 'LEFT');
        $this->db->join('transacoes', 'transacoes.transacao_pedido_id = requests.pedido_id', 'LEFT');
        $this->db->where("SUBSTR(request_date_start, 1, 10) = ", date('Y-m-d'));
        return $this->db->get('requests')->result();
    }
    public function get_produtos_mais_vendidos(){
        $this->db->select([
            'requests_products.*',
            'COUNT(*) as vendidos',
        ]);
        $this->db->group_by('requests_products.product_id');
        $this->db->order_by('vendidos', 'DESC');
        return $this->db->get('requests_products')->result();
    }
    public function get_all_pedidos($condicoes = NULL){
        $this->db->select([
            'requests.*'
        ]);
        if($condicoes && is_array($condicoes)){
            $this->db->where($condicoes);
        }
        return $this->db->get('requests')->result();
    }
}