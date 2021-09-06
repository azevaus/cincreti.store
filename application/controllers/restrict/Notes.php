<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Notes extends CI_Controller{
    public function __construct(){
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
        $this->load->model('avaliacoes_model');
    }
    public function index(){
        $data = array(
            'titulo' => 'Avaliacoes',
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
            'avaliacoes' => $this->avaliacoes_model->get_all('notes'),
        );
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/notes/index');
        $this->load->view('restrict/layout/footer');
    }
    public function view($avaliacao_id = NULL){
        if(!$avaliacao_id || !$avaliacao = $this->avaliacoes_model->get_avaliacoes($avaliacao_id)){
            echo 'Nao encontrei';
        }else{
            $data = array(
                'titulo' => 'Detalhes da avaliação',
                'dados'=> $avaliacao,
            );
            $this->load->view('restrict/layout/header', $data);
            $this->load->view('restrict/notes/view');
            $this->load->view('restrict/layout/footer');
        }
    }
    public function delete($avaliacao_id = NULL){
        $avaliacao_id = (int)$avaliacao_id;
        if (!$avaliacao_id || !$this->core_model->get_by_id('notes', array('note_id' => $avaliacao_id))) {
            $this->session->set_flashdata('erro', 'Essa avaliacao nao existe');
            redirect('restrict/notes');
        }
        $this->core_model->delete('notes', array('note_id' => $avaliacao_id));
        redirect('restrict/notes');
    }
}