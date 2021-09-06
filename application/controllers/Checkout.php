<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Checkout extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //recuperando as configs do pagseguro
        $config_pagseguro = $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1));
        //carrega a api do pagseguro de acordo com o banco
        if($config_pagseguro->config_ambiente == 1){
            $api_javascript = 'sandbox_pagseguro.directpayment.js';
        }else{
            $api_javascript = 'produtivo_pagseguro.directpayment.js';
        }
        $data = array(
            'titulo' => 'Finalizar compra',
            'scripts' => array(
                'mask/jquery.mask.min.js',
                'mask/custom.js',
                'js/'.$api_javascript,
                'js/checkout.js', 
            ),
        );
        $carrinho = array(
            'carrinho'=> $this->carrinho_compras->get_all(),
        );
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/checkout', $carrinho);
        $this->load->view('web/layout/footer');
    }
    public function calcula_frete(){
        $this->form_validation->set_rules('client_state', 'CEP de destino', 'trim|required|exact_length[9]');
        if($this->form_validation->run()){
            //sucesso
            $cep_destino = str_replace('-','', $this->input->post('client_state'));
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
            $cep_destino  = $this->input->post('client_state');
            $url_correios = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';
            $url_correios .= 'nCdEmpresa=08082650';
            $url_correios .= '&sDsSenha=564321';
            $url_correios .= '&sCepOrigem='. str_replace('-','',$config_correios->config_cep_origem);
            $url_correios .= '&sCepDestino='. $cep_destino;
            $url_correios .= '&nVlPeso='.$total_pesos;
            $url_correios .= '&nCdFormato=1';
            $url_correios .= '&nVlComprimento='.$produto['pro_comprimento'];
            $url_correios .= '&nVlAltura='.$produto['pro_altura'];
            $url_correios .= '&nVlLargura=' .$produto['pro_largura'];
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
                    $message_frete .= '<div class="custom-control custom-radio">
                    <input type="radio" class="input" id="'.$dados->Codigo.'" name="opcao_frete_carrinho" value="'.$valor_calculado.'|'.$dados->Codigo.'" data-valor-frete="'.$valor_calculado.'" data-valor-final-carrinho="'.number_format($valor_final_carrinho, 2).'">
                    <label class="custoom-control-label" for="'.$dados->Codigo.'">'.($dados->Codigo == '04510' ? 'PAC:' : 'SEDEX:').'&nbsp;R$&nbsp;'.$valor_calculado.''.'&nbsp;|&nbsp; Apartir de <span> '.$dados->PrazoEntrega.'</span> dias uteis.'.'</label>
                    </div>';
                }
                $retorno['endereco'] = $resultado->logradouro;
                $retorno['bairro'] = $resultado->bairro;
                $retorno['cidade'] = $resultado->localidade;
            }
            $retorno['erro'] = 0;
            $retorno['retorno_endereco'] = $retorno_endereco. '<br><br>' .$message_frete;           
        }else{
            //erro de validacao
            $retorno['erro'] = 5;
            $retorno['retorno_endereco'] = validation_errors();
        }
        echo json_encode($retorno);
    }
}