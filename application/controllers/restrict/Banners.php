<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Banners extends CI_Controller{
    public function __construct() {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrita/login');
        }
    }
    public function index(){
        $data = array(
            'titulo' => 'Bannes Rotativos',
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
            'banners' => $this->core_model->get_all('banners'),
        );

        $this->load->view('restrita/layout/header', $data);
        $this->load->view('restrita/banners/index');
        $this->load->view('restrita/layout/footer'); 
    }
    public function core($banner_id = NULL){
        $banner_id = (int)$banner_id;
        if(!$banner_id){
            //cadastrando
            $banner_id = (int)$banner_id;
            if(!$banner_id){
                //se nao foi passado um id, cadastrar
                $this->form_validation->set_rules('banner_nome','Nome do banner','trim|required|min_length[4]|max_length[240]');
                $fotos_banners = $this->input->post('fotos_banners');
                if(!$fotos_banners){
                    $this->form_validation->set_rules('fotos_banners','Imagens do banner','required');
                }
                if($this->form_validation->run()){
                    $data = elements(
                        array(
                            'banner_nome',                            
                        ), $this->input->post()
                    );
                    $data = html_escape($data);
                    $this->core_model->insert('banners', $data, TRUE);
                    $banner_id = $this->session->userdata('last_id');
                    $fotos_banners = $this->input->post('fotos_banners');
                    if($fotos_banners){
                        $total_fotos = @count($fotos_banners);
                        for($i = 0; $i < $total_fotos; $i++){
                            $data = array(
                                'foto_banner' => $banner_id,
                                'foto_caminho' => $fotos_banners[$i],
                            );
                        $this->core_model->insert('banners_fotos', $data);
                        }
                    }
                    redirect('restrita/banners');
                }else{
                    $data = array(
                        'titulo' => 'Editar banner ',
                        'styles' => array(
                            'jquery-upload-file/css/uploadfile.css',
                        ),
                        'scripts' => array(
                            'jquery-upload-file/js/jquery.uploadfile.min.js',
                            'sweetalert/sweetalert2.all.min.js',                        
                            'jquery-upload-file/js/banners.js',
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',                            
                        ),
                    );        
            
                    $this->load->view('restrita/layout/header', $data);
                    $this->load->view('restrita/banners/core');
                    $this->load->view('restrita/layout/footer');
                }
            }
        }else{
            if(!$banner = $this->core_model->get_by_id('banners', array('banner_id' => $banner_id))){
                $this->session->set_flashdata('erro', 'Esse banner nao foi encontrado');
                redirect('restrita/banners');
            }else{
                //editando
                $this->form_validation->set_rules('banner_nome','Nome do banner','trim|required|min_length[4]|max_length[240]');
               
                if($this->form_validation->run()){
                    $data = elements(
                        array(
                            'banner_nome',
                        ), $this->input->post()
                    );
                    $data = html_escape($data);
                    $this->core_model->update('banners', $data, array('banner_id' => $banner_id));
                    $fotos_banners = $this->input->post('fotos_banners');
                    if($fotos_banners){
                        $total_fotos = @count($fotos_banners);
                        for($i = 0; $i < $total_fotos; $i++){
                            $data = array(
                                'foto_banner' => $banner_id,
                                'foto_caminho' => $fotos_banners[$i],
                            );
                        $this->core_model->insert('banners_fotos', $data);
                        }
                    }
                    redirect('restrita/banners');
                }else{
                    $data = array(
                        'titulo' => 'Editar banner ',
                        'styles' => array(
                            'jquery-upload-file/css/uploadfile.css',
                        ),
                        'scripts' => array(
                            'jquery-upload-file/js/jquery.uploadfile.min.js',
                            'sweetalert/sweetalert2.all.min.js',                        
                            'jquery-upload-file/js/banners.js',
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',                            
                        ),
                        'banners' => $banner,
                    );        
            
                    $this->load->view('restrita/layout/header', $data);
                    $this->load->view('restrita/banners/core');
                    $this->load->view('restrita/layout/footer');
                }
            }
        }
        
    }
    public function upload(){
        $config['upload_path'] = './uploads/banners_full/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 2048;
        $config['max_width'] = 1000;
        $config['max_height'] = 1000;
        $config['encrypt_name'] = TRUE;
        $config['max_filename'] = 200;
        $config['file_ext_tolower'] = TRUE;
        $this->load->library('upload', $config);
        if($this->upload->do_upload('foto_banner')){
            $data = array(
                'uploaded_data' => $this->upload->data(),
                'mensagem' => 'Imagem enviada com sucesso!',
                'banner_foto_caminho' => $this->upload->data('file_name'),
                'erro' => 0
            );
            //echo '<pre>';
            //print_r( $this->upload->data);
            //exit();
            //resize image configuration
            $config['image_library'] = 'gd2';
            $config['source_image'] = './uploads/banners_full/'.$this->upload->data('file_name');
            $config['new_image'] = './uploads/banners_full/small/'.$this->upload->data('file_name');
            $config['width'] = 300;
            $config['height'] = 300;
            //chama a biblioteca
            $this->load->library('image_lib', $config);
            //faz o resize
            //$this->image_lib->resize();
            if(!$this->image_lib->resize()){
                $data['erro'] = $this->image_lib->display_errors();
            }
        }else{
            $data = array(
                'mensagem' => $this->upload->display_errors(),
                'erro' => 5,
            );
        }
        echo json_encode($data);
    }
}