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
                    if (isset($marcas)) {
                        $brand_id = $marcas->brand_id;
                    } else {
                        $brand_id = '';
                    }
                    ?>
                    <?php echo form_open('restrita/marcas/core/' . $brand_id, $atributos); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Nome da marca</label>
                                    <input type="text" name="brand_name" value="<?php echo (isset($marcas) ? $marcas->brand_name : set_value('brand_name')) ?>" class="form-control">
                                    <?php echo form_error('brand_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Ativa</label>
                                    <select id="inputState" name="brand_active" class="form-control">
                                        <?php if (isset($marcas)) : ?>
                                            <option value="1" <?php echo ($marcas->brand_active == 1 ? 'selected' : ''); ?>>Sim</option>
                                            <option value="0" <?php echo ($marcas->brand_active == 0 ? 'selected' : ''); ?>>Nao</option>
                                        <?php else : ?>
                                            <option value="1">Sim</option>
                                            <option value="0">Nao</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <?php if (isset($marcas)) : ?>
                                    <div class="form-group col-md-4">
                                        <label>Metalink da marca</label>
                                        <input type="text" name="brand_meta_link" value="<?php echo $marcas->brand_meta_link; ?>" readonly="" class="form-control border-0">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="form-row">
                                <?php if (isset($marcas)) : ?>
                                    <input type="hidden" name="brand_id" value="<?php echo $brand_id ?>">
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                                <a href="<?php echo base_url('restrita/marcas'); ?>" class="btn btn-ligth">Voltar</a>
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