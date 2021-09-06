<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Clients extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index(){
        $data = array(
            'titulo' => 'Clientes cadastradas',
            'styles' => array(
                'bundles/datatables/datatables.min.css',
                'bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'bundles/datatables/datatables.min.js',
                'bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js',
                'bundles/jquery-ui/jquery-ui.min.js',
                'js/page/datatables.js'
            ),
            'clientes' => $this->core_model->get_all('clients'),
        );
        /*echo '<pre>';
        print_r($data);
        exit();*/
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/clients/index');
        $this->load->view('restrict/layout/footer');
    }
    public function core($cliente_id = NULL){
        $cliente_id = (int)$cliente_id;
        if(!$cliente_id){
            //cadastrar
            $this->form_validation->set_rules('client_name', 'Nome do cliente', 'trim|required|min_length[3]|max_length[40]');
            $this->form_validation->set_rules('client_surname', 'Sobrenome do cliente', 'trim|required|min_length[4]|max_length[140]');
            $this->form_validation->set_rules('client_birth', 'Data de nascimento', 'trim|required');
            $this->form_validation->set_rules('client_cpf', 'CPF do cliente', 'trim|required|exact_length[14]|callback_valida_cpf');
            $this->form_validation->set_rules('client_email', 'Email do cliente', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');
            $this->form_validation->set_rules('client_rg', 'RG do cliente', 'trim|required|min_length[10]|max_length[13]');
            $this->form_validation->set_rules('client_mother', 'Nome da mae do cliente', 'trim|required|min_length[4]|max_length[40]');
            $this->form_validation->set_rules('client_dad', 'Nome do pai do cliente', 'trim|min_length[4]|max_length[40]');
            $cliente_telefone_fixo = $this->input->post('client_phone');
            if($cliente_telefone_fixo){
                $this->form_validation->set_rules('client_phone', 'Telefone fixo do cliente', 'trim|exact_length[14]|callback_valida_telefone_fixo');
            }                 
            $this->form_validation->set_rules('client_cell', 'Celular do cliente', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
            $this->form_validation->set_rules('clien_state', 'CEP do cliente', 'trim|required|exact_length[9]');
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
                        'client_name',
                        'client_surname',
                        'client_birth',
                        'client_cpf',
                        'client_email',
                        'client_rg',
                        'client_mother',
                        'client_dad',
                        'client_phone',
                        'client_cell',
                        'clien_state',
                        'client_address',
                        'client_number',
                        'client_district',
                        'client_reference',
                        'client_city',
                        'client_uf',
                    ), $this->input->post()

                );
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
                    'active' => 1,
                );
                $group = array('2');//grupo de clientes
                $this->ion_auth->register($username, $password, $email, $dados_usuario, $group);
                redirect('restrict/clients');
            }else{
                //erro de validacao 
                $data = array(
                    'titulo' => 'Cadastrar cliente',                        
                    'scripts' => array(
                        'mask/jquery.mask.min.js',
                        'mask/custom.js',
                    ),
                );            
                $this->load->view('restrict/layout/header', $data);
                $this->load->view('restrict/clients/core');
                $this->load->view('restrict/layout/footer');
            }

        }else{
            //editando cliente
            if(!$cliente = $this->core_model->get_by_id('clients', array('client_id' => $cliente_id))){
                $this->session->set_flashdata('erro', 'Cliente nao encontrado');
                redirect('restrict/clients');
            }else{
                //sucesso.. cliente encontrado
                $this->form_validation->set_rules('client_name', 'Nome do cliente', 'trim|required|min_length[3]|max_length[40]');
                $this->form_validation->set_rules('client_surname', 'Sobrenome do cliente', 'trim|required|min_length[4]|max_length[140]');
                $this->form_validation->set_rules('client_birth', 'Data de nascimento', 'trim|required');
                $this->form_validation->set_rules('client_cpf', 'CPF do cliente', 'trim|required|exact_length[14]|callback_valida_cpf');
                $this->form_validation->set_rules('client_email', 'Email do cliente', 'trim|required|valid_email|min_length[10]|max_length[100]|callback_valida_email');
                $this->form_validation->set_rules('client_rg', 'RG do cliente', 'trim|required|min_length[10]|max_length[13]');
                $this->form_validation->set_rules('client_mother', 'Nome da mae do cliente', 'trim|required|min_length[4]|max_length[40]');
                $this->form_validation->set_rules('client_dad', 'Nome do pai do cliente', 'trim|min_length[4]|max_length[40]');
                $cliente_telefone_fixo = $this->input->post('client_phone');
                if($cliente_telefone_fixo){
                    $this->form_validation->set_rules('client_phone', 'Telefone fixo do cliente', 'trim|exact_length[14]|callback_valida_telefone_fixo');
                }                 
                $this->form_validation->set_rules('client_cell', 'Celular do cliente', 'trim|required|min_length[14]|max_length[15]|callback_valida_telefone_movel');
                $this->form_validation->set_rules('clien_state', 'CEP do cliente', 'trim|required|exact_length[9]');
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
                            'client_name',
                            'client_surname',
                            'client_birth',
                            'client_cpf',
                            'client_email',
                            'client_rg',
                            'client_mother',
                            'client_dad',
                            'client_phone',
                            'client_cell',
                            'clien_state',
                            'client_address',
                            'client_number',
                            'client_district',
                            'client_reference',
                            'client_city',
                            'client_uf',
                        ), $this->input->post()

                    );
                    $data = html_escape($data);
                    //echo '<pre>';
                    //print_r($data);
                    //exit();
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
                    redirect('restrict/clients');
                }else{
                    //erro de validacao 
                    $data = array(
                        'titulo' => 'Editar cliente',                        
                        'scripts' => array(
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',
                        ),
                        'cliente' => $cliente,
                    );            
                    $this->load->view('restrict/layout/header', $data);
                    $this->load->view('restrict/clients/core');
                    $this->load->view('restrict/layout/footer');
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
    public function delete($cliente_id = NULL){
        if(!$this->ion_auth->is_admin()){
            $this->session->set_flashdata('erro', 'Voce nao tem permissao para acessar esse menu.');
            redirect('restrict/clients');
        }
        if(!$this->core_model->get_by_id('clients', array('client_id' => $cliente_id))){
            $this->session->set_flashdata('erro', 'Cliente nao encontrado.');
            redirect('restrict/clients');
        }
        if($this->core_model->get_by_id('users', array('cliente_user_id' => $cliente_id, 'active' => 1))){
            $this->session->set_flashdata('erro', 'Nao é possivel esxcluir um cliente com usuário ativo.');
            redirect('restrict/clients');
        }
        $this->core_model->delete('clients', array('client_id' => $cliente_id));
        redirect('restrict/clients');
    }
}