<?php 

defined('BASEPATH') OR exit('Acao nao permitida');
class Store_model extends CI_Model{
    public function get_grandes_marcas(){
        $this->db->select([
            'brands.*'
        ]);
        $this->db->where('brand_active', 1);
        $this->db->join('products', 'products.pro_brand_id = brands.brand_id');
        $this->db->group_by('brand_name');
        return $this->db->get('brands')->result();
    }
    public function get_categorias_master(){
        $this->db->select([
            'masters.*',
            'products.pro_name'
        ]);
        $this->db->where('master_active', 1);
        $this->db->join('categories', 'categories.master_id = masters.master_id', 'LEFT');
        $this->db->join('products', 'products.pro_categ_id = categories.categorie_id');
        $this->db->group_by('masters.master_name');
        return $this->db->get('masters')->result();
    }
    public function get_categorias($categoria_pai_id = NULL){
        $this->db->select([
            'categories.*',
            'products.pro_name'
        ]);
        $this->db->where('categories.master_id', $categoria_pai_id);
        $this->db->where('categories.categorie_active', 1);
        $this->db->join('products', 'products.pro_categ_id = categories.categorie_id');
        $this->db->group_by('categories.categorie_name');
        return $this->db->get('categories')->result();
    }
    public function get_pro_destaque($num_pro_destaques = null){
        $this->db->select([
            'products.pro_id',
            'products.pro_name',
            'products.pro_value',
            'products.pro_meta_link',
            'products_photos.photo_path',
            'products.pro_note_id',
            'SUM(notes.note)/COUNT(products.pro_id) as nota'
        ]);
        $this->db->join('notes','notes.note_product_id = products.pro_id', 'LEFT');
        $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id');
        $this->db->where('products.pro_destaque', 1);
        $this->db->where('products.pro_active' , 1);
        $this->db->limit($num_pro_destaques);
        $this->db->group_by('products.pro_id');
        return $this->db->get('products')->result();
    }
    public function get_pro_lateral(){
        $this->db->select([
            'products.pro_name',
            'products.pro_meta_link',
            'products_photos.photo_path'
        ]);
        $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id');
        $this->db->where('products.pro_destaque', 1);
        $this->db->where('products.pro_active' , 1);
        $this->db->limit(2);
        $this->db->group_by('products.pro_id');
        $this->db->order_by('products.pro_id', 'RANDOM');
        return $this->db->get('products')->result();
    }
    public function get_produtos_mais_vendidos(){
        $this->db->select([
            'products.pro_name',
            'products.pro_value',
            'products.pro_note_id',
            'products.pro_meta_link',
            'products_photos.photo_path',
            'requests_products.*',
            'SUM(notes.note)/COUNT(products.pro_id) as nota'
        ]);
        $this->db->join('notes','notes.note_product_id = products.pro_id', 'LEFT');
        $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id');
        $this->db->join('requests_products','requests_products.product_id = products.pro_id');
        $this->db->where('products.pro_destaque', 1);
        $this->db->where('products.pro_active' , 1);
        $this->db->order_by('products.pro_id', 'RANDOM');
        $this->db->group_by('products.pro_id');
        return $this->db->get('products')->result();
    }
    public function get_produtos_categoria(){
        $this->db->select([            
            'products.pro_name',
            'products.pro_value',
            'products.pro_meta_link',
            'products_photos.photo_path',
            'products.pro_note_id',
            'masters.master_name',
            'masters.master_meta_link',
            'categories.categorie_name',
            'SUM(notes.note)/COUNT(products.pro_id) as nota'
        ]);
       
        $this->db->where('masters.master_id', 4);        
        $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id');
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id', 'LEFT');
        $this->db->join('notes','notes.note_product_id = products.pro_id', 'LEFT');
        $this->db->join('masters', 'masters.master_id = categories.master_id');
        $this->db->where('products.pro_active' , 1);        
        $this->db->order_by('products.pro_id', 'RANDON');
        $this->db->group_by('categories.categorie_id');
        return $this->db->get('products')->result();
    }
    public function get_avaliacoes($condicoes = NULL){
        $this->db->select([
            'notes.*',   
            'products.pro_id',
            'CONCAT(clients.client_name, " ", clients.client_surname) as avaliacao_cliente_nome',
        ]);      
        if($condicoes && is_array($condicoes)){
            $this->db->where($condicoes);
        }
        $this->db->join('clients', 'clients.client_id = notes.note_client_id');
        $this->db->join('products','notes.note_product_id = products.pro_id');
        $this->db->where('notes.note_product_id = products.pro_id');
        //$this->db->limit(3);
        $this->db->order_by('notes.note_id', 'DESC');
        return $this->db->get('notes')->result();
    }
    public function media_avaliacoes(){
        $this->db->select([
            'notes.note',
            'products.pro_note_id',
            'products.pro_id',
            'SUM(notes.note)/COUNT(products.pro_id) as nota'
        ]);
        $this->db->join('products','notes.note_product_id = products.pro_id');
        //$this->db->update('produtos', 'produtos.produto_avaliacao_id = ', $media);
        $this->db->order_by('nota', 'DESC');
        return $this->db->get('notes')->result();
    }
}