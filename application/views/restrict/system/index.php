<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php echo form_open('restrita/sistema/'); ?>
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
                                <div class="form-group col-md-3">
                                    <label>Razao Social</label>
                                    <input type="text" name="sistema_razao_social" value="<?php echo (isset($sistema) ? $sistema->sistema_razao_social : set_value('sistema_razao_social')) ?>" class="form-control">
                                    <?php echo form_error('sistema_razao_social', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Nome fantasia</label>
                                    <input type="text" name="sistema_nome_fantasia" value="<?php echo (isset($sistema) ? $sistema->sistema_nome_fantasia : set_value('sistema_nome_fantasia')) ?>" class="form-control">
                                    <?php echo form_error('sistema_nome_fantasia', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>CNPJ</label>
                                    <input type="text" name="sistema_cnpj" value="<?php echo (isset($sistema) ? $sistema->sistema_cnpj : set_value('sistema_cnpj')) ?>" class="form-control">
                                    <?php echo form_error('sistema_cnpj', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>IE</label>
                                    <input type="text" name="sistema_ie" value="<?php echo (isset($sistema) ? $sistema->sistema_ie : set_value('sistema_ie')) ?>" class="form-control">
                                    <?php echo form_error('sistema_ie', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>CEP</label>
                                    <input type="text" name="sistema_cep" value="<?php echo (isset($sistema) ? $sistema->sistema_cep : set_value('sistema_cep')) ?>" class="form-control cep">
                                    <?php echo form_error('sistema_cep', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Endereço</label>
                                    <input type="text" name="sistema_endereco" value="<?php echo (isset($sistema) ? $sistema->sistema_endereco : set_value('sistema_endereco')) ?>" class="form-control">
                                    <?php echo form_error('sistema_endereco', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Numero</label>
                                    <input type="text" name="sistema_numero" value="<?php echo (isset($sistema) ? $sistema->sistema_numero : set_value('sistema_numero')) ?>" class="form-control">
                                    <?php echo form_error('sistema_numero', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Cidade</label>
                                    <input type="text" name="sistema_cidade" value="<?php echo (isset($sistema) ? $sistema->sistema_cidade : set_value('sistema_cidade')) ?>" class="form-control">
                                    <?php echo form_error('sistema_cidade', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>UF</label>
                                    <input type="text" name="sistema_estado" value="<?php echo (isset($sistema) ? $sistema->sistema_estado : set_value('sistema_estado')) ?>" class="form-control uf">
                                    <?php echo form_error('sistema_estado', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Telefone fixo</label>
                                    <input type="text" name="sistema_telefone_fixo" value="<?php echo (isset($sistema) ? $sistema->sistema_telefone_fixo : set_value('sistema_telefone_fixo')) ?>" class="form-control phone_with_ddd">
                                    <?php echo form_error('sistema_telefone_fixo', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Telefone móvel</label>
                                    <input type="text" name="sistema_telefone_movel" value="<?php echo (isset($sistema) ? $sistema->sistema_telefone_movel : set_value('sistema_telefone_movel')) ?>" class="form-control sp_celphones">
                                    <?php echo form_error('sistema_telefone_movel', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>E-mail de contato</label>
                                    <input type="email" name="sistema_email" value="<?php echo (isset($sistema) ? $sistema->sistema_email : set_value('sistema_email')) ?>" class="form-control">
                                    <?php echo form_error('sistema_email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>URL do site</label>
                                    <input type="url" name="sistema_site_url" value="<?php echo (isset($sistema) ? $sistema->sistema_site_url : set_value('sistema_site_url')) ?>" class="form-control">
                                    <?php echo form_error('sistema_site_url', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Quantidade de produtos em destaque</label>
                                    <input type="number" name="sistema_produtos_destaques" value="<?php echo (isset($sistema) ? $sistema->sistema_produtos_destaques : set_value('sistema_produtos_destaques')) ?>" class="form-control">
                                    <?php echo form_error('sistema_produtos_destaques', '<span class="text-danger">', '</span>'); ?>
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