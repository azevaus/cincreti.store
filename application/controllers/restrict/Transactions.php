<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Transactions extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->is_admin()) {
            redirect('/');
        }
        $this->load->model('transacoes_model');
    }
    public function index(){
        $data = array(
            'titulo' => 'Transaçoes realizadas',
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
            'transacoes' => $this->core_model->get_all('transacoes'),
        );
        //echo '<pre>';
        //print_r($data);
        //exit();

        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/transactions/index');
        $this->load->view('restrict/layout/footer');
    }
    public function view($transacao_id = NULL){
        $transacao_id = (int)$transacao_id;
        if(!$transacao_id || !$transacao = $this->transacoes_model->get_by_id($transacao_id)){
            $this->session->set_flashdata('erro', 'Transacoa nao encontrada');
            redirect('restrict/transactions');
        }else{
            $data = array(
                'titulo' => 'Detalhando a transaçao',                
                'transacoes' => $transacao,
            );
            //echo '<pre>';
            //print_r($data);
            //exit();    
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/transactions/view');
            $this->load->view('restrict/layout/footer');
        }
        
    }
    public function atualizar($transacao_codigo_hash = NULL){
        $url_check = 'https://ws.sandbox.pagseguro.uol.com.br/';//url para verificar se o sandbox esta online
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url_check);
        $xml = curl_exec($curl);
        if($xml != 'OK'){
            $this->session->set_flashdata('erro','A URL: '.$url_check.' nao está indisponivel no momento. Por favor, tente novamente dentro de alguns minutos.');
            redirect('restrict/transactions');
        }else{
            //ambiente do sandbox está online
            $config_pagseguro = $this->core_model->get_by_id('config_pagseguro' , array('config_id' => 1));//RECUPERANDO CONFIG DO PAGSEGURO
            //PARAMENTROS 
            $paramentros = array(
                'email' => $config_pagseguro->config_email,
                'token'=> $config_pagseguro->config_token,
            );
            $paramentros = http_build_query($paramentros);
            if($transacao_codigo_hash){
                //atualiza a transacao individualmente
                if(!$transacao = $this->core_model->get_by_id('transacoes', array('transacao_codigo_hash' => $transacao_codigo_hash))){
                    $this->session->ste_flashdata('erro', 'Nao encontramos a transacao');
                    redirect('restrict/transactions');
                }else{
                    $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/".$transacao->transacao_codigo_hash.'?'.$paramentros;
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    $xml = curl_exec($curl);
                    $xml = simplexml_load_string($xml);
                    $transacao_status = $xml->status;
                    if($transacao->transacao_status != $transacao_status){//so atualiza a transacao se seu status seja diferente do retornado pela API
                        $data = array(
                            'transacao_status' => $transacao_status,
                        );
                        $this->core_model->update('transacoes', $data, array('transacao_codigo_hash'=>$transacao_codigo_hash));
                        redirect('restrict/transactions');
                    }else{
                        $this->session->set_flashdata('sucesso','A transaçao ja estava atualizada.');
                        redirect('restrict/transactions');
                    }
                }
                
            }else{
                //atualiza a transacao em massa (todas*)
                $data_final_banco = $this->transacoes_model->get_last_date();                
                $data_inicial_banco = $this->transacoes_model->get_first_date($data_final_banco->transacao_data);
                //PARAMENTROS 
                $paramentros = array(
                    'initialDate' => $data_inicial_banco->transacao_data,
                    'finalDate' => $data_final_banco->transacao_data,
                    'email' => $config_pagseguro->config_email,
                    'token'=> $config_pagseguro->config_token,                    
                );
                
                $paramentros = http_build_query($paramentros);
                /* RECUPERO AS TRANSACOES QUE ESTEJAM NO INTERVALO DE 30 DIAS QUE SEJAM SUPERIO A $data_inicial_banco NO SEU ATRIBUTO $data_inicial_banco->transacao_data */
                $transacoes = $this->transacoes_model->get_all_transacoes_intervalo($data_inicial_banco->transacao_data);
                $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions?".$paramentros;
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($curl, CURLOPT_URL, $url);
                $xml = curl_exec($curl);
                $xml = simplexml_load_string($xml);
                $xml = json_encode($xml);
                $consulta = json_decode($xml);
                /* IMPORTANTE: quando é feita a consulta por intervalo de datas, a transacao cujo status é devolvida nao é retornada*/

                foreach($consulta->transactions->tansaction as $transaction_request){
                    $data =array(
                        'transacao_status' => $transaction_request->status,
                    );
                    $this->core_model->update('transacoes', $data, array('transacao_codigo_hash' => $transaction_request->code));
                }
                $this->session->set_flashdata('sucesso','Atualizaçao em massa realizada com sucesso!');
                redirect('restrict/transactions');
            }
        }
    }
}