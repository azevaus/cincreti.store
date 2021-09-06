<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php
                        $atributos = array(
                            'name' => 'form_core',
                        );
                        if (isset($banners)) {
                            $banner_id = $banners->banner_id;
                        } else {
                            $banner_id = '';
                        }
                    ?>
                    <?php echo form_open('restrita/banners/core/' . $banner_id, $atributos); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($banners)) : ?>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label>Meta Link do banner</label>
                                        <p class="text-info"><?php echo $banners->banner_meta_link; ?> </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-row">                                
                                <div class="form-group col-md-4">
                                    <label>Nome do banner</label>
                                    <input type="text" name="banner_nome" value="<?php echo (isset($banners) ? $banners->banner_nome : set_value('banner_nome')) ?>" class="form-control">
                                    <?php echo form_error('banner_nome', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Banner</label>
                                    <div id="fileuploader">
                                        
                                    </div>
                                    <div id="erro_uploaded" class="text-danger">
                                        
                                    </div>
                                    <?php echo form_error('banner_foto_caminho', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <?php if(isset($banners)):?>
                                        <div id="uploaded_image" class="text-danger" >
                                            <?php  foreach($foto_banner as $banner):?>
                                                <ul style="list-style:none; display:inline-block">
                                                    <li>
                                                        <img src="<?php echo base_url('uploads/banners/'.$banner->banner_foto_caminho);?>" class="img-thumbnail mr-1 mb-2">
                                                        <input type="hidden" name="fotos_banners[]" value="<?php echo $banner->banner_foto_caminho; ?>">
                                                        <a href="javascript:(void)" class="btn btn-ligth d-block btn-icon mx-auto mb-30 btn-remove"><i class="fas fa-times"></i></a>
                                                    </li>
                                                </ul>
                                            <?php endforeach;?>
                                        </div>
                                        <?php else:?>
                                            <div id="uploaded_image"  class="text-danger">

                                            </div>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="form-row">
                                <?php if (isset($banners)) : ?>
                                    <input type="hidden" name="banner_id" value="<?php echo $banner_id ?>">
                                <?php endif; ?>
                            </div>                            
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                                <a href="<?php echo base_url('restrita/banners'); ?>" class="btn btn-ligth">Voltar</a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('restrita/layout/sidebar_settings'); ?>