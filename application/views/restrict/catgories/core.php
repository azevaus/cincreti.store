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
                    if (isset($categorias)) {
                        $categorie_id = $categorias->categorie_id;
                    } else {
                        $categorie_id = '';
                    }
                    ?>
                    <?php echo form_open('restrita/categorias/core/' . $categorie_id, $atributos); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4"> <!-- Nome -->
                                    <label>Nome da Categoria</label>
                                    <input type="text" name="categorie_name" value="<?php echo (isset($categorias) ? $categorias->categorie_name : set_value('categorie_name')) ?>" class="form-control">
                                    <?php echo form_error('categorie_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2"> <!-- ativa? -->
                                    <label for="inputState">Ativa</label>
                                    <select id="inputState" name="categorie_active" class="form-control">
                                        <?php if (isset($categorias)) : ?>
                                            <option value="1" <?php echo ($categorias->categorie_active == 1 ? 'selected' : ''); ?>>Sim</option>
                                            <option value="0" <?php echo ($categorias->categorie_active == 0 ? 'selected' : ''); ?>>Nao</option>
                                        <?php else : ?>
                                            <option value="1">Sim</option>
                                            <option value="0">Nao</option>
                                        <?php endif ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputState">Categoria Master</label> <!-- Categoria master -->
                                    <select id="inputState" name="master_id" class="form-control">
                                        <?php foreach ($masters as $master) : ?>
                                            <?php if (isset($categorias)) : ?>
                                                <option value="<?php echo $master->master_id ?>" <?php echo ($master->master_id == $categorias->master_id ? 'selected' : ''); ?>><?php echo $master->master_name; ?></option>
                                            <?php else : ?>
                                                <option value="<?php echo $master->master_id ?>"><?php echo $master->master_name; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php if (isset($categorias)) : ?>
                                    <div class="form-group col-md-4">
                                        <label>Metalink da Categoria</label>
                                        <input type="text" name="categorie_meta_link" value="<?php echo $categorias->categorie_meta_link; ?>" readonly="" class="form-control border-0">
                                    </div>
                                <?php endif; ?>

                            </div>
                            <div class="form-row">
                                <?php if (isset($categorias)) : ?>
                                    <input type="hidden" name="categorie_id" value="<?php echo $categorie_id ?>">
                                <?php endif; ?>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                                <a href="<?php echo base_url('restrita/categorias'); ?>" class="btn btn-ligth">Voltar</a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
    </section>
</div>
<?php $this->load->view('restrita/layout/sidebar_settings'); ?>