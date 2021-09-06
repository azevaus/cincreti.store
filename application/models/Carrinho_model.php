<?php
defined('BASEPATH') OR exit('Ação não permitida');

class Carrinho_model extends CI_Model{
    public function get_by_id($pro_id = null){
        if($pro_id){
            $this->db->select([
                'products.pro_id',
                'products.pro_name',                
                'products.pro_value',
                'products.pro_meta_link',
                'products.pro_qtd_stock',
                'products.pro_description',
                'content_package',
                'pro_model',
                'pro_peso',
                'pro_largura',
                'pro_altura',
                'pro_comprimento',
                'products_photos.photo_path',
            ]);
            $this->db->where('products.pro_id', $pro_id);
            $this->db->where('products.pro_active', 1);
            $this->db->limit(1);
            $this->db->join('products_photos', 'products_photos.photo_pro_id = products.pro_id', 'LEFT');
            return $this->db->get('products')->row();
        }
    }
    public function get_id($pro_id = NULL){//resolver depois
        $this->db->select([
            'products.pro_id',
            'products.pro_code',
            'products.pro_name',
            'products.pro_categ_id',
            'products.pro_brand_id',
            'products.pro_value',
            'products.pro_meta_link',
            'products.pro_qtd_stock',
            'products.pro_active',
            'products.pro_destaque',
            'products.pro_control_stock',
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
}