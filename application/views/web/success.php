<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container-fluid">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/')?>">Home</a></li>
                <li class="active"><a href=""><?php echo $titulo;?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="Shopping-cart-area pt-5 pb-60">
    <div class="container-fluid" style="width: 95%;">
        <div class="row">
            <div class="container text-center pt-60">
                <?php foreach($pedido_realizado as $pedido):?>
                    <h5 class="mb-20"><?php echo $pedido->cliente_nome_completo?></h5>
                    <h6 class="mb-20 text-success"><?php echo $pedido->mensagem?></h6>
                    <div class="bg-primary badge text-white" style="padding: 15px; font-size:14px;">
                        <?php echo $pedido->pedido_gerado?>
                    </div>
                    <?php if($pedido->forma_pagamento != 1):?>
                        <div class="mt-30">
                            <a href="<?php echo $pedido->transacao_link_pagamento?>" target="_blank">
                                <?php echo ($pedido->forma_pagamento == 2 ?'<i class="fa fa-barcode fa-4x"></i>':'<i class="fa fa-university fa-4x"></i>') ?>                                                             
                                <p class="mt-3"><?php echo ($pedido->forma_pagamento == 2 ?'Imprimir boleto para o pagamento' : 'Para concluir o pagamento, acesse o ambiente seguro do seu banco.')?></p>
                            </a>
                        </div>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>