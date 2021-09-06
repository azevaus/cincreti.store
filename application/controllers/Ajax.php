<?php
defined('BASEPATH') OR exit('Ação não permitida.');
class Ajax extends CI_Controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        //validacaoes
        $this->form_validation->set_rules('cep', 'CEP destino', 'trim|required|exact_length[9]');
        $this->form_validation->set_rules('produto_id', 'Produto ID', 'trim|required');        
        $retorno = array();
        if($this->form_validation->run()){//se o form_validation rodar
            $produto_id  = (int)$this->input->post('produto_id');
            if(!$produto = $this->produtos_model->get_pro($produto_id)){
                $retorno['erro'] = 3;
                $retorno['retorno_endereco'] = 'Nao encontramos o produto em nossa base de dados';
                echo json_encode($retorno);
                exit();
            }else{//existe
                //Inicio da consulta WebSevices VaiCep ---------------------------
                $cep_destino = str_replace('-','', $this->input->post('cep'));
                $url_endereco ='https://viacep.com.br/ws/';
                $url_endereco .= $cep_destino;
                $url_endereco .= '/json/';
                //preparando a consulta
                $curl = curl_init();//inicializando o CURL
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_URL, $url_endereco);
                $resultado = curl_exec($curl);//executa o CURL
                $resultado = json_decode($resultado);
                if(isset($resultado->erro)){
                    $retorno['erro'] = 3;
                    $retorno['mensagem'] = 'Nao encontramos o CEP em nossa base de dados';
                }else{
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = 'Sucesso';
                    $retorno_endereco = $retorno['retorno_endereco'] = '<span>Cidade: '.$resultado->localidade.', Estado: '.$resultado->uf. ', CEP: '.$resultado->cep. '</span>';
                }
                //Fim da consulta ao ViaCep -------------------------------------

                //Inicio da consulta ao WebServices dos Correios ----------------                
                //Montando URL dos Correios
                $config_correios = $this->core_model->get_by_id('config_correios' , array('config_id' => 1));
                $cep_destino  = $this->input->post('cep');
                $url_correios = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?';
                $url_correios .= 'nCdEmpresa=08082650';
                $url_correios .= '&sDsSenha=564321';
                $url_correios .= '&sCepOrigem='.str_replace('-','',$config_correios->config_cep_origem);
                $url_correios .= '&sCepDestino='.str_replace('-','',$cep_destino);
                $url_correios .= '&nVlPeso='.str_replace('.', '',$produto->pro_peso);
                $url_correios .= '&nCdFormato=1';
                $url_correios .= '&nVlComprimento='.str_replace('.','', $produto->pro_comprimento);
                $url_correios .= '&nVlAltura='. str_replace('.','',$produto->pro_altura);
                $url_correios .= '&nVlLargura=' .str_replace('.','',$produto->pro_largura);
                $url_correios .= '&sCdMaoPropria=n';
                $url_correios .= '&nVlValorDeclarado='.$config_correios->config_valor_declarado;
                $url_correios .= '&sCdAvisoRecebimento=n';
                $url_correios .= '&nCdServico='. $config_correios->config_codigo_pac;
                $url_correios .= '&nCdServico='. $config_correios->config_codigo_sedex;
                $url_correios .= '&nVlDiametro=0';
                $url_correios .= '&StrRetorno=xml';
                $url_correios .= '&nIndicaCalculo=3';
                //fim da montagem da URL dos correios
                
                $xml = simplexml_load_file($url_correios);
                $xml = json_encode($xml);
                $consulta = json_decode($xml);
                if($consulta->cServico[0]->Valor == '0,00'){ //garantindo que houve sucesso na cosnulta ao web services do Correios
                    $retorno['erro'] = 3;
                    $retorno['retorno_endereco'] = 'Nao foi possivel calcular o frete, por favor entre em contato com o nosso suporte';
                    exit();
                }else{
                    $message_frete = "";
                    foreach($consulta->cServico as $dados){
                        $valor_formatado = str_replace(',','.',$dados->Valor);
                        number_format($valor_calculado = ($valor_formatado + $config_correios->config_somar_frete), 2, '.', '');
                        $message_frete .= '<p class="text-info">'.($dados->Codigo == '04510' ? 'PAC: ' : 'SEDEX: ').'&nbsp;R$&nbsp;'.$valor_calculado.', '.$dados->PrazoEntrega.' dias uteis.</p>';
                    }
                    $retorno['erro'] = 0;
                    $retorno['retorno_endereco'] = $retorno_endereco.'&nbsp;'.$message_frete;
                }
                
            }          
        }else{//se nao validar
            $retorno['erro'] = 5;
            $retorno['retorno_endereco'] = validation_errors();
        }
        echo json_encode($retorno);
    }
}
