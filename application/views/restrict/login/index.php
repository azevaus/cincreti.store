<section class="section">
    <div class="container mt-5">
        <div class="row">

            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="text-center"><?php echo $titulo ?></h4>
                    </div>
                    <div class="card-body">
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
                        <?php
                        $atributos = array(
                            'class' => 'needs-validation',
                        );
                        ?>
                        <?php echo form_open('restrita/login/auth', $atributos) ?>
                        <div class="form-group">
                            <label for="email">Seu E-mail</label>
                            <input type="email" class="form-control" name="email" tabindex="1" required autofocus>
                        </div>
                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Sua Senha</label>
                            </div>
                            <input type="password" class="form-control" name="password" tabindex="2" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                <label class="custom-control-label" for="remember-me">Manter conectado</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark btn-lg btn-block" tabindex="4">
                                Login
                            </button>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>