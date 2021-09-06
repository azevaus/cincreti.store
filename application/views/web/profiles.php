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
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12 mb-30">   
                <?php if ($message = $this->session->flashdata('sucesso')) : ?>
                    <div class="alert alert-success alert-dismissible alert-has-icon">
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
                <!-- Pefil Form s-->
                <?php echo form_open('perfil/index');?>
                    <div class="login-form">
                        <h4 class="login-title"><?php echo $titulo;?></h4>
                        <div class="form-group row">                            
                            <div class="form-group col-md-1">
                                    <input type="hidden" name="client_code" value="<?php echo $this->core_model->generate_unique_code('clients', 'numeric', 4, 'client_code') ?>" class="form-control border-0" readonly="">
                                    <?php echo form_error('client_code', '<span class="text-danger">', '</span>'); ?>
                                </div>
                            <div class="col-md-4 col-12 mb-20">
                                <label>Sobrenome <span class="required">*</span></label>
                                <input type="text" name="client_surname" value="<?php echo (isset($cliente) ? $cliente->client_surname : set_value('client_surname')) ?>" class="form-control mb-0">
                                <?php echo form_error('client_surname', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-3 col-12 mb-20">
                                <label>Nome <span class="required">*</span></label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_name : set_value('client_name')) ?>" name="client_name">
                                <?php echo form_error('client_name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-3 mb-20">
                                <label>Data de nascimento <span class="required">*</span></label>
                                <input type="date" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_birth : set_value('client_birth')) ?>" name="client_birth">
                                <?php echo form_error('client_birth', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>
                            <div class="col-md-3 mb-20">
                                <label>CPF <span class="required">*</span></label>
                                <input type="text" class="form-control cpf mb-0" value="<?php echo (isset($cliente) ? $cliente->client_cpf : set_value('client_cpf')) ?>" name="client_cpf">
                                <?php echo form_error('client_cpf', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-2 mb-20">
                                <label>RG</label>
                                <input type="text" class="form-control rg mb-0" value="<?php echo (isset($cliente) ? $cliente->client_rg : set_value('client_rg')) ?>" name="client_rg">
                                <?php echo form_error('client_rg', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-5 mb-20">
                                <label>Nome da mãe</label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_mother : set_value('client_mother')) ?>" name="client_mother">
                                <?php echo form_error('client_mother', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>
                            <div class="col-md-3 mb-20">
                                <label>Nome do pai</label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_dad : set_value('client_dad')) ?>" name="client_dad">
                                <?php echo form_error('client_dad', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-4 mb-20">
                                <label>E-mail <span class="required">*</span></label>
                                <input type="email" name="client_email" value="<?php echo (isset($cliente) ? $cliente->client_email : set_value('client_email')) ?>" class="form-control mb-0">
                                <?php echo form_error('client_email', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-3 mb-20">
                                <label>Telefone fixo</label>
                                <input type="text" name="client_phone" value="<?php echo (isset($cliente) ? $cliente->client_phone : set_value('client_phone')) ?>" class="form-control phone_with_ddd mb-0">
                                <?php echo form_error('client_phone', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>
                            <div class="col-md-3 mb-20">
                                <label>Celular <span class="required">*</span></label>
                                <input type="text" class="form-control sp_celphones mb-0" value="<?php echo (isset($cliente) ? $cliente->client_cell : set_value('client_cell')) ?>" name="client_cell">
                                <?php echo form_error('client_cell', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-4 mb-20">
                                <label>Senha <span class="required">*</span></label>
                                <input type="password" name="password" class="form-control mb-0">
                                <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-3 mb-20">
                                <label>Confirmar senha <span class="required">*</span></label>
                                <input type="password" class="form-control mb-0" name="confirma">
                                <?php echo form_error('confirma', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>
                            <div class="col-md-2 mb-20">
                                <label>CEP <span class="required">*</span></label>
                                <input type="text" class="form-control cep mb-0" value="<?php echo (isset($cliente) ? $cliente->client_state : set_value('client_state')) ?>" name="client_state">
                                <?php echo form_error('client_state', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-4 mb-20">
                                <label>Endereço <span class="required">*</span></label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_address : set_value('client_address')) ?>" name="client_address">
                                <?php echo form_error('client_address', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-2 mb-20">
                                <label>Número</label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_number : set_value('client_number')) ?>" name="client_number">
                                <?php echo form_error('client_number', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-2 mb-20">
                                <label>Bairro <span class="required">*</span></label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_district : set_value('client_district')) ?>" name="client_district">
                                <?php echo form_error('client_district', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>
                            <div class="col-md-3 mb-20">
                                <label>Complemtento</label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_reference : set_value('client_reference')) ?>" name="client_reference">
                                <?php echo form_error('client_reference', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-4 mb-20">
                                <label>Cidade <span class="required">*</span></label>
                                <input type="text" class="form-control mb-0" value="<?php echo (isset($cliente) ? $cliente->client_city : set_value('client_city')) ?>" name="client_city">
                                <?php echo form_error('client_city', '<span class="text-danger">', '</span>'); ?>
                            </div>
                            <div class="col-md-3 mb-20">
                                <label>Estado <span class="required">*</span></label>
                                <div class="country-select clearfix">                                    
                                    <?php if(isset($cliente)):?>
                                        <select class="" name="client_uf" style="width: 100%;background-color:transparent;border:1px solid #999999;border-radius:0;line-height:23px;padding: 10px 20px; font-size: 14px; color:#7a7a7a;margin-bottom:0px">
                                            <option value="">Escolha o estado</option>
                                            <option value="AC" <?php echo ($cliente->client_uf =="AC" ? 'selected':''); ?>>Acre</option>
                                            <option value="AL" <?php echo ($cliente->client_uf =="AL" ? 'selected':''); ?>>Alagoas</option>
                                            <option value="AP" <?php echo ($cliente->client_uf =="AP" ? 'selected':''); ?>>Amapá</option>
                                            <option value="AM" <?php echo ($cliente->client_uf =="AM" ? 'selected':''); ?>>Amazonas</option>
                                            <option value="BA" <?php echo ($cliente->client_uf =="BA" ? 'selected':''); ?>>Bahia</option>
                                            <option value="CE" <?php echo ($cliente->client_uf =="CE" ? 'selected':''); ?>>Ceará</option>
                                            <option value="DF" <?php echo ($cliente->client_uf =="DF" ? 'selected':''); ?>>Distrito Federal</option>
                                            <option value="ES" <?php echo ($cliente->client_uf =="ES" ? 'selected':''); ?>>Espírito Santo</option>
                                            <option value="GO" <?php echo ($cliente->client_uf =="GO" ? 'selected':''); ?>>Goiás</option>
                                            <option value="MA" <?php echo ($cliente->client_uf =="MA" ? 'selected':''); ?>>Maranhão</option>
                                            <option value="MT" <?php echo ($cliente->client_uf =="MT" ? 'selected':''); ?>>Mato Grosso</option>
                                            <option value="MS" <?php echo ($cliente->client_uf =="MS" ? 'selected':''); ?>>Mato Grosso do Sul</option>
                                            <option value="MG" <?php echo ($cliente->client_uf =="MG" ? 'selected':''); ?>>Minas Gerais</option>
                                            <option value="PA" <?php echo ($cliente->client_uf =="PA" ? 'selected':''); ?>>Pará</option>
                                            <option value="PB" <?php echo ($cliente->client_uf =="PB" ? 'selected':''); ?>>Paraíba</option>
                                            <option value="PR" <?php echo ($cliente->client_uf =="PR" ? 'selected':''); ?>>Paraná</option>
                                            <option value="PE" <?php echo ($cliente->client_uf =="PE" ? 'selected':''); ?>>Pernambuco</option>
                                            <option value="PI" <?php echo ($cliente->client_uf =="PI" ? 'selected':''); ?>>Piauí</option>
                                            <option value="RJ" <?php echo ($cliente->client_uf =="RJ" ? 'selected':''); ?>>Rio de Janeiro</option>
                                            <option value="RN" <?php echo ($cliente->client_uf =="RN" ? 'selected':''); ?>>Rio Grande do Norte</option>
                                            <option value="RS" <?php echo ($cliente->client_uf =="RS" ? 'selected':''); ?>>Rio Grande do Sul</option>
                                            <option value="RO" <?php echo ($cliente->client_uf =="RO" ? 'selected':''); ?>>Rondônia</option>
                                            <option value="RR" <?php echo ($cliente->client_uf =="RR" ? 'selected':''); ?>>Roraima</option>
                                            <option value="SC" <?php echo ($cliente->client_uf =="SC" ? 'selected':''); ?>>Santa Catarina</option>
                                            <option value="SP" <?php echo ($cliente->client_uf =="SP" ? 'selected':''); ?>>São Paulo</option>
                                            <option value="SE" <?php echo ($cliente->client_uf =="SE" ? 'selected':''); ?>>Sergipe</option>
                                            <option value="TO" <?php echo ($cliente->client_uf =="TO" ? 'selected':''); ?>>Tocantins</option>
                                        </select>
                                    <?php else: ?>
                                        <select class="" name="client_uf"style="width: 100%;background-color:transparent;border:1px solid #999999;border-radius:0;line-height:23px;padding: 10px 20px; font-size: 14px; color:#7a7a7a;margin-bottom:0px">
                                            <option value="">Escolha o estado</option>
                                            <option value="AC">Acre</option>
                                            <option value="AL">Alagoas</option>
                                            <option value="AP">Amapá</option>
                                            <option value="AM">Amazonas</option>
                                            <option value="BA">Bahia</option>
                                            <option value="CE">Ceará</option>
                                            <option value="DF">Distrito Federal</option>
                                            <option value="ES">Espírito Santo</option>
                                            <option value="GO">Goiás</option>
                                            <option value="MA">Maranhão</option>
                                            <option value="MT">Mato Grosso</option>
                                            <option value="MS">Mato Grosso do Sul</option>
                                            <option value="MG">Minas Gerais</option>
                                            <option value="PA">Pará</option>
                                            <option value="PB">Paraíba</option>
                                            <option value="PR">Paraná</option>
                                            <option value="PE">Pernambuco</option>
                                            <option value="PI">Piauí</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="RN">Rio Grande do Norte</option>
                                            <option value="RS">Rio Grande do Sul</option>
                                            <option value="RO">Rondônia</option>
                                            <option value="RR">Roraima</option>
                                            <option value="SC">Santa Catarina</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="SE">Sergipe</option>
                                            <option value="TO">Tocantins</option>
                                        </select>
                                    <?php endif;?>
                                    <div id="client_uf" class="text-danger"></div>
                                    </div>
                                </div>          
                            </div>
                            <?php if (isset($cliente)) : ?>
                                <input type="hidden" name="active" value="2">
                                <input type="hidden" name="client_id" value="<?php echo $cliente->client_id?>">
                            <?php endif; ?>
                        <div class="form-group row">
                            <div class="col-md-1 col-12 mb-20"></div>                              
                            <div class="col-md-1 col-12 mb-20">
                                <button type="submit" class="register-button mt-0">Cadastrar</button>
                            </div>                            
                        </div>
                    </div>
                <?php form_close();?>
            </div>            
        </div>
    </div>
</div>