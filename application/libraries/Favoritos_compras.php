<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Favoritos_compras{
    public function __construct(){
        if(!isset($_SESSION['favoritos'])){
            $_SESSION['favoritos'] = [];
        }
    }
    public function insert($produto_id = NULL, $produto_quantidade = NULL){
        if($produto_id && $produto_quantidade){
            if(isset($_SESSION['favoritos'][$produto_id])){
                $_SESSION['favoritos'][$produto_id] += $produto_quantidade;
            }else{
                $_SESSION['favoritos'][$produto_id] = $produto_quantidade;
            }
        }
    }
    //lista todos os itens do carrinho
    public function get_all(){
        $CI = get_instance();
        $CI->load->model('carrinho_model');
        $retorno = array();
        $indice = 0;
        foreach($_SESSION['favoritos'] as $produto_id => $produto_quantidade){
            $query = $CI->carrinho_model->get_by_id($produto_id);
            $retorno[$indice]['produto_id'] = $query->produto_id;
            $retorno[$indice]['produto_nome'] = $query->produto_nome;
            $retorno[$indice]['produto_valor'] = $query->produto_valor;
            $retorno[$indice]['produto_quantidade'] = $produto_quantidade;
            $retorno[$indice]['subtotal'] = number_format($produto_quantidade * $query->produto_valor, 2, '.', '');
            $retorno[$indice]['produto_peso'] = $query->produto_peso;
            $retorno[$indice]['produto_altura'] = $query->produto_altura;
            $retorno[$indice]['produto_largura'] = $query->produto_largura;
            $retorno[$indice]['produto_comprimento'] = $query->produto_comprimento;
            $retorno[$indice]['produto_foto'] = $query->foto_caminho;
            $retorno[$indice]['produto_meta_link'] = $query->produto_meta_link;
            $indice++;
        }
        return $retorno;
    }
    //Qtd de itens no carrinho
    public function get_total_itens(){
        $total_itens = count($this->get_all());
        return $total_itens;
    }
}