<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
    <div class="main-content mt-3">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4"></div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="pricing pricing-highlight">
                            <div class="pricing-title p-3" style="font-size: 16px;">
                                 <a target="_blanck" class="text-white" href="<?php echo base_url('restrita/pedidos/imprimir/'.$transacoes->pedido_codigo)?>">Pedido:&nbsp;<?php echo $transacoes->pedido_codigo?></a>
                            </div>
                            <div class="pricing-padding">
                                <div class="pricing-price">
                                    <div>
                                        <?php 
                                            switch($transacoes->transacao_status){
                                                case 1:
                                                    echo '<div class="badge badge-shadow badge-warning" style="font-size: 20px;">Aguardando pagamento</div>';
                                                    break;
                                                case 2:
                                                    echo '<div class="badge badge-shadow badge-info" style="font-size: 20px;">Em análise</div>';
                                                    break;
                                                case 3:
                                                    echo '<div class="badge badge-shadow badge-success" style="font-size: 20px;">Paga</div>';
                                                    break;
                                                case 8:
                                                    echo '<div class="badge badge-shadow badge-success" style="font-size: 20px;">Disponível</div>';
                                                    break;
                                                case 5:
                                                    echo '<div class="badge badge-shadow badge-warning" style="font-size: 20px;">Em disputa</div>';
                                                    break;
                                                case 8:
                                                    echo '<div class="badge badge-shadow badge-dark" style="font-size: 20px;">Devolvida</div>';
                                                    break;
                                                case 7:
                                                    echo '<div class="badge badge-shadow badge-danger" style="font-size: 20px;">Cancelada</div>';
                                                    break;
                                                case 8:
                                                    echo '<div class="badge badge-shadow badge-success" style="font-size: 20px;">Debitada</div>';
                                                    break;
                                                case 9:
                                                    echo '<div class="badge badge-shadow badge-warning" style="font-size: 20px;">Retençao temporária/div>';
                                                    break;
                                                }
                                            ?> 
                                    </div>
                                    <div><?php echo $transacoes->pedido_cliente_nome?></div>
                                </div>
                                <div class="pricing-details">
                                    <?php if($transacoes->transacao_tipo_metodo_pagamento == 2 || $transacoes->transacao_tipo_metodo_pagamento == 3):?>
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon bg-red" style="width: 30px; height:30px;line-height:30px;"><i class=" fas fa-clock"></i></div>
                                            <div class="pricing-item-label pt-1">Data da transaçao:&nbsp;<?php echo formata_data_banco_com_hora($transacoes->transacao_data)?></div>
                                        </div>
                                        <div class="pricing-item">
                                            <div class="pricing-item-icon bg-info" style="width: 30px; height:30px;line-height:30px;"><i class="fas fa-link"></i></div>
                                            <div class="pricing-item-label pt-1"><a href="<?php echo $transacoes->transacao_link_pagamento?>" target="_blanck" title="Link de Pagamento">Clique aqui para visualizar o link de pagamento</a></div>
                                        </div>
                                    <?php endif;?>
                                    <div class="pricing-item">
                                    <div class="pricing-item-icon bg-success" style="width: 30px; height:30px;line-height:30px;"><i class="fas fa-dollar-sign"></i></div>
                                        <div class="pricing-item-label pt-1">Forma de pagamento:&nbsp;
                                        <?php 
                                            switch($transacoes->transacao_tipo_metodo_pagamento){
                                                case 1:
                                                    echo '<span class="text-success">Cartao de crédito</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="text-dark">Boleto bancário</span>';
                                                    break;
                                                default:
                                                    echo '<span class="text-primary">Transferencia bancária</span>';
                                                    break;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="pricing-item">
                                        <div class="pricing-item-icon bg-primary" style="width: 30px; height:30px;line-height:30px;"><i class="fas fa-hand-holding-usd"></i></div>
                                        <div class="pricing-item-label pt-1">Valor bruto da transacao:&nbsp;<?php echo 'R$&nbsp;'.number_format($transacoes->transacao_valor_bruto, 2)?></div>
                                    </div>
                                    <div class="pricing-item">
                                        <div class="pricing-item-icon bg-warning" style="width: 30px; height:30px;line-height:30px;"><i class="fas fa-comment-dollar"></i></div>
                                        <div class="pricing-item-label pt-1">Taxa do intermediador:&nbsp;<?php echo 'R$&nbsp;'.number_format($transacoes->transacao_valor_taxa_pagseguro, 2)?></div>
                                    </div>
                                    <div class="pricing-item">
                                        <div class="pricing-item-icon bg-teal" style="width: 30px; height:30px;line-height:30px;"><i class="fas fa-funnel-dollar"></i></div>
                                        <div class="pricing-item-label pt-1">Valor liquido:&nbsp;<?php echo 'R$&nbsp;'.number_format($transacoes->transacao_valor_liquido, 2)?></div>
                                    </div>
                                    <div class="pricing-item">
                                    <div class="pricing-item-icon bg-secondary" style="width: 30px; height:30px;line-height:30px;"><i class="text-dark fas fa-chart-bar"></i></div>
                                            <div class="pricing-item-label pt-1">Numero de parcelas:&nbsp;<?php echo $transacoes->transacao_numero_parcelas?></div>
                                    </div>            
                                </div>
                            </div>
                            <div class="pricing-cta">
                                <a href="<?php echo base_url('restrita/transacoes')?>"><i class="fas fa-arrow-left"></i>&nbsp;Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php $this->load->view('restrita/layout/sidebar_settings'); ?>
    </div>

