<?php
defined('BASEPATH') OR exit('Ação não permitida.');

class Welcome extends CI_Controller {
	public function __construct(){
		parent::__construct();
		
	}	
	public function index() {
		$sistema = info_header_footer();
		$data = array(
			'scripts' => array(
				'mask/jquery.mask.min.js',
				'mask/custom.js', 
				'js/add_produto.js',                    
			),
			'titulo' => 'Seja bem vindo(a) à '.$sistema->sistema_nome_fantasia,
			'produtos_destaques' => $this->store_model->get_pro_destaque($sistema->sistema_produtos_destaques),
			'produto_categoria_id' => $this->core_model->get_by_id('categories', array('categorie_id' => 1)),
			'produto_lateral_direita' => $this->store_model->get_pro_lateral(),
			'produtos_mais_vendidos' => $this->store_model->get_produtos_mais_vendidos(),
			'produtos_categoria' => $this->store_model->get_produtos_categoria(),
			'avaliacoes' => $this->store_model->media_avaliacoes(),
		);
		$favoritos = array(
            'favoritos'=> $this->favoritos_compras->get_all(),
        );		
		$this->load->view('web/layout/header', $data);
		$this->load->view('web/store', $favoritos);
		$this->load->view('web/layout/footer');
	}
	public function insert(){
        $produto_id = (int)$this->input->post('produto_id');
        $produto_quantidade = (int)$this->input->post('produto_quantidade');
        $retorno = array();
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
                    $this->carrinho_compras->insert($produto_id, $produto_quantidade);
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = '<i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Adicionado com sucesso';
                }
            }
        
        echo json_encode($retorno);
    }
}