<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Favorite extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $data = array(
        'titulo' => 'Meus favoritos',
            'scripts' => array(
                'mask/jquery.mask.min.js',
                'mask/custom.js',
                'js/carrinho.js', 
            ),
        );
        $favoritos = array(
            'favoritos'=> $this->favoritos_compras->get_all(),
        );
        echo '<pre>';
        print_r($favoritos);
        exit();
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/favorite', $favoritos);
        $this->load->view('web/layout/footer');
    }
    public function insert(){
        $produto_id = (int)$this->input->post('produto_id');
        $produto_quantidade = (int)$this->input->post('produto_quantidade');
        $retorno = array();
        if(!$produto_id || $produto_quantidade == 1){
            $retorno['erro'] = 3;
            $retorno['mensagem'] = 'Informe a quantidade';
        }else{
            if(!$produto = $this->core_model->get_by_id('produtos', array('produto_id' => $produto_id))){
                $retorno['erro'] = 3;
                $retorno['mensagem'] = 'Produto nao encontrado';
            }else{
                //comparando com a quantidade em estoque
                if($produto_quantidade > $produto->produto_quantidade_estoque){
                    $retorno['erro'] = 3;
                    $retorno['mensagem'] = 'Infelizmente só temos '.$produto->produto_quantidade_estoque. ' em estoque.';
                }else{
                    //estoque disponivel
                    $this->favoritos_compras->insert($produto_id, $produto_quantidade);
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = '<i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Adicionado com sucesso';
                }
            }
        }
        echo json_encode($retorno);
    }
}