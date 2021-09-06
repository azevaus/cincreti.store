<?php $this->load->view('restrict/layout/navbar'); ?>
<?php $this->load->view('restrict/layout/sidebar'); ?>
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <?php
                        $atributos = array(
                            'name' => 'form_core',
                        );
                        if (isset($cliente)) {
                            $cliente_id = $cliente->client_id;
                        } else {
                            $cliente_id = '';
                        }
                    ?>
                    <?php echo form_open('restrict/clients/core/' . $cliente_id, $atributos); ?>
                    <div class="card">
                        <div class="card-header">
                            <h4><?php echo $titulo; ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>Nome</label>
                                    <input type="text" name="client_name" value="<?php echo (isset($cliente) ? $cliente->client_name : set_value('client_name')) ?>" class="form-control">
                                    <?php echo form_error('client_name', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Sobrenome</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_surname : set_value('client_surname')) ?>" name="client_surname">
                                    <?php echo form_error('client_surname', '<span class="text-danger">', '</span>'); ?>
                                </div>  
                                <div class="form-group col-md-2">
                                    <label>Data de nascimento</label>
                                    <input type="date" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_birth : set_value('client_birth')) ?>" name="client_birth">
                                    <?php echo form_error('client_birth', '<span class="text-danger">', '</span>'); ?>
                                </div>                                              
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>CPF</label>
                                    <input type="text" class="form-control cpf" value="<?php echo (isset($cliente) ? $cliente->client_cpf : set_value('client_cpf')) ?>" name="client_cpf">
                                    <?php echo form_error('client_cpf', '<span class="text-danger">', '</span>'); ?>
                                </div>  
                                <div class="form-group col-md-2">
                                    <label>RG</label>
                                    <input type="text" class="form-control rg" value="<?php echo (isset($cliente) ? $cliente->client_rg : set_value('client_rg')) ?>" name="client_rg">
                                    <?php echo form_error('client_rg', '<span class="text-danger">', '</span>'); ?>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-3">
                                    <label>Nome da mae</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_mother : set_value('client_mother')) ?>" name="client_mother">
                                    <?php echo form_error('client_mother', '<span class="text-danger">', '</span>'); ?>
                                </div>  
                                <div class="form-group col-md-3">
                                    <label>Nome do pai</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_dad : set_value('client_dad')) ?>" name="client_dad">
                                    <?php echo form_error('client_dad', '<span class="text-danger">', '</span>'); ?>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>E-mail</label>
                                    <input type="email" name="client_email" value="<?php echo (isset($cliente) ? $cliente->client_email : set_value('client_email')) ?>" class="form-control">
                                    <?php echo form_error('client_email', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone fixo</label>
                                    <input type="text" name="client_phone" value="<?php echo (isset($cliente) ? $cliente->client_phone : set_value('client_phone')) ?>" class="form-control sp_celphones">
                                    <?php echo form_error('client_phone', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control sp_celphones" value="<?php echo (isset($cliente) ? $cliente->client_cell : set_value('client_cell')) ?>" name="client_cell">
                                    <?php echo form_error('client_cell', '<span class="text-danger">', '</span>'); ?>
                                </div>                                            
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>Senha</label>
                                    <input type="password" name="password" class="form-control ">
                                    <?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Confirma senha</label>
                                    <input type="password" class="form-control" name="confirma">
                                    <?php echo form_error('confirma', '<span class="text-danger">', '</span>'); ?>
                                </div>                  
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>CEP</label>
                                    <input type="text" class="form-control cep" value="<?php echo (isset($cliente) ? $cliente->client_state : set_value('client5_state')) ?>" name="client_state">
                                    <?php echo form_error('client_state', '<span class="text-danger">', '</span>'); ?>
                                </div>  
                                <div class="form-group col-md-2">
                                    <label>Endereço</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_address : set_value('client_address')) ?>" name="client_address">
                                    <?php echo form_error('client_address', '<span class="text-danger">', '</span>'); ?>
                                </div> 
                                <div class="form-group col-md-1">
                                    <label>Número</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_number : set_value('client_number')) ?>" name="client_number">
                                    <?php echo form_error('client_number', '<span class="text-danger">', '</span>'); ?>
                                </div> 
                                <div class="form-group col-md-1">
                                    <label>Bairro</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_district : set_value('client_district')) ?>" name="client_district">
                                    <?php echo form_error('client_district', '<span class="text-danger">', '</span>'); ?>
                                </div> 
                                                               
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2"></div>
                                <div class="form-group col-md-2">
                                    <label>Complemtento</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_reference : set_value('client_reference')) ?>" name="client_reference">
                                    <?php echo form_error('client_reference', '<span class="text-danger">', '</span>'); ?>
                                </div>  
                                <div class="form-group col-md-2">
                                    <label>Cidade</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($cliente) ? $cliente->client_city : set_value('client_city')) ?>" name="client_city">
                                    <?php echo form_error('client_city', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="country-select clearfix">
                                        <label>Estado <span class="required">*</span></label>
                                        <?php if(isset($cliente)):?>
                                            <select class="custom-select" name="client_uf">
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
                                            <select class="custom-select" name="client_uf">
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
                                <input type="hidden" name="client_id" value="<?php echo $cliente_id ?>">
                            <?php endif; ?>
                            <div class="card-footer">
                                <button class="btn btn-dark mr-2">Salvar</button>
                                <a href="<?php echo base_url('restrict/clients'); ?>" class="btn btn-ligth">Voltar</a>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view('restrict/layout/sidebar_settings'); ?>