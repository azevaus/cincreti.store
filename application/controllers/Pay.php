<?php 
defined('BASEPATH') OR exit('Acao nao permitida');
class Pay extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
    }
    public function index(){
        redirect('/');
    }
    public function pagseguro_session_id(){
        if(!$this->input->is_ajax_request()){
            exit('Açao nao permitida');
        }
        $config_pagseguro = $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1));//config do pagseguro
        if($config_pagseguro->config_ambiente == 1){
            $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions"; //SandBox - Testes
        }else{
            $url = "https://ws.pagseguro.uol.com.br/v2/sessions"; // Produtivo - Real
        }
        //definindo os parametros necessarios para a URL acima
        $parametros = array(
            'email' => $config_pagseguro->config_email,
            'token' => $config_pagseguro->config_token,
        );
        //iniciando a configuracao para requisitar dados a api do pagseguro ------------
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //fazendo um count para informar ao curl quantos parametros serao enviados via post
        curl_setopt($ch, CURLOPT_POST, count($parametros));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parametros));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //INFORMANDO QUAL É O AGENTE QUE ESTA REQUISITANDO A API DO PAGSEGURO
        curl_setopt($ch, CURLOPT_USERAGENT, $this->agent->agent_string());
        if($config_pagseguro->config_ambiente == 1){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); //NAO É OBRIGÁTORIO SSL EM SANDBOX
        }else{
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($result);
        $json = json_encode($xml);
        $session = json_decode($json, true);
        $retorno = array();
        if($session['id']){//verifica se foi gerada uma sessao junto ao pagseguro
            $retorno['erro'] = 0;
            $retorno['session_id'] = $session['id'];
        }else{//nao foi gerada a sessao junto ao pagseguro
            $retorno['erro'] = 3;
            $retorno['mensagem'] = 'Nao foi gerada uma sessao. Tente novamente mais tarde.';
        }
        header('Content-Type: application/json');
        echo json_encode($retorno);
    }
    //processar pagamento vai boleto
    public function boleto(){
        if(!$this->input->is_ajax_request()){
            exit('Açao nao permitida');
        }
        $cliente_logado = $this->ion_auth->logged_in();
        if(!$cliente_logado){
            $this->form_validation->set_rules('cliente_nome', 'nome', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_sobrenome', 'sobrenome', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_data_nascimento', 'data de nascimento', 'trim|required');
            $this->form_validation->set_rules('cliente_cpf', 'CPF', 'trim|required|exact_length[14]|callback_valida_cpf');
            $this->form_validation->set_rules('cliente_email', 'e-mail', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');               
            $this->form_validation->set_rules('cliente_telefone_movel', 'celular', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
            $this->form_validation->set_rules('cliente_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('cliente_endereco', 'endereço', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_numero_endereco', 'numero', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('cliente_bairro', 'bairro', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_cidade', 'cidade', 'trim|required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('cliente_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('cliente_senha', 'senha', 'trim|required|min_length[6]|max_length[200]');
            $this->form_validation->set_rules('confirmacao', ' confirmaçao de senha', 'trim|matches[cliente_senha]');
            $this->form_validation->set_rules('opcao_frete_carrinho', ' opcao do frete', 'trim|required');
            $retorno = array();
            if($this->form_validation->run()){
                $data = elements(
                    array(
                        'cliente_nome',
                        'cliente_sobrenome',
                        'cliente_data_nascimento',
                        'cliente_cpf',
                        'cliente_email',
                        'cliente_telefone_fixo',
                        'cliente_telefone_movel',
                        'cliente_cep',
                        'cliente_endereco',
                        'cliente_numero_endereco',
                        'cliente_bairro',
                        'cliente_cidade',
                        'cliente_estado',
                    ), $this->input->post()
                );
                $data = html_escape($data);
                $this->core_model->insert('clientes', $data, TRUE);
                $cliente_user_id = $this->session->userdata('last_id');//recuperando o ultimo id inserido
                //atualizacao da tabela de usuarios
                //Inserir um usuario na tablea de usuarios como um cliente
                $username = $this->input->post('cliente_nome');
                $password = $this->input->post('cliente_senha');
                $email = $this->input->post('cliente_email');
                $dados_usuario = array(
                    'cliente_user_id' => $cliente_user_id,
                    'first_name' => $this->input->post('cliente_nome'),
                    'last_name' => $this->input->post('cliente_sobrenome'),
                    'phone' => $this->input->post('cliente_telefone_movel'),
                    'active' => 1,
                );
                $group = array('2');//grupo de clientes
                if($this->ion_auth->register($username, $password, $email, $dados_usuario, $group)){
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = 'Usuario do cliente criado com sucesso';
                }else{
                    $retorno['erro'] = 5;
                    $retorno['mensagem'] = 'Nao foi possivel criar o usuario do cliente';
                }
                
            }else{
                //erros de validaçao
                $retorno['erro'] = 3;
                $retorno['cliente_nome'] = form_error('cliente_nome');
                $retorno['cliente_sobrenome'] = form_error('cliente_sobrenome');
                $retorno['cliente_data_nascimento'] = form_error('cliente_data_nascimento');
                $retorno['cliente_cpf'] = form_error('cliente_cpf');
                $retorno['cliente_email'] = form_error('cliente_email');
                $retorno['cliente_telefone_movel'] = form_error('cliente_telefone_movel');
                $retorno['cliente_cep'] = form_error('cliente_cep');
                $retorno['cliente_endereco'] = form_error('cliente_endereco');
                $retorno['cliente_numero_endereco'] = form_error('cliente_numero_endereco');
                $retorno['cliente_bairro'] = form_error('cliente_bairro');
                $retorno['cliente_cidade'] = form_error('cliente_cidade');
                $retorno['cliente_estado'] = form_error('cliente_estado');
                $retorno['cliente_senha'] = form_error('cliente_senha');
                $retorno['confirmacao'] = form_error('confirmacao');
                $retorno['opcao_frete_carrinho'] = form_error('opcao_frete_carrinho');
                echo json_encode($retorno);
                exit();
            }
        }
        if(!preg_match('/[0-9]{5}-[0-9]{3}/', $this->input->post('cliente_cep'))){
            $retorno['erro'] = 3;
            $retorno['cliente_cep'] = 'Informe um CEP válido';
            echo json_encode($retorno);
            exit();
        }   
        if(!$this->input->post('opcao_frete_carrinho')){
            $retorno['erro'] = 3;
            $retorno['opcao_frete_carrinho'] = 'Escolha uma opçao de frete';
            echo json_encode($retorno);
            exit();
        }
        if(!$cliente_logado){
            $cliente_user_id = $this->session->userdata('last_id');
        }else{
            $cliente_user_id = $this->session->userdata('cliente_user_id');
        }        
        if(!$cliente = $this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_user_id))){
            $retorno['erro'] = 6;
            $retorno['mensagem'] = 'Cliente nao localizado'; 
            echo json_encode($retorno);
            exit();
        }else{
            //foi confirmada a existencia do cliente            
            $hash_pagamento = $this->input->post('hash_pagamento'); //verifica se o hash_pagamento contem valor
            if(!$hash_pagamento){
                $retorno['erro'] = 6;
                $retorno['mensagem'] = 'Nao foi gerado o hash de pagamento'; 
                echo json_encode($retorno);
                exit();
            }else{
                //ser o hash foi gerado, sucesso
                //montar os dados do cliente(comprador) para a compra
                $cliente_id = $cliente->cliente_id;
                $nome_comprador = remove_acentos($cliente->cliente_nome .' '. $cliente->cliente_sobrenome);
                $cpf_comprador = str_replace('.', '', $cliente->cliente_cpf);
                $cpf_comprador = str_replace('-', '', $cpf_comprador);
                $email_comprador = $cliente->cliente_email;
                $telefone_comprador = $cliente->cliente_telefone_movel;
                //recuperando os dados de endereço do compradpr
                $cep_comprador = str_replace('-', '', $cliente->cliente_cep);
                $endereco_comprador = remove_acentos($cliente->cliente_endereco);
                $endereco_numero_comprador = $cliente->cliente_numero_endereco;
                $bairro_comprador = remove_acentos($cliente->cliente_bairro);
                $cidade_comprador = remove_acentos($cliente->cliente_cidade);
                $estado_comprador = $cliente->cliente_estado;
                //recuperando os dados do frete escolhido
                $opcao_frete_carrinho = explode('|', $this->input->post('opcao_frete_carrinho'));
                $opcao_frete_carrinho_valor = $opcao_frete_carrinho[0]; //recupero o valor do frete escolhido contindo na posicao [0]
                $opcao_frete_carrinho_servico = $opcao_frete_carrinho[1];//recupero a segunda posicao que é justamente o servico do frete escolhido
                //recuperando as config do pagseguro
                $config_pagseguro = $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1));
                //montando as credenciais de acesso
                $pagar_pedido['email'] = $config_pagseguro->config_email;
                $pagar_pedido['token'] = $config_pagseguro->config_token;
                //montando os dados do pedido
                $pagar_pedido['paymentMode'] = 'default';
                $pagar_pedido['paymentMethod'] = 'boleto';
                $pagar_pedido['receiverEmail'] = $config_pagseguro->config_email;
                $pagar_pedido['currency'] = 'BRL';
                $pagar_pedido['extraAmount'] = '';
                //Codigo do pedido gerado automaticamente
                $pedido_codigo = $this->core_model->generate_unique_code('pedidos', 'numeric', 8, 'pedido_codigo');
                $pagar_pedido['reference'] = $pedido_codigo;
                //montar os dados do comprador
                $pagar_pedido['senderName'] = $nome_comprador;
                $pagar_pedido['senderCPF'] = $cpf_comprador;
                $pagar_pedido['senderAreaCode'] = substr($telefone_comprador, 1, 2);
                $pagar_pedido['senderPhone'] = trim(str_replace('-', '', substr($telefone_comprador, 4, 15)));
                $pagar_pedido['senderEmail'] = ($config_pagseguro->config_ambiente == 1 ? 'c45275693740746179577@sandbox.pagseguro.com.br' : $email_comprador);
                $pagar_pedido['shippingAddressStreet'] = $endereco_comprador;
                $pagar_pedido['shippingAddressNumber'] = $endereco_numero_comprador;
                $pagar_pedido['shippingAddressDistrict'] = $bairro_comprador;
                $pagar_pedido['shippingAddressPostalCode'] = $cep_comprador;
                $pagar_pedido['shippingAddressCity'] = $cidade_comprador;
                $pagar_pedido['shippingAddressState'] = $estado_comprador;
                $pagar_pedido['shippingAddressCountry'] = 'BRA';
                //DADOS DO FRETE
                $pagar_pedido['shippingType'] = ($opcao_frete_carrinho_servico == '04510' ? 1 : 2);
                $pagar_pedido['shippingCost'] = number_format($opcao_frete_carrinho_valor, 2, '.', '');
                //itens do carrinho de compras(sessao)
                $carrinho = $this->carrinho_compras->get_all();
                $contador = 1;
                foreach($carrinho as $indice => $produto){
                    $pagar_pedido['itemId'.$contador] = $produto['produto_id'];
                    $pagar_pedido['itemDescription'.$contador] = word_limiter(remove_acentos($produto['produto_nome']), 5);
                    $pagar_pedido['itemAmount'.$contador] = number_format($produto['produto_valor'], 2, '.', ''); 
                    $pagar_pedido['itemQuantity'.$contador] = $produto['produto_quantidade']; 
                }
                //Dados da transacao
                $pagar_pedido['senderHash'] = $hash_pagamento;
                /*------------------------INICIO DO ENVIO DA REQUISICAO PARA PROCESSAR O PAGAMENTO-------------------------------------*/
                if($config_pagseguro->config_ambiente == 0){                    
                    $url = 'https://ws.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente real
                }else{
                    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente sandbox - teste
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($pagar_pedido));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pagar_pedido));
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, $this->agent->agent_string());
                if($config_pagseguro->config_ambiente == 0){
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE); //é obrigatoria a verificaçao do SSL
                }else{                    
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//Nao é obrigatoria a verificacao do SSL
                }
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result);
                $json = json_encode($xml);
                $transaction = json_decode($json);
                //verifica se houve algum erro na transacao, se existir excluimos o cliente
                if(isset($transaction->error->code)){
                    if(!$cliente_logado){
                        $this->core_model->delete('clientes', array('cliente_id' => $cliente_id));
                    }
                    $retorno['erro'] = $transaction->error->code;
                    $retorno['mensagem'] = 'Houve um erro na transaçao';
                    echo json_encode($retorno);
                    exit();
                }
                //garanntimos que houve sucesso
                if(isset($transaction->code)){
                    /*Iniciamos o store do pedido, dos produtos do pedido e da transacao no banco de dados */
                    $pedido = array(
                        'pedido_cliente_id' => $cliente->cliente_id,
                        'pedido_codigo' => $pedido_codigo,
                        'pedido_valor_produtos' => str_replace(',', '', $this->carrinho_compras->get_total()),
                        'pedido_valor_frete' => number_format($opcao_frete_carrinho_valor, 2, '.', ''),
                        'pedido_valor_final' => str_replace(',','', $this->carrinho_compras->get_total()) + $opcao_frete_carrinho_valor,
                        'pedido_forma_envio' => ($opcao_frete_carrinho_servico == '04510' ? 1 : 2),
                    ); 
                    //gravar o pedido na tabela pedidos
                    $this->core_model->insert('pedidos', $pedido, TRUE);
                    $pedido_id = $this->session->userdata('last_id');//ultimo id inserido
                    foreach($carrinho as $indice => $produto){
                        $pedido = array(
                            'pedido_id' => $pedido_id,
                            'produto_id' => $produto['produto_id'],
                            'produto_nome' => $produto['produto_nome'],
                            'produto_quantidade' => $produto['produto_quantidade'],
                            'produto_valor_unitario' => $produto['produto_valor'],
                            'produto_valor_total' => $produto['subtotal'],
                        );
                        $this->core_model->insert('pedidos_produtos', $pedido);
                    }
                    //montando o array com os dados da transacao 
                    $transacao = array(
                        'transacao_pedido_id' => $pedido_id,
                        'transacao_cliente_id' => $cliente->cliente_id,
                        'transacao_codigo_hash' => $transaction->code,
                        'transacao_tipo_metodo_pagamento' => $transaction->paymentMethod->type,
                        'transacao_codigo_metodo_pagamento' => $transaction->paymentMethod->code,
                        'transacao_link_pagamento' => $transaction->paymentLink,
                        'transacao_valor_bruto' => $transaction->grossAmount,
                        'transacao_valor_taxa_pagseguro' => $transaction->feeAmount,
                        'transacao_valor_liquido' => $transaction->netAmount,
                        'transacao_numero_parcelas' => $transaction->installmentCount,
                        'transacao_valor_parcela' => $transaction->grossAmount,
                        'transacao_status' => $transaction->status
                    );
                    $this->core_model->insert('transacoes', $transacao);
                    //salva no banco a transacao
                    
                    $retorno['erro'] = 0;
                    $retorno['code'] = $transaction->code;
                    $retorno['forma_pagamento'] = $this->input->post('forma_pagamento');
                    $retorno['mensagem'] = 'Seu pedido foi realizado com sucesso!';
                    $retorno['pedido_gerado'] = $pedido_codigo;
                    $retorno['transacao_link_pagamento'] = $transaction->paymentLink;
                    $retorno['cliente_nome_completo'] = $cliente->cliente_nome.' '.$cliente->cliente_sobrenome;
                    //gravar na sessao os dados do pedido para serem mostrado para o cliente
                    $this->session->set_userdata('pedido_realizado', $retorno);
                    //limpar carrinho de compras da sessao
                    $this->carrinho_compras->clean();                    
                }
                echo json_encode($retorno); //retorna os dados para o javascript
                 
            }
        }
    }
    //processar pagamento via débito em conta
    public function debito_conta(){
        if(!$this->input->is_ajax_request()){
            exit('Açao nao permitida');
        }
        $cliente_logado = $this->ion_auth->logged_in();
        if(!$cliente_logado){
            $this->form_validation->set_rules('cliente_nome', 'nome', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_sobrenome', 'sobrenome', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_data_nascimento', 'data de nascimento', 'trim|required');
            $this->form_validation->set_rules('cliente_cpf', 'CPF', 'trim|required|exact_length[14]|callback_valida_cpf');
            $this->form_validation->set_rules('cliente_email', 'e-mail', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');               
            $this->form_validation->set_rules('cliente_telefone_movel', 'celular', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
            $this->form_validation->set_rules('cliente_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('cliente_endereco', 'endereço', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_numero_endereco', 'numero', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('cliente_bairro', 'bairro', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_cidade', 'cidade', 'trim|required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('cliente_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('cliente_senha', 'senha', 'trim|required|min_length[6]|max_length[200]');
            $this->form_validation->set_rules('confirmacao', ' confirmaçao de senha', 'trim|matches[cliente_senha]');
            $this->form_validation->set_rules('opcao_frete_carrinho', ' opcao do frete', 'trim|required');
            $this->form_validation->set_rules('banco_escolhido', ' opcao de banco', 'trim|required');
            $retorno = array();
            if($this->form_validation->run()){
                $data = elements(
                    array(
                        'cliente_nome',
                        'cliente_sobrenome',
                        'cliente_data_nascimento',
                        'cliente_cpf',
                        'cliente_email',
                        'cliente_telefone_fixo',
                        'cliente_telefone_movel',
                        'cliente_cep',
                        'cliente_endereco',
                        'cliente_numero_endereco',
                        'cliente_bairro',
                        'cliente_cidade',
                        'cliente_estado',
                    ), $this->input->post()
                );
                $data = html_escape($data);
                $this->core_model->insert('clientes', $data, TRUE);
                $cliente_user_id = $this->session->userdata('last_id');//recuperando o ultimo id inserido
                //atualizacao da tabela de usuarios
                //Inserir um usuario na tablea de usuarios como um cliente
                $username = $this->input->post('cliente_nome');
                $password = $this->input->post('cliente_senha');
                $email = $this->input->post('cliente_email');
                $dados_usuario = array(
                    'cliente_user_id' => $cliente_user_id,
                    'first_name' => $this->input->post('cliente_nome'),
                    'last_name' => $this->input->post('cliente_sobrenome'),
                    'phone' => $this->input->post('cliente_telefone_movel'),
                    'active' => 1,
                );
                $group = array('2');//grupo de clientes
                if($this->ion_auth->register($username, $password, $email, $dados_usuario, $group)){
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = 'Usuario do cliente criado com sucesso';
                }else{
                    $retorno['erro'] = 5;
                    $retorno['mensagem'] = 'Nao foi possivel criar o usuario do cliente';
                }
                
            }else{
                //erros de validaçao
                $retorno['erro'] = 3;
                $retorno['cliente_nome'] = form_error('cliente_nome');
                $retorno['cliente_sobrenome'] = form_error('cliente_sobrenome');
                $retorno['cliente_data_nascimento'] = form_error('cliente_data_nascimento');
                $retorno['cliente_cpf'] = form_error('cliente_cpf');
                $retorno['cliente_email'] = form_error('cliente_email');
                $retorno['cliente_telefone_movel'] = form_error('cliente_telefone_movel');
                $retorno['cliente_cep'] = form_error('cliente_cep');
                $retorno['cliente_endereco'] = form_error('cliente_endereco');
                $retorno['cliente_numero_endereco'] = form_error('cliente_numero_endereco');
                $retorno['cliente_bairro'] = form_error('cliente_bairro');
                $retorno['cliente_cidade'] = form_error('cliente_cidade');
                $retorno['cliente_estado'] = form_error('cliente_estado');
                $retorno['cliente_senha'] = form_error('cliente_senha');
                $retorno['confirmacao'] = form_error('confirmacao');
                $retorno['opcao_banco'] = form_error('banco_escolhido');
                echo json_encode($retorno);
                exit();
            }
        }
        if(!preg_match('/[0-9]{5}-[0-9]{3}/', $this->input->post('cliente_cep'))){
            $retorno['erro'] = 3;
            $retorno['cliente_cep'] = 'Informe um CEP válido';
            echo json_encode($retorno);
            exit();
        }   
        if(!$this->input->post('opcao_frete_carrinho')){
            $retorno['erro'] = 3;
            $retorno['opcao_frete_carrinho'] = 'Escolha uma opçao de frete';
            echo json_encode($retorno);
            exit();
        }
        if(!$this->input->post('banco_escolhido')){
            $retorno['erro'] = 3;
            $retorno['opcao_banco'] = 'Escolha um banco';
            echo json_encode($retorno);
            exit();
        }
        if(!$cliente_logado){
            $cliente_user_id = $this->session->userdata('last_id');
        }else{
            $cliente_user_id = $this->session->userdata('cliente_user_id');
        }        
        if(!$cliente = $this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_user_id))){
            $retorno['erro'] = 6;
            $retorno['mensagem'] = 'Cliente nao localizado'; 
            echo json_encode($retorno);
            exit();
        }else{
            //foi confirmada a existencia do cliente            
            $hash_pagamento = $this->input->post('hash_pagamento'); //verifica se o hash_pagamento contem valor
            if(!$hash_pagamento){
                $retorno['erro'] = 6;
                $retorno['mensagem'] = 'Nao foi gerado o hash de pagamento'; 
                echo json_encode($retorno);
                exit();
            }else{
                //ser o hash foi gerado, sucesso
                //montar os dados do cliente(comprador) para a compra
                $cliente_id = $cliente->cliente_id;
                $nome_comprador = remove_acentos($cliente->cliente_nome .' '. $cliente->cliente_sobrenome);
                $cpf_comprador = str_replace('.', '', $cliente->cliente_cpf);
                $cpf_comprador = str_replace('-', '', $cpf_comprador);
                $email_comprador = $cliente->cliente_email;
                $telefone_comprador = $cliente->cliente_telefone_movel;
                //recuperando os dados de endereço do compradpr
                $cep_comprador = str_replace('-', '', $cliente->cliente_cep);
                $endereco_comprador = remove_acentos($cliente->cliente_endereco);
                $endereco_numero_comprador = $cliente->cliente_numero_endereco;
                $bairro_comprador = remove_acentos($cliente->cliente_bairro);
                $cidade_comprador = remove_acentos($cliente->cliente_cidade);
                $estado_comprador = $cliente->cliente_estado;
                //recuperando os dados do frete escolhido
                $opcao_frete_carrinho = explode('|', $this->input->post('opcao_frete_carrinho'));
                $opcao_frete_carrinho_valor = $opcao_frete_carrinho[0]; //recupero o valor do frete escolhido contindo na posicao [0]
                $opcao_frete_carrinho_servico = $opcao_frete_carrinho[1];//recupero a segunda posicao que é justamente o servico do frete escolhido
                //recuperando as config do pagseguro
                $config_pagseguro = $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1));
                //montando as credenciais de acesso
                $pagar_pedido['email'] = $config_pagseguro->config_email;
                $pagar_pedido['token'] = $config_pagseguro->config_token;
                //montando os dados do pedido
                $pagar_pedido['paymentMode'] = 'default';
                $pagar_pedido['paymentMethod'] = 'eft';
                $pagar_pedido['bankName'] = $this->input->post('banco_escolhido');
                $pagar_pedido['receiverEmail'] = $config_pagseguro->config_email;
                $pagar_pedido['currency'] = 'BRL';
                $pagar_pedido['extraAmount'] = '';
                //Codigo do pedido gerado automaticamente
                $pedido_codigo = $this->core_model->generate_unique_code('pedidos', 'numeric', 8, 'pedido_codigo');
                $pagar_pedido['reference'] = $pedido_codigo;
                //montar os dados do comprador
                $pagar_pedido['senderName'] = $nome_comprador;
                $pagar_pedido['senderCPF'] = $cpf_comprador;
                $pagar_pedido['senderAreaCode'] = substr($telefone_comprador, 1, 2);
                $pagar_pedido['senderPhone'] = trim(str_replace('-', '', substr($telefone_comprador, 4, 15)));
                $pagar_pedido['senderEmail'] = ($config_pagseguro->config_ambiente == 1 ? 'c45275693740746179577@sandbox.pagseguro.com.br' : $email_comprador);
                $pagar_pedido['shippingAddressStreet'] = $endereco_comprador;
                $pagar_pedido['shippingAddressNumber'] = $endereco_numero_comprador;
                $pagar_pedido['shippingAddressDistrict'] = $bairro_comprador;
                $pagar_pedido['shippingAddressPostalCode'] = $cep_comprador;
                $pagar_pedido['shippingAddressCity'] = $cidade_comprador;
                $pagar_pedido['shippingAddressState'] = $estado_comprador;
                $pagar_pedido['shippingAddressCountry'] = 'BRA';
                //DADOS DO FRETE
                $pagar_pedido['shippingType'] = ($opcao_frete_carrinho_servico == '04510' ? 1 : 2);
                $pagar_pedido['shippingCost'] = number_format($opcao_frete_carrinho_valor, 2, '.', '');
                //itens do carrinho de compras(sessao)
                $carrinho = $this->carrinho_compras->get_all();
                $contador = 1;
                foreach($carrinho as $indice => $produto){
                    $pagar_pedido['itemId'.$contador] = $produto['produto_id'];
                    $pagar_pedido['itemDescription'.$contador] = word_limiter(remove_acentos($produto['produto_nome']), 5);
                    $pagar_pedido['itemAmount'.$contador] = number_format($produto['produto_valor'], 2, '.', ''); 
                    $pagar_pedido['itemQuantity'.$contador] = $produto['produto_quantidade']; 
                }
                //Dados da transacao
                $pagar_pedido['senderHash'] = $hash_pagamento;
                /*------------------------INICIO DO ENVIO DA REQUISICAO PARA PROCESSAR O PAGAMENTO-------------------------------------*/
                if($config_pagseguro->config_ambiente == 0){                    
                    $url = 'https://ws.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente real
                }else{
                    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente sandbox - teste
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($pagar_pedido));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pagar_pedido));
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, $this->agent->agent_string());
                if($config_pagseguro->config_ambiente == 0){
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE); //é obrigatoria a verificaçao do SSL
                }else{                    
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//Nao é obrigatoria a verificacao do SSL
                }
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result);
                $json = json_encode($xml);
                $transaction = json_decode($json);
                //verifica se houve algum erro na transacao, se existir excluimos o cliente
                if(isset($transaction->error->code)){
                    if(!$cliente_logado){
                        $this->core_model->delete('clientes', array('cliente_id' => $cliente_id));
                    }
                    $retorno['erro'] = $transaction->error->code;
                    $retorno['mensagem'] = 'Houve um erro na transaçao';
                    echo json_encode($retorno);
                    exit();
                }
                //garanntimos que houve sucesso
                if(isset($transaction->code)){
                    /*Iniciamos o store do pedido, dos produtos do pedido e da transacao no banco de dados */
                    $pedido = array(
                        'pedido_cliente_id' => $cliente->cliente_id,
                        'pedido_codigo' => $pedido_codigo,
                        'pedido_valor_produtos' => str_replace(',', '', $this->carrinho_compras->get_total()),
                        'pedido_valor_frete' => number_format($opcao_frete_carrinho_valor, 2, '.', ''),
                        'pedido_valor_final' => str_replace(',','', $this->carrinho_compras->get_total()) + $opcao_frete_carrinho_valor,
                        'pedido_forma_envio' => ($opcao_frete_carrinho_servico == '04510' ? 1 : 2),
                    ); 
                    //gravar o pedido na tabela pedidos
                    $this->core_model->insert('pedidos', $pedido, TRUE);
                    $pedido_id = $this->session->userdata('last_id');//ultimo id inserido
                    foreach($carrinho as $indice => $produto){
                        $pedido = array(
                            'pedido_id' => $pedido_id,
                            'produto_id' => $produto['produto_id'],
                            'produto_nome' => $produto['produto_nome'],
                            'produto_quantidade' => $produto['produto_quantidade'],
                            'produto_valor_unitario' => $produto['produto_valor'],
                            'produto_valor_total' => $produto['subtotal'],
                        );
                        $this->core_model->insert('pedidos_produtos', $pedido);
                    }
                    //montando o array com os dados da transacao 
                    $transacao = array(
                        'transacao_pedido_id' => $pedido_id,
                        'transacao_cliente_id' => $cliente->cliente_id,
                        'transacao_codigo_hash' => $transaction->code,
                        'transacao_tipo_metodo_pagamento' => $transaction->paymentMethod->type,
                        'transacao_codigo_metodo_pagamento' => $transaction->paymentMethod->code,
                        'transacao_link_pagamento' => $transaction->paymentLink,
                        'transacao_valor_bruto' => $transaction->grossAmount,
                        'transacao_valor_taxa_pagseguro' => $transaction->feeAmount,
                        'transacao_valor_liquido' => $transaction->netAmount,
                        'transacao_numero_parcelas' => $transaction->installmentCount,
                        'transacao_valor_parcela' => $transaction->grossAmount,
                        'transacao_status' => $transaction->status
                    );
                    $this->core_model->insert('transacoes', $transacao);//salva no banco a transacao
                    $retorno['erro'] = 0;
                    $retorno['code'] = $transaction->code;
                    $retorno['forma_pagamento'] = $this->input->post('forma_pagamento');
                    $retorno['mensagem'] = 'Seu pedido foi realizado com sucesso!';
                    $retorno['pedido_gerado'] = $pedido_codigo;
                    $retorno['transacao_link_pagamento'] = $transaction->paymentLink;
                    $retorno['cliente_nome_completo'] = $cliente->cliente_nome.' '.$cliente->cliente_sobrenome;
                    //gravar na sessao os dados do pedido para serem mostrado para o cliente
                    $this->session->set_userdata('pedido_realizado', $retorno);
                    //limpar carrinho de compras da sessao
                    $this->carrinho_compras->clean();
                }
                echo json_encode($retorno); //retorna os dados para o javascript
            }
        }
    }
    //processar pagamento via cartao credito
    public function cartao_credito(){
        if(!$this->input->is_ajax_request()){
            exit('Açao nao permitida');
        }
        $cliente_logado = $this->ion_auth->logged_in();

        if(!$cliente_logado){
            $this->form_validation->set_rules('cliente_nome', 'nome', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_sobrenome', 'sobrenome', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_data_nascimento', 'data de nascimento', 'trim');
            $this->form_validation->set_rules('cliente_cpf', 'CPF', 'trim|required|exact_length[14]|callback_valida_cpf');
            $this->form_validation->set_rules('cliente_email', 'e-mail', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');               
            $this->form_validation->set_rules('cliente_telefone_movel', 'celular', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
            $this->form_validation->set_rules('cliente_cep', 'CEP', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('cliente_endereco', 'endereço', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('cliente_numero_endereco', 'numero', 'trim|required|max_length[15]');
            $this->form_validation->set_rules('cliente_bairro', 'bairro', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('cliente_cidade', 'cidade', 'trim|required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('cliente_estado', 'estado', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('cliente_senha', 'senha', 'trim|required|min_length[6]|max_length[200]');
            $this->form_validation->set_rules('confirmacao', ' confirmaçao de senha', 'trim|matches[cliente_senha]');
            $this->form_validation->set_rules('opcao_frete_carrinho', ' opcao do frete', 'trim|required');
            $this->form_validation->set_rules('token_pagamento', ' token de pagamento', 'trim|required');
            $retorno = array();
            if($this->form_validation->run()){
                //echo '<pre>';
                //print_r($this->input->post());
                //exit();
                $data = elements(
                    array(
                        'cliente_nome',
                        'cliente_sobrenome',
                        'cliente_data_nascimento',
                        'cliente_cpf',
                        'cliente_email',
                        'cliente_telefone_fixo',
                        'cliente_telefone_movel',
                        'cliente_cep',
                        'cliente_endereco',
                        'cliente_numero_endereco',
                        'cliente_bairro',
                        'cliente_cidade',
                        'cliente_estado',
                    ), $this->input->post()
                );
                $data = html_escape($data);
                $this->core_model->insert('clientes', $data, TRUE);
                $cliente_user_id = $this->session->userdata('last_id');//recuperando o ultimo id inserido
                //atualizacao da tabela de usuarios
                //Inserir um usuario na tablea de usuarios como um cliente
                $username = $this->input->post('cliente_nome');
                $password = $this->input->post('cliente_senha');
                $email = $this->input->post('cliente_email');
                $dados_usuario = array(
                    'cliente_user_id' => $cliente_user_id,
                    'first_name' => $this->input->post('cliente_nome'),
                    'last_name' => $this->input->post('cliente_sobrenome'),
                    'phone' => $this->input->post('cliente_telefone_movel'),
                    'active' => 1,
                );
                $group = array('2');//grupo de clientes
                if($this->ion_auth->register($username, $password, $email, $dados_usuario, $group)){
                    $retorno['erro'] = 0;
                    $retorno['mensagem'] = 'Usuario do cliente criado com sucesso';
                }else{
                    $retorno['erro'] = 5;
                    $retorno['mensagem'] = 'Nao foi possivel criar o usuario do cliente';
                }
                
            }else{
                //erros de validaçao
                $retorno['erro'] = 3;
                $retorno['cliente_nome'] = form_error('cliente_nome');
                $retorno['cliente_sobrenome'] = form_error('cliente_sobrenome');
                $retorno['cliente_data_nascimento'] = form_error('cliente_data_nascimento');
                $retorno['cliente_cpf'] = form_error('cliente_cpf');
                $retorno['cliente_email'] = form_error('cliente_email');
                $retorno['cliente_telefone_movel'] = form_error('cliente_telefone_movel');
                $retorno['cliente_cep'] = form_error('cliente_cep');
                $retorno['cliente_endereco'] = form_error('cliente_endereco');
                $retorno['cliente_numero_endereco'] = form_error('cliente_numero_endereco');
                $retorno['cliente_bairro'] = form_error('cliente_bairro');
                $retorno['cliente_cidade'] = form_error('cliente_cidade');
                $retorno['cliente_estado'] = form_error('cliente_estado');
                $retorno['cliente_senha'] = form_error('cliente_senha');
                $retorno['confirmacao'] = form_error('confirmacao');
                $retorno['token_pagamento'] = form_error('token_pagamento');
                echo json_encode($retorno);
                exit();
            }
        }
        if(!preg_match('/[0-9]{5}-[0-9]{3}/', $this->input->post('cliente_cep'))){
            $retorno['erro'] = 3;
            $retorno['cliente_cep'] = 'Informe um CEP válido';
            echo json_encode($retorno);
            exit();
        }   
        if(!$this->input->post('opcao_frete_carrinho')){
            $retorno['erro'] = 3;
            $retorno['opcao_frete_carrinho'] = 'Escolha uma opçao de frete';
            echo json_encode($retorno);
            exit();
        }
        if(!$cliente_logado){
            $cliente_user_id = $this->session->userdata('last_id');
        }else{
            $cliente_user_id = $this->session->userdata('cliente_user_id');
        }        
        if(!$cliente = $this->core_model->get_by_id('clientes', array('cliente_id' => $cliente_user_id))){
            $retorno['erro'] = 6;
            $retorno['mensagem'] = 'Cliente nao localizado'; 
            echo json_encode($retorno);
            exit();
        }else{
            //foi confirmada a existencia do cliente            
            $hash_pagamento = $this->input->post('hash_pagamento'); //verifica se o hash_pagamento contem valor
            if(!$hash_pagamento){
                $retorno['erro'] = 6;
                $retorno['mensagem'] = 'Nao foi gerado o hash de pagamento'; 
                echo json_encode($retorno);
                exit();
            }else{
                //ser o hash foi gerado, sucesso
                //montar os dados do cliente(comprador) para a compra
                $cliente_id = $cliente->cliente_id;
                $nome_comprador = remove_acentos($cliente->cliente_nome .' '. $cliente->cliente_sobrenome);
                $cpf_comprador = str_replace('.', '', $cliente->cliente_cpf);
                $cpf_comprador = str_replace('-', '', $cpf_comprador);
                $email_comprador = $cliente->cliente_email;
                $telefone_comprador = $cliente->cliente_telefone_movel;
                //recuperando os dados de endereço do compradpr
                $cep_comprador = str_replace('-', '', $cliente->cliente_cep);
                $endereco_comprador = remove_acentos($cliente->cliente_endereco);
                $endereco_numero_comprador = $cliente->cliente_numero_endereco;
                $bairro_comprador = remove_acentos($cliente->cliente_bairro);
                $cidade_comprador = remove_acentos($cliente->cliente_cidade);
                $estado_comprador = $cliente->cliente_estado;
                //recuperando os dados do frete escolhido
                $opcao_frete_carrinho = explode('|', $this->input->post('opcao_frete_carrinho'));
                $opcao_frete_carrinho_valor = $opcao_frete_carrinho[0]; //recupero o valor do frete escolhido contindo na posicao [0]
                $opcao_frete_carrinho_servico = $opcao_frete_carrinho[1];//recupero a segunda posicao que é justamente o servico do frete escolhido
                //recuperando as config do pagseguro
                $config_pagseguro = $this->core_model->get_by_id('config_pagseguro', array('config_id' => 1));
                //montando as credenciais de acesso
                $pagar_pedido['email'] = $config_pagseguro->config_email;
                $pagar_pedido['token'] = $config_pagseguro->config_token;
                //montando os dados do pedido
                $pagar_pedido['paymentMode'] = 'default';
                $pagar_pedido['paymentMethod'] = 'creditCard';
                $pagar_pedido['receiverEmail'] = $config_pagseguro->config_email;
                $pagar_pedido['currency'] = 'BRL';
                $pagar_pedido['extraAmount'] = '';
                //Codigo do pedido gerado automaticamente
                $pedido_codigo = $this->core_model->generate_unique_code('pedidos', 'numeric', 8, 'pedido_codigo');
                $pagar_pedido['reference'] = $pedido_codigo;
                //montar os dados do comprador
                $pagar_pedido['senderName'] = $nome_comprador;
                $pagar_pedido['senderCPF'] = $cpf_comprador;
                $pagar_pedido['senderAreaCode'] = substr($telefone_comprador, 1, 2);
                $pagar_pedido['senderPhone'] = trim(str_replace('-', '', substr($telefone_comprador, 4, 15)));
                $pagar_pedido['senderEmail'] = ($config_pagseguro->config_ambiente == 1 ? 'c45275693740746179577@sandbox.pagseguro.com.br' : $email_comprador);
                $pagar_pedido['shippingAddressStreet'] = $endereco_comprador;
                $pagar_pedido['shippingAddressNumber'] = $endereco_numero_comprador;
                $pagar_pedido['shippingAddressDistrict'] = $bairro_comprador;
                $pagar_pedido['shippingAddressPostalCode'] = $cep_comprador;
                $pagar_pedido['shippingAddressCity'] = $cidade_comprador;
                $pagar_pedido['shippingAddressState'] = $estado_comprador;
                $pagar_pedido['shippingAddressCountry'] = 'BRA';
                //DADOS DO FRETE
                $pagar_pedido['shippingType'] = ($opcao_frete_carrinho_servico == '04510' ? 1 : 2);
                $pagar_pedido['shippingCost'] = number_format($opcao_frete_carrinho_valor, 2, '.', '');
                //itens do carrinho de compras(sessao)
                $carrinho = $this->carrinho_compras->get_all();
                $contador = 1;
                foreach($carrinho as $indice => $produto){
                    $pagar_pedido['itemId'.$contador] = $produto['produto_id'];
                    $pagar_pedido['itemDescription'.$contador] = word_limiter(remove_acentos($produto['produto_nome']), 5);
                    $pagar_pedido['itemAmount'.$contador] = number_format($produto['produto_valor'], 2, '.', ''); 
                    $pagar_pedido['itemQuantity'.$contador] = $produto['produto_quantidade']; 
                }
                //Dados da transacao
                $pagar_pedido['senderHash'] = $hash_pagamento;
                $pagar_pedido['creditCardToken'] = $this->input->post('token_pagamento');
                //DADOS DO CARTAO DE CREDITO DO DONO
                $pagar_pedido['creditCardHolderName'] = $nome_comprador;
                $pagar_pedido['creditCardHolderCPF'] = $cpf_comprador;
                $pagar_pedido['creditCardHolderBirthDate'] = formata_data_banco_sem_hora($cliente->cliente_data_nascimento);
                $pagar_pedido['creditCardHolderAreaCode'] = substr($telefone_comprador, 1, 2);
                $pagar_pedido['creditCardHolderPhone'] = trim(str_replace('-', '', substr($telefone_comprador, 4, 15)));
                //OPCOES DE PARCELAMENTO -
                $pagar_pedido['installmentQuantity'] = 1; //verificar 
                $pagar_pedido['installmentValue'] = str_replace(',','', $this->carrinho_compras->get_total()) + $opcao_frete_carrinho_valor;
                //DADOS DE ENDEREÇO
                $pagar_pedido['billingAddressStreet'] = $endereco_comprador;
                $pagar_pedido['billingAddressNumber'] = $endereco_numero_comprador;
                $pagar_pedido['billingAddressDistrict'] = $bairro_comprador;
                $pagar_pedido['billingAddressPostalCode'] = $cep_comprador;
                $pagar_pedido['billingAddressCity'] = $cidade_comprador;
                $pagar_pedido['billingAddressState'] = $estado_comprador;
                $pagar_pedido['billingAddressCountry'] = 'BRA';
                
                /*------------------------INICIO DO ENVIO DA REQUISICAO PARA PROCESSAR O PAGAMENTO-------------------------------------*/
                if($config_pagseguro->config_ambiente == 0){                    
                    $url = 'https://ws.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente real
                }else{
                    $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions'; //carrega url base para ambiente sandbox - teste
                }
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, count($pagar_pedido));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($pagar_pedido));
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 45);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, $this->agent->agent_string());
                if($config_pagseguro->config_ambiente == 0){
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE); //é obrigatoria a verificaçao do SSL
                }else{                    
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//Nao é obrigatoria a verificacao do SSL
                }
                $result = curl_exec($ch);
                curl_close($ch);
                $xml = simplexml_load_string($result);
                $json = json_encode($xml);
                $transaction = json_decode($json);
                //verifica se houve algum erro na transacao, se existir excluimos o cliente QUE NAO ESTIVER LOGADO.
                if(isset($transaction->error->code)){
                    if(!$cliente_logado){
                        $this->core_model->delete('clientes', array('cliente_id' => $cliente_id));
                    }
                    $retorno['erro'] = $transaction->error->code;
                    $retorno['mensagem'] = 'Houve um erro na transaçao';
                    echo json_encode($retorno);
                    exit();
                }
                //garanntimos que houve sucesso
                if(isset($transaction->code)){
                    /*Iniciamos o store do pedido, dos produtos do pedido e da transacao no banco de dados */
                    $pedido = array(
                        'pedido_cliente_id' => $cliente->cliente_id,
                        'pedido_codigo' => $pedido_codigo,
                        'pedido_valor_produtos' => str_replace(',', '', $this->carrinho_compras->get_total()),
                        'pedido_valor_frete' => number_format($opcao_frete_carrinho_valor, 2, '.', ''),
                        'pedido_valor_final' => str_replace(',','', $this->carrinho_compras->get_total()) + $opcao_frete_carrinho_valor,
                        'pedido_forma_envio' => ($opcao_frete_carrinho_servico == '04510' ? 1 : 2),
                    ); 
                    //gravar o pedido na tabela pedidos
                    $this->core_model->insert('pedidos', $pedido, TRUE);
                    $pedido_id = $this->session->userdata('last_id');//ultimo id inserido
                    foreach($carrinho as $indice => $produto){
                        $pedido = array(
                            'pedido_id' => $pedido_id,
                            'produto_id' => $produto['produto_id'],
                            'produto_nome' => $produto['produto_nome'],
                            'produto_quantidade' => $produto['produto_quantidade'],
                            'produto_valor_unitario' => $produto['produto_valor'],
                            'produto_valor_total' => $produto['subtotal'],
                        );
                        $this->core_model->insert('pedidos_produtos', $pedido);
                    }
                    //montando o array com os dados da transacao 
                    $transacao = array(
                        'transacao_pedido_id' => $pedido_id,
                        'transacao_cliente_id' => $cliente->cliente_id,
                        'transacao_codigo_hash' => $transaction->code,
                        'transacao_tipo_metodo_pagamento' => $transaction->paymentMethod->type,
                        'transacao_codigo_metodo_pagamento' => $transaction->paymentMethod->code,
                        'transacao_valor_bruto' => $transaction->grossAmount,
                        'transacao_valor_taxa_pagseguro' => $transaction->feeAmount,
                        'transacao_valor_liquido' => $transaction->netAmount,
                        'transacao_numero_parcelas' => $transaction->installmentCount,
                        'transacao_valor_parcela' => $transaction->grossAmount,
                        'transacao_status' => $transaction->status
                    );
                    $this->core_model->insert('transacoes', $transacao);//salva no banco a transacao
                    $retorno['erro'] = 0;
                    $retorno['code'] = $transaction->code;
                    $retorno['forma_pagamento'] = $this->input->post('forma_pagamento');
                    $retorno['mensagem'] = 'Seu pedido foi realizado com sucesso!';
                    $retorno['pedido_gerado'] = $pedido_codigo;
                    //$retorno['transacao_link_pagamento'] = $transaction->paymentLink; -- NAO HA LINK DE PAGAMENTO PARA CREDITO
                    $retorno['cliente_nome_completo'] = $cliente->cliente_nome.' '.$cliente->cliente_sobrenome;
                    //gravar na sessao os dados do pedido para serem mostrado para o cliente
                    $this->session->set_userdata('pedido_realizado', $retorno);
                    //limpar carrinho de compras da sessao
                    $this->carrinho_compras->clean();
                }
                echo json_encode($retorno); //retorna os dados para o javascript
            }
        }
    }
    public function sucesso(){
        $data = array(
            'titulo' => 'Pedido realizado com sucesso!',
        );
        $pedido_realizado = $this->session->userdata('pedido_realizado');
        //verifica se o pedido nao esta vazio
        if(!empty($pedido_realizado)){
            if($pedido_realizado['forma_pagamento'] == 1){
                unset($pedido_realizado['transacao_link_pagamento']);//remove o link de pagamento da opcao cartao de credito[1]
            }
            $data['pedido_realizado'][] = (object) $pedido_realizado;            
        }else{
            redirect('/');
        }
        
        $this->load->view('web/layout/header', $data);
        $this->load->view('web/success');
        $this->load->view('web/layout/footer');
    }
    public function valida_cpf($cpf) {
        if ($this->input->post('cliente_id')) {//editando
            $cliente_id = $this->input->post('cliente_id');
            if ($this->core_model->get_by_id('clientes', array('cliente_id !=' => $cliente_id, 'cliente_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        }else{//cadastrando
            if ($this->core_model->get_by_id('clientes', array('cliente_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        }
        $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
        // Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
            $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
            return FALSE;
        } else {
            // Calcula os números para verificar se o CPF é verdadeiro
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c); //Se PHP version < 7.4, $cpf{$c}
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) { //Se PHP version < 7.4, $cpf{$c}
                    $this->form_validation->set_message('valida_cpf', 'Por favor digite um CPF válido');
                    return FALSE;
                }
            }
            return TRUE;
        }
    }
    public function valida_telefone_fixo($cliente_telefone_fixo){
        $cliente_id = $this->input->post('cliente_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clientes', array('cliente_telefone_fixo' => $cliente_telefone_fixo))){
                $this->form_validation->set_message('valida_telefone_fixo', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clientes', array('cliente_telefone_fixo' => $cliente_telefone_fixo, 'cliente_id !=' => $cliente_id))){
                $this->form_validation->set_message('valida_telefone_fixo', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }
    }
    public function valida_telefone_movel($cliente_telefone_movel){
        $cliente_id = $this->input->post('cliente_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clientes', array('cliente_telefone_movel' => $cliente_telefone_movel))){
                $this->form_validation->set_message('valida_telefone_movel', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clientes', array('cliente_telefone_movel' => $cliente_telefone_movel, 'cliente_id !=' => $cliente_id))){
                $this->form_validation->set_message('valida_telefone_movel', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }
    }
    public function valida_email($cliente_email){
        $cliente_id = $this->input->post('cliente_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clientes', array('cliente_email' => $cliente_email))){
                $this->form_validation->set_message('valida_email', 'Esse e-mail já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clientes', array('cliente_email' => $cliente_email, 'cliente_id !=' => $cliente_id))){
                $this->form_validation->set_message('valida_email', 'Esse e-mail já existe');
                return false;
            }else{
                return true;
            }
        }
    }
    public function send($assunto, $msg, $destinatario){
        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'andy.it.0927@gmail.com';
        $mail->Password = '229533As@';
        $mail->SMTPSecure = 'tls';
        $mail->Charset = 'UTF-8';
        $mail->Port = 587;
        //email de envio
        $mail->setFrom('andy.it.0927@gmail.com', 'Andressa envio');
        $mail->addReplyTo('andressa@ip3turbo.com.br', 'Andressa Copia');
        //email do remetente
        $mail->addAddress($destinatario);
        //Email subject8
        $mail->Subject = $assunto;
        //Informar formato html
        $mail->isHTML(true);
        //Corpo do email
        $mailContent = $msg;
        $mail->Body = $mailContent;
        if(!$mail->send()){
            echo 'Menssagem nao foi enviada. <br>';
            echo 'Mailer Error: '.$mail->ErrorInfo;            
        }else{
            echo 'Menssagem enviada';
        }
    }
}