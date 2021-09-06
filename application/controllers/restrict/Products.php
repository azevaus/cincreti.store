<?php
defined('BASEPATH') or exit('Ação não permitida.');
class Products extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->ion_auth->logged_in()) {
            redirect('restrict/login');
        }
    }
    public function index()
    {
        $data = array(
            'titulo' => 'Produtos cadastrados',
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
            'produtos' => $this->produtos_model->get_all('products'),
        );
        $this->load->view('restrict/layout/header', $data);
        $this->load->view('restrict/products/index');
        $this->load->view('restrict/layout/footer');
    }
    public function core($pro_id = NULL)
    {
        $pro_id = (int)$pro_id;
        if (!$pro_id) { //se nao existe, CADASTRA de fato o produto
            //Validaçoes
            $this->form_validation->set_rules('pro_name', 'Nome do produto', 'trim|required|min_length[4]|max_length[240]|callback_valida_nome_produto');
            $this->form_validation->set_rules('pro_categ_id', 'Categoria do Produto', 'trim|required');
            $this->form_validation->set_rules('pro_brand_id', 'Marca do produto', 'trim|required');
            $this->form_validation->set_rules('pro_value', 'Valor de venda do produto', 'trim|required');
            $this->form_validation->set_rules('pro_qtd_stock', 'Quantidade em estoque', 'trim|required|integer');
            $this->form_validation->set_rules('pro_description', 'Descriçao do produto', 'trim|required|min_length[10]|max_length[5000]');
            $this->form_validation->set_rules('pro_model', 'modelo do produto', 'trim|min_length[2]|max_length[180]');
            $this->form_validation->set_rules('pro_peso', 'peso do Produto', 'trim|required');
            $this->form_validation->set_rules('pro_largura', 'largura do produto', 'trim|required');
            $this->form_validation->set_rules('pro_altura', 'altura do produto', 'trim|required');
            $this->form_validation->set_rules('pro_comprimento', 'comprimento do produto', 'trim|required|integer');
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'pro_name',
                        'pro_categ_id',
                        'pro_brand_id',
                        'pro_value',
                        'pro_destaque',
                        'pro_control_stock',
                        'pro_active',
                        'pro_qtd_stock',
                        'pro_description',
                        'pro_model',
                        'pro_peso',
                        'pro_largura',
                        'pro_altura',
                        'pro_comprimento',
                        'content_package',
                        'peso_pro_embalagem',
                        'pro_peso_embalagem',
                    ),
                    $this->input->post()
                );
                $data['pro_value'] = str_replace(',', '', $data['pro_value']);
                $data['pro_meta_link'] = url_amigavel($data['pro_name']); //CRIA O META LINK COM BASE NO NOME PASSADO
                $data['pro_code'] = $this->core_model->generate_unique_code('products', 'numeric', 8, 'pro_code');
                $data = html_escape($data);
                $this->core_model->insert('products', $data, TRUE);
                $produto_id = $this->session->userdata('last_id');
                $fotos_produtos = $this->input->post('fotos_produtos');
                if ($fotos_produtos) {
                    $total_fotos = @count($fotos_produtos);
                    for ($i = 0; $i < $total_fotos; $i++) {
                        $data = array(
                            'photo_pro_id' => $produto_id,
                            'photo_path' => $fotos_produtos[$i],
                        );
                        $this->core_model->insert('products_photos', $data);
                    }
                }

                redirect('restrict/products');
            } else { //ACONTECEU ERROS DE VALIDAÇÃO
                $data = array(
                    'titulo' => 'Cadastrar produto',
                    'styles' => array(
                        'jquery-upload-file/css/uploadfile.css',
                    ),
                    'scripts' => array(
                        'jquery-upload-file/js/jquery.uploadfile.min.js',
                        'sweetalert/sweetalert2.all.min.js',
                        'jquery-upload-file/js/produtos.js',
                        'mask/jquery.mask.min.js',
                        'mask/custom.js',
                    ),
                    'fotos_produto' => $this->core_model->get_all('products_photos', array('photo_pro_id' => $pro_id)),
                    'categorias' => $this->core_model->get_all('categories', array('categorie_active' => 1)),
                    'marcas' => $this->core_model->get_all('brands', array('brand_active' => 1)),
                    'codigo_gerado' => $this->core_model->generate_unique_code('products', 'numeric', 8, 'pro_code'),
                );

                $this->load->view('restrict/layout/header', $data);
                $this->load->view('restrict/products/core');
                $this->load->view('restrict/layout/footer');
            }
        } else { //Se veio um id produto da view index, estamos EDITANDO um produto já existente
            if (!$product = $this->produtos_model->get_by_product($pro_id)) { //esse id que veio existe? Com a negaçao aqui nao existe
                $this->session->set_flashdata('erro', 'Produto nao encontrado');
                redirect('restrita/produtos');
            } else { //se existe, EDITA de fato o produto
                //Validaçoes
                $this->form_validation->set_rules('pro_name', 'Nome do produto', 'trim|required|min_length[4]|max_length[240]|callback_valida_nome_produto');
                $this->form_validation->set_rules('pro_categ_id', 'Categoria do Produto', 'trim|required');
                $this->form_validation->set_rules('pro_brand_id', 'Marca do produto', 'trim|required');
                $this->form_validation->set_rules('pro_value', 'Valor de venda do produto', 'trim|required');
                $this->form_validation->set_rules('pro_qtd_stock', 'Quantidade em estoque', 'trim|required|integer');
                $this->form_validation->set_rules('pro_description', 'Descriçao do produto', 'trim|required|min_length[10]|max_length[5000]');
                $this->form_validation->set_rules('pro_model', 'modelo do produto', 'trim|min_length[2]|max_length[180]');
                $this->form_validation->set_rules('pro_peso', 'peso do Produto', 'trim|required');
                $this->form_validation->set_rules('pro_largura', 'largura do produto', 'trim|required');
                $this->form_validation->set_rules('pro_altura', 'altura do produto', 'trim|required');
                $this->form_validation->set_rules('pro_comprimento', 'comprimento do produto', 'trim|required|integer');
                if ($this->form_validation->run()) {
                    $data = elements(
                        array(
                            'pro_name',
                            'pro_categ_id',
                            'pro_brand_id',
                            'pro_value',
                            'pro_destaque',
                            'pro_control_stock',
                            'pro_active',
                            'pro_qtd_stock',
                            'pro_description',
                            'pro_model',
                            'pro_peso',
                            'pro_largura',
                            'pro_altura',
                            'pro_comprimento',
                            'content_package',
                            'peso_pro_embalagem',
                            'pro_peso_embalagem',

                        ),
                        $this->input->post()
                    );
                    $data['pro_value'] = str_replace(',', '', $data['pro_value']);
                    $data['pro_meta_link'] = url_amigavel($data['pro_name']); //CRIA O META LINK COM BASE NO NOME PASSADO
                    $data = html_escape($data);
                    $this->core_model->update('products', $data, array('pro_id' => $pro_id)); //FAZ O UPDATE NA TABELA
                    $this->core_model->delete('products_photos', array('photo_pro_id' => $pro_id));
                    $fotos_produtos = $this->input->post('fotos_produtos');
                    if ($fotos_produtos) {
                        $total_fotos = @count($fotos_produtos);
                        for ($i = 0; $i < $total_fotos; $i++) {
                            $data = array(
                                'photo_pro_id' => $pro_id,
                                'photo_path' => $fotos_produtos[$i],
                            );

                            $this->core_model->insert('products_photos', $data);
                        }
                    }
                    redirect('restrict/products');
                } else { //ACONTECEU ERROS DE VALIDAÇÃO
                    $data = array(
                        'titulo' => 'Editar produto',
                        'styles' => array(
                            'jquery-upload-file/css/uploadfile.css',
                        ),
                        'scripts' => array(
                            'jquery-upload-file/js/jquery.uploadfile.min.js',
                            'sweetalert/sweetalert2.all.min.js',
                            'jquery-upload-file/js/produtos.js',
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',
                        ),
                        'produto' => $product,
                        'fotos_produto' => $this->core_model->get_all('products_photos', array('photo_pro_id' => $pro_id)),
                        'categorias' => $this->core_model->get_all('categories', array('categorie_active' => 1)),
                        'marcas' => $this->core_model->get_all('brands', array('brand_active' => 1)),
                        'codigo_gerado' => $this->core_model->generate_unique_code('products', 'numeric', 8, 'pro_code'),
                    );

                    $this->load->view('restrict/layout/header', $data);
                    $this->load->view('restrict/products/core');
                    $this->load->view('restrict/layout/footer');
                }
            }
        }
    }
    public function datasheet($pro_id = NULL)
    { //Código para base de uma ficha técnica especifica de cada produto
        $pro_id = (int)$pro_id;
        if (!$pro_id) { //Se nao veio um produto da view index, estamos CADASTRANDO um novo produto, a exclamacao ! significa negacao no php
            $this->form_validation->set_rules('pro_model', 'modelo do produto', 'trim|min_length[2]|max_length[180]');
            $this->form_validation->set_rules('pro_peso', 'peso do Produto', 'trim|required');
            $this->form_validation->set_rules('pro_largura', 'largura do produto', 'trim|required');
            $this->form_validation->set_rules('pro_altura', 'altura do produto', 'trim|required');
            $this->form_validation->set_rules('pro_comprimento', 'comprimento do produto', 'trim|required|integer');
            if ($this->form_validation->run()) {
                $data = elements(
                    array(
                        'pro_model',
                        'pro_peso',
                        'pro_largura',
                        'pro_altura',
                        'pro_comprimento',
                        'peso_pro_embalagem',
                        'pro_peso_embalagem',
                    ),
                    $this->input->post()
                );
                $data = html_escape($data);
                $this->core_model->insert('datasheets', $data); //FAZ O INSERT NA TABELA
                redirect('restrita/produtos');
            } else { //ACONTECEU ERROS DE VALIDAÇÃO
                $data = array(
                    'titulo' => 'Editar produto',
                    'styles' => array(
                        'jquery-upload-file/css/uploadfile.css',
                    ),
                    'scripts' => array(
                        'jquery-upload-file/js/jquery.uploadfile.min.js',
                        'sweetalert/sweetalert2.all.min.js',
                        'jquery-upload-file/js/produtos.js',
                        'mask/jquery.mask.min.js',
                        'mask/custom.js',
                    ),
                    'fotos_produto' => $this->core_model->get_all('products_photos', array('photo_pro_id' => $pro_id)),
                    'categorias' => $this->core_model->get_all('categories', array('categorie_active' => 1)),
                    'marcas' => $this->core_model->get_all('brands', array('brand_active' => 1)),
                    'codigo_gerado' => $this->core_model->generate_unique_code('products', 'numeric', 8, 'pro_code'),
                );

                $this->load->view('restrita/layout/header', $data);
                $this->load->view('restrita/produtos/core');
                $this->load->view('restrita/layout/footer');
            }
        } else { //Se veio um id produto da view index, estamos EDITANDO um produto já existente
            if (!$product = $this->produtos_model->get_by_id($pro_id)) { //esse id que veio existe? Com a negaçao aqui nao existe
                $this->session->set_flashdata('erro', 'Produto nao encontrado');
                redirect('restrita/produtos');
            } else { //se existe, EDITA de fato o produto
                //Validaçoes
                $this->form_validation->set_rules('pro_model', 'modelo do produto', 'trim|min_length[2]|max_length[180]');
                $this->form_validation->set_rules('pro_peso', 'peso do Produto', 'trim|required');
                $this->form_validation->set_rules('pro_largura', 'largura do produto', 'trim|required');
                $this->form_validation->set_rules('pro_altura', 'altura do produto', 'trim|required');
                $this->form_validation->set_rules('pro_comprimento', 'comprimento do produto', 'trim|required|integer');
                if ($this->form_validation->run()) {
                    $data = elements(
                        array(
                            'pro_model',
                            'pro_peso',
                            'pro_largura',
                            'pro_altura',
                            'pro_comprimento',
                            'peso_pro_embalagem',
                            'pro_peso_embalagem',
                        ),
                        $this->input->post()
                    );
                    $data = html_escape($data);
                    $this->core_model->update('datasheets', $data, array('pro_id' => $pro_id)); //FAZ O UPDATE NA TABELA
                    redirect('restrita/produtos');
                } else { //ACONTECEU ERROS DE VALIDAÇÃO
                    $data = array(
                        'titulo' => 'Editar produto',
                        'styles' => array(
                            'jquery-upload-file/css/uploadfile.css',
                        ),
                        'scripts' => array(
                            'jquery-upload-file/js/jquery.uploadfile.min.js',
                            'sweetalert/sweetalert2.all.min.js',
                            'jquery-upload-file/js/produtos.js',
                            'mask/jquery.mask.min.js',
                            'mask/custom.js',
                        ),
                        'produto' => $product,
                        'fotos_produto' => $this->core_model->get_all('products_photos', array('photo_pro_id' => $pro_id)),
                        'categorias' => $this->core_model->get_all('categories', array('categorie_active' => 1)),
                        'marcas' => $this->core_model->get_all('brands', array('brand_active' => 1)),
                        'codigo_gerado' => $this->core_model->generate_unique_code('products', 'numeric', 8, 'pro_code'),
                    );

                    $this->load->view('restrita/layout/header', $data);
                    $this->load->view('restrita/produtos/core');
                    $this->load->view('restrita/layout/footer');
                }
            }
        }
    }
    public function valida_nome_produto($produto_nome)
    {
        $produto_id = (int)$this->input->post('produto_id');
        if (!$produto_id) {
            //se nao existe um id, cadastra
            if ($this->core_model->get_by_id('produtos', array('produto_nome' => $produto_nome))) {
                $this->form_validation->set_message('valida_nome_produto', 'Esse nome de produto já existe.');
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            //se existe um id, edita ele mesmo
            if ($this->core_model->get_by_id('produtos', array('produto_nome' => $produto_nome, 'produto_id != ' => $produto_id))) {
                $this->form_validation->set_message('valida_nome_produto', 'Esse nome de produto já existe.');
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    public function upload()
    {
        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 2048; //MAX 2MB
        $config['max_width'] = 1000;
        $config['max_height'] = 1000;
        $config['encrypt_name'] = TRUE;
        $config['max_filename'] = 200;
        $config['file_ext_tolower'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('foto_produto')) {
            $data = array(
                'uploaded_data' => $this->upload->data(),
                'mensagem' => 'Imagem enviada com sucesso!',
                'photo_path' => $this->upload->data('file_name'),
                'erro' => 0
            );
            //resize image configuration
            $config['image_library'] = 'gd2';
            $config['source_image'] = './uploads/products/' . $this->upload->data('file_name');
            $config['new_image'] = './uploads/products/small/' . $this->upload->data('file_name');
            $config['width'] = 300;
            $config['height'] = 300;
            $this->load->library('image_lib', $config); //chama a biblioteca
            //faz o resize
            if (!$this->image_lib->resize()) {
                $data['erro'] = $this->image_lib->display_errors();
            }
        } else {
            $data = array(
                'mensagem' => $this->upload->display_errors(),
                'erro' => 5,
            );
        }
        echo json_encode($data);
    }
    public function delete($produto_id = NULL)
    {
        $produto_id = (int)$produto_id;
        if (!$produto_id || !$this->core_model->get_by_id('products', array('pro_id' => $produto_id))) {
            $this->session->set_flashdata('erro', 'Esse produto nao foi encontrado');
            redirect('restrict/products');
        }
        if ($this->core_model->get_by_id('products', array('pro_id' => $produto_id, 'pro_active' => 1))) {
            $this->session->set_flashdata('erro', 'Nao é permitido excluir um produto ativo');
            redirect('restrict/products');
        }
        $fotos_produto = $this->core_model->get_all('photos_products', array('photo_pro_id' => $produto_id));
        $this->core_model->delete('products', array('pro_id' => $produto_id));
        if ($fotos_produto) {
            foreach ($fotos_produto as $foto) {
                $foto_grande = FCPATH . 'uploads/products/' . $foto->photo_path;
                $foto_pequena = FCPATH . 'uploads/products/small/' . $foto->photo_path;
                if (file_exists($foto_grande) && file_exists($foto_pequena)) {
                    unlink($foto_grande);
                    unlink($foto_pequena);
                }
            }
        }
        redirect('restrict/products');
    }
}
