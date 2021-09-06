<?php
defined('BASEPATH') OR exit('Ação não permitida.');

class Cart extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $data = array(
        'titulo' => 'Carrinho de compra',
            'scripts' => array(
                'mask/jquery.mask.min.js',
                'mask/custom.js',
                'js/carrinho.js', 
            ),
        );
        $carrinho = array(
            'carrinho'=> $this->carrinho_compras->get_all(),
        );
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/cart', $carrinho);
        $this->load->view('web/layout/footer');
    }
    public function insert(){
        $produto_id = (int)$this->input->post('produto_id');
        $produto_quantidade = (int)$this->input->post('produto_quantidade');
        $retorno = array();
        if(!$produto_id || $produto_quantidade < 1){
            $retorno['erro'] = 3;
            $retorno['mensagem'] = 'Informe a quantidade';
        }else{
            if(!$produto = $this->core_model->get_by_id('products', array('pro_id' => $produto_id))){
                $retorno['erro'] = 3;
                $retorno['mensagem'] = 'Produto nao encontrado';
            }else{
                //comparando com a quantidade em estoque
                if($produto_quantidade > $produto->pro_qtd_stock){
                    $retorno['erro'] = 3;
                    $retorno['mensagem'] = 'Infelizmente só temos '.$produto->pro_qtd_stock. ' em estoque.';
                }else{
                    //estoque disponivel
                    $this->carrinho_compras->insert($produto_id, $produto_quantidade);
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = '<i class="fa fa-check-square" aria-hidden="true"></i>&nbsp;Adicionado com sucesso';
                }
            }
        }
        echo json_encode($retorno);
    }
    public function delete(){
        $retorno = array();
        if($produto_id = (int)$this->input->post('produto_id')){
            $this->carrinho_compras->delete($produto_id);
            $retorno['erro'] = 0;
            $retorno['mensagem'] = 'Produto excluido com sucesso';
        }
        echo json_encode($retorno);
    }
    public function update(){
        $produto_id = (int)$this->input->post('produto_id');
        $produto_quantidade = (int)$this->input->post('produto_quantidade');
        $retorno = array();
        if($produto_quantidade == "" || $produto_quantidade < 1){
            $retorno['erro'] = 3;
            $retorno['mensagem'] = 'Informe a quantidade maior que zero.';
        }else{
            //valida se o produto existe
            if(!$produto = $this->core_model->get_by_id('products', array('pro_id' => $produto_id))){
                $retorno['erro'] = 3;
                $retorno['mensagem'] = 'Produto nao encontrado.';
            }else{
                //verifica se tem em estoque
                if($produto_quantidade > $produto->pro_qtd_stock){
                    $retorno['erro'] = 3;
                    $retorno['mensagem'] = 'Infelizmente só temos '.$produto->pro_qtd_stock. ' unidade(s) em estoque.';
                }else{
                    //atualiza a quantidade no carinho
                    $this->carrinho_compras->update($produto_id, $produto_quantidade);
                    $retorno['erro'] = 0;
                }
            }   
        }
        echo json_encode($retorno);
    }
    public function clean(){
        $retorno = array();
        if($this->input->post('clean') && $this->input->post('clean') == true) {
            $this->carrinho_compras->clean();
            $retorno['erro'] = 0;
            $retorno['mensagem'] = 'O carrinho está vazio';
        }
        echo json_encode($retorno);
    }
    public function calcula_frete(){
        $this->form_validation->set_rules('cep', 'CEP de destino', 'trim|required|exact_length[9]');
        if($this->form_validation->run()){
            //sucesso
            $cep_destino = str_replace('-','', $this->input->post('cep'));
            $retorno = array();
            $url_endereco ='https://viacep.com.br/ws/';
            $url_endereco .= $cep_destino;
            $url_endereco .= '/json/';            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_URL, $url_endereco);
            $resultado = curl_exec($curl);
            $resultado = json_decode($resultado);
            if(isset($resultado->erro)){
                $retorno['erro'] = 3;
                $retorno['message'] = '<span>Nao encontramos o CEP em nossa base de dados</span>';
            }else{
                $retorno['erro'] = 0;
                $retorno['message'] = 'Sucesso';
                $retorno_endereco = $retorno['retorno_endereco'] = '<br><br><span>Cidade: '.$resultado->localidade.', Estado: '.$resultado->uf. ', CEP: '.$resultado->cep. '</span>';
            }
            //consultar api dos correiros
            $config_correios = $this->core_model->get_by_id('config_correios' , array('config_id' => 1));
            $produto = $this->carrinho_compras->get_produto_maior_dimensao();
            $total_pesos = $this->carrinho_compras->get_total_pesos();
            $cep_destino  = $this->input->post('cep');
            $url_correios = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';
            $url_correios .= 'nCdEmpresa=08082650';
            $url_correios .= '&sDsSenha=564321';
            $url_correios .= '&sCepOrigem='. str_replace('-','',$config_correios->config_cep_origem);
            $url_correios .= '&sCepDestino='. $cep_destino;
            $url_correios .= '&nVlPeso='.$total_pesos;
            $url_correios .= '&nCdFormato=1';
            $url_correios .= '&nVlComprimento='.$produto['produto_comprimento'];
            $url_correios .= '&nVlAltura='.$produto['produto_altura'];
            $url_correios .= '&nVlLargura=' .$produto['produto_largura'];
            $url_correios .= '&sCdMaoPropria=n';
            $url_correios .= '&nVlValorDeclarado='.$config_correios->config_valor_declarado;
            $url_correios .= '&sCdAvisoRecebimento=n';
            $url_correios .= '&nCdServico='. $config_correios->config_codigo_pac;
            $url_correios .= '&nCdServico='. $config_correios->config_codigo_sedex;
            $url_correios .= '&nVlDiametro=0';
            $url_correios .= '&StrRetorno=xml';
            $url_correios .= '&nIndicaCalculo=3';
            //echo json_encode($url_correios);
            //exit();
            $xml = simplexml_load_file($url_correios);
            $xml = json_encode($xml);
            $consulta = json_decode($xml);
            if($consulta->cServico[0]->Valor == '0,00'){
                $retorno['erro'] = 3;
                $retorno['message'] = '<span>Nao foi possivel calcular o frete, por favor entre em contato com nosso suporte</span>';
            }else{
                //recuperando o valor total dos produtos para somar ao valor_calculado
                $valor_total_produtos = str_replace(',','', $this->carrinho_compras->get_total());
                $message_frete = "";
                foreach($consulta->cServico as $dados){
                    $valor_formatado = str_replace(',','.',$dados->Valor);
                    number_format($valor_calculado = ($valor_formatado + $config_correios->config_somar_frete), 2, '.', '');
                    $valor_final_carrinho = $valor_total_produtos + $valor_calculado;
                    $message_frete  .= '<div class="custom-control custom-radio">
                    <input type="radio" class="input" id="'.$dados->Codigo.'" name="opcao_frete_carrinho" value="'.$valor_calculado.'" data-valor-frete="'.$valor_calculado.'" data-valor-final-carrinho="'.number_format($valor_final_carrinho, 2).'">
                    <label class="custoom-control-label" for="'.$dados->Codigo.'">'.($dados->Codigo == '04510' ? 'PAC:' : 'SEDEX:').'&nbsp;R$&nbsp;'.$valor_calculado.''.'&nbsp;|&nbsp; Apartir de <span> '.$dados->PrazoEntrega.'</span> dias uteis.'.'</label>
                    </div>';
                }
                $retorno['erro'] = 0;
                $retorno['retorno_endereco'] = $retorno_endereco. '<br><br>' .$message_frete;
            }
            

        }else{
            //erro de validacao
            $retorno['erro'] = 5;
            $retorno['retorno_endereco'] = validation_errors();
        }
        echo json_encode($retorno);
    }
}