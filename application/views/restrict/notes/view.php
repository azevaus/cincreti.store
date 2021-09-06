<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content mt-3">
    <div class="container" style="margin-top: 3rem;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">          
                            <div class="card-header d-blok">
                                <h4 style="margin-top: 1rem;"><?php echo $titulo?></h4>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6">
                                    <span>Dados do cliente</span>
                                    <p><strong>Nome cliente:</strong> <?php echo $dados->avaliacao_cliente_nome?> </p>
                                    <p><strong>CPF:</strong> <?php echo $dados->client_cpf?></p>      
                                    <p><strong>Celular:</strong> <?php echo $dados->client_cell?></p>             
                                    <p><strong>E-mail:</strong> <?php echo $dados->client_email?></p>
                                </div>
                                <hr>
                                <div class="col-md-6"> 
                                    <span>Feedback do produto</span>
                                    <p>
                                        <strong>
                                            <?php echo $dados->	note_comment?>
                                        </strong>           
                                    </p>
                                    <span>Data da postagem</span>
                                    <p>
                                        <strong>
                                            <?php echo formata_data_banco_com_hora($dados->	note_date_start)?>
                                        </strong>           
                                    </p>
                                </div>            
                                <hr>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped data-table">
                                            <thead>
                                                <tr>
                                                    <th>Produto avaliado</th>    
                                                    <th>Avaliaçao</th> 
                                                    <th></th>                 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><a href="<?php echo base_url('restrita/produtos/core/'.$dados->pro_id)?>"><?php echo word_limiter($dados->pro_name, 5)?></a></td> 
                                                <td><?php echo $dados->note?></td>  
                                                <td><a href="<?php echo base_url('restrita/avaliacoes')?>">Voltar</a></td>                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php $this->load->view('restrita/layout/sidebar_settings'); ?>
</div>