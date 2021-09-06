<?php
defined('BASEPATH') OR exit('Acao nao permitida');
class Produtos_model extends CI_Model{
    public function get_all(){ //corrigido
        $this->db->select([
            'products.*',   
            'brands.brand_id',
            'brands.brand_name',
            'categories.categorie_id',
            'categories.categorie_name',     
        ]);
        $this->db->join('brands', 'brands.brand_id = products.pro_brand_id');
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id');
        return $this->db->get('products')->result();
    }
    public function get_by_id($pro_id = NULL){//resolver depois
        $this->db->select([
            'products.pro_id',            
            'masters.master_id',
            'masters.master_name',
            'masters.master_meta_link',
            'categories.categorie_id',
            'categories.categorie_name',
            'categories.categorie_meta_link',
            'brands.brand_id',
            'brands.brand_name',
            'brands.brand_meta_link',
        ]);
        $this->db->where('products.pro_id', $pro_id);
        $this->db->join('brands','brands.brand_id = products.pro_brand_id');
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id');
        $this->db->join('masters', 'masters.master_id = categories.master_id');
        return $this->db->get('products')->row();
    }
    public function get_pro($pro_id = NULL){//corrigido
        $this->db->select([
            'products.pro_id',
            'products.pro_code',
            'products.pro_categ_id',
            'products.pro_name',            
            'products.pro_active',
            'products.pro_destaque',
            'products.pro_control_stock',
            'products.pro_brand_id',
            'products.pro_value',
            'products.pro_peso',
            'products.pro_altura',
            'products.pro_largura',
            'products.pro_comprimento',
            'products.pro_meta_link',
            'products.pro_qtd_stock',
            'products.pro_description',
            'masters.master_id',
            'masters.master_name',
            'masters.master_meta_link',
            'categories.categorie_id',
            'categories.categorie_name',
            'categories.categorie_meta_link',
            'brands.brand_id',
            'brands.brand_name',
            'brands.brand_meta_link',
        ]);
        $this->db->where('products.pro_id', $pro_id);
        $this->db->join('brands','brands.brand_id = products.pro_brand_id');
        
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id');
        $this->db->join('masters', 'masters.master_id = categories.master_id');
        return $this->db->get('products')->row();
    }
    public function get_all_by($condicoes = NULL){
        $this->db->select([
            'products.pro_name',
            'products.pro_value',
            'products.pro_meta_link',
            'masters.master_name',
            'masters.master_meta_link',
            'categories.categorie_name',
            'products_photos.photo_path',
            'products.pro_note_id',
            'SUM(notes.note)/COUNT(products.pro_id) as nota'
        ]);
        $this->db->where('products.pro_active', 1);
        if($condicoes && is_array($condicoes)){
            $this->db->where($condicoes);
        }
        $this->db->join('notes','notes.note_product_id = products.pro_id', 'LEFT');
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id', 'LEFT');
        $this->db->join('brands','brands.brand_id = products.pro_brand_id', 'LEFT');        
        $this->db->join('masters', 'masters.master_id = categories.master_id');
        $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id' , 'LEFT');
        $this->db->group_by('products.pro_id');
        return $this->db->get('products')->result();
    }
    public function get_all_by_busca($busca = NULL){
        if($busca){
            $this->db->select([
                'products.pro_name',
                'products.pro_value',
                'products.pro_meta_link',
                'masters.master_name',
                'categories.categorie_name',
                'products_photos.photo_path'
            ]);
            $this->db->where('pro_active', 1);
            $this->db->like('products.pro_name', $busca, 'BOTH');
            $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id', 'LEFT');
            $this->db->join('brands','brands.brand_id = products.pro_brand_id', 'LEFT');        
            $this->db->join('masters', 'masters.master_id = categories.master_id', 'LEFT');
            $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id' , 'LEFT');
            $this->db->group_by('products.pro_id');
            return $this->db->get('products')->result();
        }else{
            return false;
        }
    }   
    public function get_by_product($condicoes = NULL){
        $this->db->select([
            'products.*',
            'masters.master_id',
            'masters.master_name',
            'masters.master_meta_link',
            'categories.categorie_id',
            'categories.categorie_name',
            'categories.categorie_meta_link',
            'brands.brand_id',
            'brands.brand_name',
            'brands.brand_meta_link',
        ]);
        $this->db->where('products.pro_meta_link', $condicoes);
        $this->db->join('brands','brands.brand_id = products.pro_brand_id');
        $this->db->join('categories', 'categories.categorie_id = products.pro_categ_id');
        $this->db->join('masters', 'masters.master_id = categories.master_id');
        return $this->db->get('products')->row();
    }
}
