<?php
date_default_timezone_set('America/Sao_Paulo');
defined('BASEPATH') or exit('Ação não permitida.');
class Profile extends CI_Controller{
    public function __construct(){
        parent::__construct(); 
        //$this->load->library('email');       
    }    
    public function index(){
        $cliente_id = (int)$this->session->userdata('cliente_user_id');
        if(!$cliente_id || !$cliente = $this->core_model->get_by_id('clients', array('client_id' => $cliente_id))){
            //Criando um novo cliente
            $this->form_validation->set_rules('client_surname', 'Sobrenome do cliente', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('client_name', 'Nome do cliente', 'trim|required|min_length[3]|max_length[40]');            
            $this->form_validation->set_rules('client_birth', 'Data de nascimento', 'trim|required');
            $this->form_validation->set_rules('client_cpf', 'CPF do cliente', 'trim|required|exact_length[14]|callback_valida_cpf');
            $this->form_validation->set_rules('client_email', 'Email do cliente', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');
            $this->form_validation->set_rules('client_rg', 'RG do cliente', 'trim|min_length[10]|max_length[13]');
            $this->form_validation->set_rules('client_mother', 'Nome da mae do cliente', 'trim|required|min_length[4]|max_length[40]');
            $this->form_validation->set_rules('client_dad', 'Nome do pai do cliente', 'trim|min_length[4]|max_length[40]');
            $cliente_telefone_fixo = $this->input->post('client_phone');
            if($cliente_telefone_fixo){
                $this->form_validation->set_rules('client_phone', 'Telefone fixo do cliente', 'trim|exact_length[14]|callback_valida_telefone_fixo');
            }                 
            $this->form_validation->set_rules('client_cell', 'Celular do cliente', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
            $this->form_validation->set_rules('client_state', 'CEP do cliente', 'trim|required|exact_length[9]');
            $this->form_validation->set_rules('client_address', 'Endereço do cliente', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('client_number', 'Numero do cliente', 'trim|max_length[15]');
            $this->form_validation->set_rules('client_district', 'Bairro do cliente', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('client_city', 'Cidade do cliente', 'trim|required|min_length[4]|max_length[100]');
            $this->form_validation->set_rules('client_uf', 'Estado do cliente', 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('client_reference', 'Complemnto do cliente', 'trim|max_length[130]');
            $this->form_validation->set_rules('password', 'senha', 'trim|min_length[6]|max_length[200]');
            $this->form_validation->set_rules('confirma', ' confirmaçao de senha', 'trim|matches[password]');
            if($this->form_validation->run()){                
                $data = elements(
                    array(     
                        'client_code',                   
                        'client_surname',
                        'client_name',
                        'client_birth',
                        'client_cpf',
                        'client_email',
                        'client_rg',
                        'client_mother',
                        'client_dad',
                        'client_phone',
                        'client_cell',
                        'client_state',
                        'client_address',
                        'client_number',
                        'client_district',
                        'client_city',
                        'client_reference',
                        'client_uf',                        
                    ), $this->input->post()
                );      
                $data['client_code'] = $this->core_model->generate_unique_code('clients', 'numeric', 4, 'client_code');       
                $data = html_escape($data);
                $this->core_model->insert('clients', $data, TRUE);
                $cliente_user_id = $this->session->userdata('last_id');//recuperando o ultimo id inserido
                //atualizacao da tabela de usuarios
                //Inserir um usuario na tablea de usuarios como um cliente
                $username = $this->input->post('client_name');
                $password = $this->input->post('password');
                $email = $this->input->post('client_email');
                $dados_usuario = array(
                    'cliente_user_id' => $cliente_user_id,
                    'first_name' => $this->input->post('client_name'),
                    'last_name' => $this->input->post('client_surname'),
                    'phone' => $this->input->post('client_cell'),
                    'active' => 0,
                );
                $group = array('2');//grupo de clientes
                
                if($this->ion_auth->register($username, $password, $email, $dados_usuario, $group)){
                    $data = array(
                        'titulo' => 'Confirmação de cadastro.',
                        'cliente' => $this->core_model->get_by_id('clients', array('client_id' => $cliente_user_id)),
                        'cliente_codigo' => $data['client_code'],
                        'mensagens' => $this->load->view('emails/confirmacao_cadastro')
                    );
                    $assunto = 'Confirmação de cadastro.';
                    //Montando a mensagem que será enviado por email
                    //montando o css
                    $msg = '<style>'; 
                    $msg .= '*{font-family: Montserrat, sans-serif;margin: 0px;background-color: #cccccc;}';
                    $msg .= 'h3{font-size: 14px;}';
                    $msg .= '.download h3 {margin-bottom: 50px;font-size: 25px;}';
                    $msg .= 'a{text-decoration: none;list-style: none;font-size: 20px;}';
                    $msg .= '.logo{background-color: #616161;width: 100%;height: 180px;}';
                    $msg .= '.download p {color: #2d3033;font-weight: 600;text-transform: uppercase;}';
                    $msg .= '.download .btn {margin-top: 30px;}';
                    $msg .= '.btn {background-color: #1c1c1c;color: #fff;font-size: 23px;font-weight: 600;border: 0;-moz-border-radius: 2px;-webkit-border-radius: 2px;border-radius: 2px;display: inline-block;text-transform: uppercase;}';
                    $msg .= '.btn:hover, .btn:focus {background-color: #1c1c1c;color: #fff;}';
                    $msg .= '.btn-large {padding: 15px 40px;}';
                    $msg .= '.mycontainer{display: flex;justify-content: center;text-align: center;align-items: center;flex-direction: column;}  ';
                    $msg .= '.container{z-index: 9999;background-color: white;padding-top: 90px;position: fixed;margin-top: 32%;border-radius: 3px;}';
                    $msg .= '.footer{background-color: #1c1c1c;width: 100%;padding: 40px 0px 40px 0px;margin-top: 60px;}';
                    $msg .= '.footer-h3{color: #fff;}';
                    $msg .= '.info{padding-top: 15px;text-align: start;padding-left: 10px;font-size: 14px;display: flex;flex-direction: column;}';
                    $msg .= '</style>';
                    //fim do css
                    //montando o html
                    $msg .= '<section id="download" class="section download mycontainer">';
                    $msg .= '<div class="logo">';
                    $msg .= '<div>';
                    $msg .= '<div>';
                    $msg .= '<div class="container ">';
                    $msg .= '<div class="col-md-8 col-md-offset-2 text-center" style="background-color: white;">';
                    $msg .= '<h3 style="background-color: white;">Cadastro realizado com sucesso!</h3>';
                    $msg .= '<p style="font-size: 14px; padding: 0px 50px; text-transform:none; background-color: white;">Olá Fulano, seu codigo para ativação da sua conta na Cincreti Store é:</p>';
                    $msg .= '<a href="" class="btn btn-large">&nbsp;'.$data['client_code'].'bsp;</a>';
                    $msg .= '</div>';
                    $msg .= '<div class="footer">';
                    $msg .= '<h3 class="footer-h3" style="font-size: 14px; margin-bottom:30px; background-color: #1c1c1c;">Não reconhece esse e-mail?</h3>';
                    $msg .= '<p style="color:#fff; font-size: 14px; padding: 0px 50px; text-transform:none; background-color: #1c1c1c;">Entre em contato com nossos atendentes para maiores explicações.</p>';
                    $msg .= '</div>';
                    $msg .= '<div class="info">';
                    $msg .= '<span style="margin-bottom: 5px;">Cincreti Store</span>';
                    $msg .= '<span style="margin-bottom: 5px;">cincreti@cincreti.com</span>';
                    $msg .= '<span>Areado/MG</span>';
                    $msg .= '</div>';
                    $msg .= '</div>';
                    $msg .= '</section>';
                    //fim do html
                    //fim da montagem do HTML para envio do e-mail
                    $destinatario = $email;
                    $this->send($assunto, $msg , $destinatario);
                    $this->session->set_flashdata('sucesso', 'Cadastro realizado com sucesso! Um e-mail foi enviado para a confirmação do seu cadastro');
                    redirect('confirmacao'); 
                }     
            }else{
                //erro de validacao 
                $data = array(
                    'titulo' => 'Cadastrar',                        
                    'scripts' => array(
                        'mask/jquery.mask.min.js',
                        'mask/custom.js',                        
                    ),
                );            
                $this->load->view('web/layout/header', $data);
                $this->load->view('web/profile');
                $this->load->view('web/layout/footer');
            }
        }else{
            //editando cliente logado
            if(!$this->ion_auth->logged_in()){
                redirect('login');
            }else{
                //sucesso.. inicio da edicao dos dados
                $this->form_validation->set_rules('client_surname', 'Sobrenome do cliente', 'trim|required|min_length[4]|max_length[140]');
                $this->form_validation->set_rules('client_name', 'Nome do cliente', 'trim|required|min_length[3]|max_length[40]');            
                $this->form_validation->set_rules('client_birth', 'Data de nascimento', 'trim|required');
                $this->form_validation->set_rules('client_cpf', 'CPF do cliente', 'trim|required|exact_length[14]|callback_valida_cpf');
                $this->form_validation->set_rules('client_email', 'Email do cliente', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');
                $this->form_validation->set_rules('client_rg', 'RG do cliente', 'trim|min_length[10]|max_length[13]');
                $this->form_validation->set_rules('client_mother', 'Nome da mae do cliente', 'trim|required|min_length[4]|max_length[40]');
                $this->form_validation->set_rules('client_dad', 'Nome do pai do cliente', 'trim|min_length[4]|max_length[40]');
                $cliente_telefone_fixo = $this->input->post('client_phone');
                if($cliente_telefone_fixo){
                    $this->form_validation->set_rules('client_phone', 'Telefone fixo do cliente', 'trim|exact_length[14]|callback_valida_telefone_fixo');
                }                 
                $this->form_validation->set_rules('client_cell', 'Celular do cliente', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
                $this->form_validation->set_rules('client_state', 'CEP do cliente', 'trim|required|exact_length[9]');
                $this->form_validation->set_rules('client_address', 'Endereço do cliente', 'trim|required|min_length[4]|max_length[140]');
                $this->form_validation->set_rules('client_number', 'Numero do cliente', 'trim|max_length[15]');
                $this->form_validation->set_rules('client_district', 'Bairro do cliente', 'trim|required|min_length[3]|max_length[40]');
                $this->form_validation->set_rules('client_city', 'Cidade do cliente', 'trim|required|min_length[4]|max_length[100]');
                $this->form_validation->set_rules('client_uf', 'Estado do cliente', 'trim|required|exact_length[2]');
                $this->form_validation->set_rules('client_reference', 'Complemnto do cliente', 'trim|max_length[130]');
                $this->form_validation->set_rules('password', 'senha', 'trim|min_length[6]|max_length[200]');
                $this->form_validation->set_rules('confirma', ' confirmaçao de senha', 'trim|matches[password]');
                if($this->form_validation->run()){
                    $data = elements(
                        array(
                            'client_surname',
                            'client_name',
                            'client_birth',
                            'client_cpf',
                            'client_email',
                            'client_rg',
                            'client_mother',
                            'client_dad',
                            'client_phone',
                            'client_cell',
                            'client_state',
                            'client_address',
                            'client_number',
                            'client_district',
                            'client_city',
                            'client_reference',
                            'client_uf',   
                        ), $this->input->post()

                    );
                    $data = html_escape($data);
                    $this->core_model->update('clients', $data, array('client_id' => $cliente_id));
                    //atualizacao da tabela de usuarios
                    
                    $dados_usuario = array(
                        'first_name' => $this->input->post('client_name'),
                        'last_name' => $this->input->post('client_surname'),
                        'email' => $this->input->post('client_email'),
                    );
                    $password = $this->input->post('password');
                    if($password){//atualiza se vier no post a senha
                        $dados_usuario['password'] = $password;
                    }
                    $usuario = $this->core_model->get_by_id('users', array('cliente_user_id' => $cliente_id));
                    $dados_usuario = html_escape($dados_usuario);
                    $user_id = $usuario->id;
                    $this->ion_auth->update($user_id, $dados_usuario);
                    redirect('perfil');
                }else{
                    //erro de validacao 
                    $data = array(
                        'titulo' => 'Atualizar perfil',                        
                        'scripts' => array(
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',
                        ),
                        'cliente' => $cliente,
                    );            
                    $this->load->view('web/layout/header', $data);
                    $this->load->view('web/profile');
                    $this->load->view('web/layout/footer');
                }

            }
        }       
    }
    public function valida_cpf($cpf) {
        if ($this->input->post('client_id')) {//editando
            $cliente_id = $this->input->post('client_id');
            if ($this->core_model->get_by_id('clients', array('client_id !=' => $cliente_id, 'client_cpf' => $cpf))) {
                $this->form_validation->set_message('valida_cpf', 'O campo {field} já existe, ele deve ser único');
                return FALSE;
            }
        }else{//cadastrando
            if ($this->core_model->get_by_id('clients', array('client_cpf' => $cpf))) {
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
        $cliente_id = $this->input->post('client_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clients', array('client_phone' => $cliente_telefone_fixo))){
                $this->form_validation->set_message('valida_telefone_fixo', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clients', array('client_phone' => $cliente_telefone_fixo, 'client_id !=' => $cliente_id))){
                $this->form_validation->set_message('valida_telefone_fixo', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }
    }
    public function valida_telefone_movel($cliente_telefone_movel){
        $cliente_id = $this->input->post('client_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clients', array('client_cell' => $cliente_telefone_movel))){
                $this->form_validation->set_message('valida_telefone_movel', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clients', array('client_cell' => $cliente_telefone_movel, 'client_id !=' => $cliente_id))){
                $this->form_validation->set_message('valida_telefone_movel', 'Esse telefone já existe');
                return false;
            }else{
                return true;
            }
        }
    }
    public function valida_email($cliente_email){
        $cliente_id = $this->input->post('client_id');
        if(!$cliente_id){
            //cadastrando
            if($this->core_model->get_by_id('clients', array('client_email' => $cliente_email))){
                $this->form_validation->set_message('valida_email', 'Esse e-mail já existe');
                return false;
            }else{
                return true;
            }
        }else{
            //edicao
            if($this->core_model->get_by_id('clients', array('client_email' => $cliente_email, 'client_id !=' => $cliente_id))){
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
        //$mail = new PHPMailer();
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