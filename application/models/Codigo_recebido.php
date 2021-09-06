<?php 
defined('BASEPATH') OR exit('Ação não permitida');
class Codigo_recebido extends CI_Model{
    public function verifica_codigo($condicoes = NULL){
        $this->db->select([
            'clients.*',
        ]);
        $this->db->where('clients.client_code', $condicoes);
        return $this->db->get('clients')->result();
    }
}