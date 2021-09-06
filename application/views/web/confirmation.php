<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/')?>">Home</a></li>
                <li class="active"><a href="<?php echo $titulo;?>"><?php echo $titulo;?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="page-section mb-60">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-md-12 col-xs-12 col-lg-3 mb-30"> </div>
            <div class="col-sm-10 col-md-12 col-xs-12 col-lg-6" style="margin-bottom:157px;">     
            <?php if ($message = $this->session->flashdata('sucesso')) : ?>
                    <div class="alert alert-success bg-success text-white alert-dismissible alert-has-icon">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                            </button>
                            <?php echo $message ?>
                        </div>
                    </div>
                <?php endif; ?>           
                <?php if ($message = $this->session->flashdata('erro')) : ?>
                    <div class="alert alert-danger bg-danger text-white alert-dismissible alert-has-icon">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                            <span>&times;</span>
                            </button>
                            <?php echo $message ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Login Form s-->
                <?php echo form_open('confirmacao/confirmacao_email');?>
                    <div class="login-form">
                        <h4 class="login-title text-center">Confirmação de cadastro</h4>                        
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label> digite o codigo*</label>
                                <input class="mb-0" value="" name="codigo_digitado" type="text" required>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="hidden" name="client_id" value="<?php echo $this->session->userdata('last_id')?>">
                                <button type="submit" class="register-button mt-0">Confirmar</button>
                            </div>
                        </div>
                    </div>
                <?php form_close();?>
            </div>
            
        </div>
    </div>
</div>