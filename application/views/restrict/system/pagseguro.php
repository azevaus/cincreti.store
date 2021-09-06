<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php echo form_open('restrita/sistema/pagseguro'); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if ($message = $this->session->flashdata('sucesso')) : ?>
                                <div class="alert alert-success alert-dismissible alert-has-icon">
                   x                 <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
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
                                <div class="form-group col-md-4">
                                    <label>E-mail de acesso</label>
                                    <input type="email" name="config_email" value="<?php echo (isset($pagseguro) ? $pagseguro->config_email : set_value('config_email')) ?>" class="form-control ">
                                    <?php echo form_error('config_email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Token de acesso</label>
                                    <input type="text" name="config_token" value="<?php echo (isset($pagseguro) ? $pagseguro->config_token : set_value('config_token')) ?>" class="form-control">
                                    <?php echo form_error('config_token', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label >Ambiente</label>
                                    <select name="config_ambiente" class="form-control">
                                        <?php if (isset($pagseguro)) : ?>
                                            <option value="1" <?php echo ($pagseguro->config_ambiente == 1 ? 'selected' : ''); ?>>SandBox</option>
                                            <option value="0" <?php echo ($pagseguro->config_ambiente == 0 ? 'selected' : ''); ?>>Produçao</option>
                                        <?php else : ?>
                                            <option value="1">SandBox</option>
                                            <option value="0">Produçao</option>
                                        <?php endif ?>
                                    </select>
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