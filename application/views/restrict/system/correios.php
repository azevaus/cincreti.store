<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php echo form_open('restrita/sistema/correios'); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if ($message = $this->session->flashdata('sucesso')) : ?>
                                <div class="alert alert-success alert-dismissible alert-has-icon">
                                    <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Perfeito!</div>
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        <?php echo $message ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($message = $this->session->flashdata('erro')) : ?>
                                <div class="alert alert-danger alert-dismissible alert-has-icon">
                                    <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                                    <div class="alert-body">
                                        <div class="alert-title">Atençao</div>
                                        <button class="close" data-dismiss="alert">
                                            <span>&times;</span>
                                        </button>
                                        <?php echo $message ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>CEP de origem</label>
                                    <input type="text" name="config_cep_origem" value="<?php echo (isset($correio) ? $correio->config_cep_origem : set_value('config_cep_origem')) ?>" class="form-control cep">
                                    <?php echo form_error('config_cep_origem', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Codigo de serviço PAC</label>
                                    <input type="text" name="config_codigo_pac" value="<?php echo (isset($correio) ? $correio->config_codigo_pac : set_value('config_codigo_pac')) ?>" class="form-control codigo_servico_correios">
                                    <?php echo form_error('config_codigo_pac', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Codigo de serviço SEDEX</label>
                                    <input type="text" name="config_codigo_sedex" value="<?php echo (isset($correio) ? $correio->config_codigo_sedex : set_value('config_codigo_sedex')) ?>" class="form-control codigo_servico_correios">
                                    <?php echo form_error('config_codigo_sedex', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Valor a ser somado ao frete - R$</label>
                                    <input type="text" name="config_somar_frete" value="<?php echo (isset($correio) ? $correio->config_somar_frete : set_value('config_somar_frete')) ?>" class="form-control money2">
                                    <?php echo form_error('config_somar_frete', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Valor declarado - R$</label>
                                    <input type="text" name="config_valor_declarado" value="<?php echo (isset($correio) ? $correio->config_valor_declarado : set_value('config_valor_declarado')) ?>" class="form-control money2">
                                    <?php echo form_error('config_valor_declarado', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('restrita/layout/sidebar_settings'); ?>