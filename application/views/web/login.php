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
            <div class="col-sm-10 col-md-12 col-xs-12 col-lg-6 mb-30">     
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
                <?php echo form_open('login/auth');?>
                    <div class="login-form">
                        <h4 class="login-title text-center">Login</h4>
                        <div class="row">
                            <div class="col-md-12 col-12 mb-20">
                                <label>Seu e-mail*</label>
                                <input class="mb-0" name="email" type="email" required>
                            </div>
                            <div class="col-12 mb-20">
                                <label>Senha*</label>
                                <input class="mb-0" name="password" type="password" required>
                            </div>
                            <div class="col-md-7">
                                <div class="check-box d-inline-block ml-0 ml-md-2 mt-10">
                                    <input type="checkbox" name="remember" id="remember_me">
                                    <label for="remember_me">Manter conectado?</label>
                                </div>
                            </div>
                            <div class="col-md-5 mt-10 mb-20 text-left text-md-right">
                                <a href="<?php echo base_url('perfil')?>"> Ainda nao tem conta?</a>
                            </div>
                            <input type="hidden" name="login" value="login">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <button type="submit" class="register-button mt-0">Entrar</button>
                            </div>
                        </div>
                    </div>
                <?php form_close();?>
            </div>
            
        </div>
    </div>
</div>