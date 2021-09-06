<?php $this->load->view('restrict/layout/navbar'); ?>
<?php $this->load->view('restrict/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php
                    $atributos = array(
                        'name' => 'form_core',
                    );
                    if (isset($produto)) {
                        $pro_id = $produto->pro_id;
                    } else {
                        $pro_id = '';
                    }
                    
                    ?>
                    <!-- INICIO DO FORMULÁRIO DE CADASTRO DO PRODUTO-->
                    <?php echo form_open('restrict/products/core/' . $pro_id, $atributos); ?>
                    <div class="card" style="display: block;">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" onclick="Produto()" data-bs-target="#dados" type="button" role="tab" aria-controls="home" aria-selected="true">Dados do produto</a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" onclick="TecnicaGeral()" data-bs-target="#tecnica" type="button" role="tab" aria-controls="profile">Ficha técnica Geral</a>
                            </li>
                            <li class="nav-item " role="presentation">
                                <a class="nav-link" id="ficha-tab" data-bs-toggle="tab" onclick="TecnicaEspecifica()" data-bs-target="#tecnica" type="button" role="tab" aria-controls="profile">FT Especifica</a>
                            </li>
                        </ul>
                        <div class="card-header">
                            <h4 id="titulo"><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body" id="dados" role="tabpanel" aria-labelledby="home-tab">
                            <?php if (isset($produto)) : ?>  <!-- Verificando se meta_link ja existe, se existe esta editando e ele aparece-->
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>Meta Link do produto</label>
                                        <p class="text-info"><?php echo $produto->pro_meta_link; ?> </p>
                                    </div>
                                </div>
                            <?php endif; ?>  <!-- Se nao existe esta cadastrando, se existe esta editando-->
                            <div class="form-row"> <!-- Codigo, nome, preço, categorias e marcas-->
                                <div class="form-group col-md-2"><!-- Codigo-->                                    
                                    <label>Código do produto</label>
                                    <input type="text" name="pro_code" value="<?php echo (isset($produto) ? $produto->pro_code : $codigo_gerado) ?>" class="form-control border-0" readonly="">
                                    <?php echo form_error('pro_code', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-4"><!-- Nome-->                                    
                                    <label>Nome do produto</label>
                                    <input type="text" name="pro_name" value="<?php echo (isset($produto) ? $produto->pro_name : set_value('pro_name')) ?>" class="form-control">
                                    <?php echo form_error('pro_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Preço de venda-->                                    
                                    <label>Valor de venda</label>
                                    <input type="text" name="pro_value" value="<?php echo (isset($produto) ? $produto->pro_value : set_value('pro_value')) ?>" class="form-control money2">
                                    <?php echo form_error('pro_value', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Categorias -->                                    
                                    <label>Categoria</label>
                                    <select name="pro_categ_id" class="form-control">
                                        <option value="">Escolha</option>
                                        <?php foreach ($categorias as $categoria) : ?>
                                            <?php if (isset($produto)) : ?>
                                                <option value="<?php echo $categoria->categorie_id ?>"<?php echo ($categoria->categorie_id == $produto->pro_categ_id ? 'selected' : ''); ?>><?php echo $categoria->categorie_name; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $categoria->categorie_id ?>"><?php echo $categoria->categorie_name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('pro_categ_id', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Marcas-->                                    
                                    <label>Marca</label>
                                    <select name="pro_brand_id" class="form-control">
                                        <option value="">Escolha</option>
                                        <?php foreach ($marcas as $marca) : ?>
                                            <?php if (isset($produto)) : ?>
                                                <option value="<?php echo $marca->brand_id ?>" <?php echo ($marca->brand_id == $produto->pro_brand_id ? 'selected' : ''); ?>><?php echo $marca->brand_name; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $marca->brand_id ?>"><?php echo $marca->brand_name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php echo form_error('pro_brand_id', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"><!-- Produto ativo?-->                                    
                                    <label>Ativo</label>
                                    <select name="pro_active" class="form-control">
                                        <?php if (isset($produto)) : ?>
                                            <option value="1" <?php echo ($produto->pro_active == 1 ? 'selected' : ''); ?>>Sim</option>
                                            <option value="0" <?php echo ($produto->pro_active == 0 ? 'selected' : ''); ?>>Nao</option>
                                        <?php else : ?>
                                            <option value="1">Sim</option>
                                            <option value="0">Nao</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2"><!-- Produto em destaque?-->                                    
                                    <label>Produto em detaque</label>
                                    <select name="pro_destaque" class="form-control">
                                        <?php if (isset($produto)) : ?>
                                            <option value="1" <?php echo ($produto->pro_destaque == 1 ? 'selected' : ''); ?>>Sim</option>
                                            <option value="0" <?php echo ($produto->pro_destaque == 0 ? 'selected' : ''); ?>>Nao</option>
                                        <?php else : ?>
                                            <option value="1">Sim</option>
                                            <option value="0">Nao</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2"><!-- Controlar estoque?-->                                    
                                    <label>Controlar estoque?</label>
                                    <select name="pro_control_stock" class="form-control">
                                        <?php if (isset($produto)) : ?>
                                            <option value="1" <?php echo ($produto->pro_control_stock == 1 ? 'selected' : ''); ?>>Sim</option>
                                            <option value="0" <?php echo ($produto->pro_control_stock == 0 ? 'selected' : ''); ?>>Nao</option>
                                        <?php else : ?>
                                            <option value="1">Sim</option>
                                            <option value="0">Nao</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2"><!-- Quantidade em estoque-->                                    
                                    <label>Quantidade em estoque</label>
                                    <input type="number" name="pro_qtd_stock" value="<?php echo (isset($produto) ? $produto->pro_qtd_stock : set_value('pro_qtd_stock')) ?>" class="form-control">
                                    <?php echo form_error('pro_qtd_stock', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8"><!-- Descriçao do produto-->                                    
                                    <label>Descriçao do produto</label>
                                    <textarea class="form-control" name="pro_description" row="5"><?php echo (isset($produto) ? $produto->pro_description : set_value('pro_description')) ?></textarea>
                                    <?php echo form_error('pro_description', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8"><!-- Imagens do produto-->                                    
                                    <label>Imagens do produto</label>
                                    <div id="fileuploader"> 
                                    
                                    </div>
                                    <div id="erro_uploaded" class="text-danger">

                                    </div>
                                    <?php echo form_error('fotos_produto', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <?php if (isset($produto)) : ?>
                                        <div id="uploaded_image" class="text-danger">
                                            <?php foreach ($fotos_produto as $foto) : ?>
                                                <ul style="list-style:none; display:inline-block">
                                                    <li>
                                                        <img src="<?php echo base_url('uploads/products/' . $foto->photo_path); ?>" class="img-thumbnail mr-1 mb-2">
                                                        <input type="hidden" name="fotos_produtos[]" value="<?php echo $foto->photo_path;?>">
                                                        <a href="javascript:(void)" class="btn btn-ligth d-block btn-icon mx-auto mb-30 btn-remove"><i class="fas fa-times"></i></a>
                                                    </li>
                                                </ul>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else : ?>
                                        <div id="uploaded_image" class="text-danger">

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <?php if (isset($produto)) : ?>
                                    <input type="hidden" name="pro_id" value="<?php echo $pro_id ?>">
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                                <a href="<?php echo base_url('restrict/products'); ?>" class="btn btn-ligth">Voltar</a>
                            </div>
                        </div>
                        <!-- FIM DO FORMULÁRIO DE CADASTRO DO PRODUTO-->
                        <!-- INICIO DA FICHA TECNICA PADRAO DO PRODUTO-->
                        <div class="card-body" style="display: none;" id="tecnica" role="tabpanel" aria-labelledby="profile-tab" style="position:absolute; top: 100px; width:100%;">
                            <div class="form-row">
                                <div class="form-group col-md-2"><!-- Modelo do produto -->                                    
                                    <label>Modelo do Produto</label>
                                    <input type="text" name="pro_model" value="<?php echo (isset($produto) ? $produto->pro_model : set_value('pro_model')) ?>" class="form-control">
                                    <?php echo form_error('pro_model', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Peso do produto -->                                    
                                    <label>Peso aproximado (gm ou kg)</label>
                                    <input type="text" name="pro_peso" value="<?php echo (isset($produto) ? $produto->pro_peso : set_value('pro_peso')) ?>" class="form-control">
                                    <?php echo form_error('pro_peso', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Altura do produto -->                                    
                                    <label>Altura aproximada (mm ou cm)</label>
                                    <input type="text" name="pro_altura" value="<?php echo (isset($produto) ? $produto->pro_altura : set_value('pro_altura')) ?>" class="form-control">
                                    <?php echo form_error('pro_altura', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Largura do produto -->                                    
                                    <label>Largura aproximada (mm ou cm)</label>
                                    <input type="text" name="pro_largura" value="<?php echo (isset($produto) ? $produto->pro_largura : set_value('pro_largura')) ?>" class="form-control">
                                    <?php echo form_error('pro_largura', '<span class="text-danger">', '</span>'); ?>
                                </div>                               
                                <div class="form-group col-md-2"></div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Conteúdo da embalagem</label>
                                    <input type="text" name="content_package" value="<?php echo (isset($produto) ? $produto->content_package : set_value('content_package')) ?>" class="form-control">
                                    <?php echo form_error('content_package', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-2"><!-- Comprimento do produto -->                                    
                                    <label>Comprimento aproximado (mm ou cm)</label>
                                    <input type="text" name="pro_comprimento" value="<?php echo (isset($produto) ? $produto->pro_comprimento : set_value('pro_comprimento')) ?>" class="form-control">
                                    <?php echo form_error('pro_comprimento', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Peso aproximado da embalagem (ml ou kg)</label> <!-- Peso aproximado da embalagem -->
                                    <input type="text" name="pro_peso_embalagem" value="<?php echo (isset($produto) ? $produto->pro_peso_embalagem : set_value('pro_peso_embalagem')) ?>" class="form-control">
                                    <?php echo form_error('pro_peso_embalagem', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"><!-- Peso aproximado da embalagem com o produto -->                                    
                                    <label>Peso da embalagem c/ produto (ml ou kg)</label>
                                    <input type="text" name="peso_pro_embalagem" value="<?php echo (isset($produto) ? $produto->peso_pro_embalagem : set_value('peso_pro_embalagem')) ?>" class="form-control">
                                    <?php echo form_error('peso_pro_embalagem', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            
                        </div>
                        <?php echo form_close(); ?>
                        <!-- FIM DA FICHA TECNICA PADRAO DO PRODUTO-->
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    $('#home-tab').click(function Produto() {
        $('#home-tab').addClass('active');
        $('#profile-tab').removeClass('active');
        $('#ficha-tab').removeClass('active');
        $('#tecnica_especifica').css({
            display: 'none'
        });
        $('#titulo').text('Editar produto');
        $('#tecnica').css({
            display: 'none'
        });
        $('#dados').css({
            display: 'block'
        });
        /*$("#tecnica").addClass('fade').removeClass('show');*/
    });
    $('#profile-tab').click(function TecnicaGeral() {
        $('#home-tab').removeClass('active');
        $('#ficha-tab').removeClass('active');
        $('#dados').css({
            display: 'none'
        });
        $('#profile-tab').addClass('active');
        $('#tecnica_especifica').css({
            display: 'none'
        });
        $('#titulo').text('Ficha técnica');
        $('#tecnica').css({
            display: 'block'
        });
        /*$("#tecnica").removeClass('fade').addClass('show');*/
    });
    $('#ficha-tab').click(function TecnicaEspecifica() {
        $('#home-tab').removeClass('active');
        $('#dados').css({
            display: 'none'
        });
        $('#profile-tab').removeClass('active');
        $('#tecnica').css({
            display: 'none'
        });
        $('#ficha-tab').addClass('active');
        $('#titulo').text('Ficha técnica especifica');
        $('#tecnica_especifica').css({
            display: 'block'
        });
    });
</script>
<?php $this->load->view('restrict/layout/sidebar_settings'); ?>