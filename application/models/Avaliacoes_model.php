<?php
defined('BASEPATH') or exit('Açao nao permitida');
class Avaliacoes_model extends CI_Model{
    public function get_avaliacoes($condicoes = NULL){
        $this->db->select([
            'notes.*',
            'clients.client_id',
            'clients.client_cpf',
            'clients.client_email',
            'clients.client_cell',
            'CONCAT(clients.client_name, " ", clients.client_surname) as avaliacao_cliente_nome',
            'products.pro_id',
            'products.pro_name',
            'products.pro_meta_link'
        ]);
        $this->db->where('notes.note_id', $condicoes);
        $this->db->join('clients', 'clients.client_id = notes.note_client_id');
        $this->db->join('products', 'products.pro_id = notes.note_product_id');        
        return $this->db->get('notes')->row();
    }
    public function get_all(){
        $this->db->select([
            'notes.*',
            'clients.client_id',
            'clients.client_cpf',
            'clients.client_email',
            'clients.client_cell',
            'CONCAT(clients.client_name, " ", clients.client_surname) as avaliacao_cliente_nome',
            'products.pro_id',
            'products.pro_name',
            'products.pro_meta_link'
        ]);
        $this->db->join('clients', 'clients.client_id = notes.note_client_id');
        $this->db->join('products', 'products.pro_id = notes.note_product_id');        
        return $this->db->get('notes')->result();
    }
}