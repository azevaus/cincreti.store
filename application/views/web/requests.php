<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/')?>">Home</a></li>
                <li class="active"><a href=""><?php echo $titulo;?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="frequently-area pt-60" style="padding-bottom: 270px;">
    <div class="container">
        <div class="row">
        <?php if(isset($pedidos) && !empty($pedidos)):?>
            <div class="col-md-12">
                <div class="frequently-content">
                    <div class="frequently-desc">
                        <h3>Olá, <?php echo $this->session->userdata('cliente_nome')?></h3>
                        <p>Listando os seus pedidos.</p>
                    </div>
                </div>
                <!-- Begin Frequently Accordin -->
                <?php $i = 1 //contador?>
                <?php foreach($pedidos as $pedido):?>
                    <div class="frequently-accordion">
                        <div id="accordion-<?php echo $i?>">                            
                            <div class="card">
                                <div class="card-header" id="heading-<?php echo $i?>">
                                    <h5 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" data-target="#collapse-<?php echo $i?>" aria-expanded="false" aria-controls="collapseTwo">
                                        <i class="fa fa-shopping-basket"></i>&nbsp;&nbsp;Pedido:&nbsp;<?php echo $pedido->request_code?>&nbsp;&nbsp;<?php echo formata_data_banco_sem_hora($pedido->request_date_start)?>&nbsp;
                                         - &nbsp;
                                         <?php 
                                            switch($pedido->pedido_status){
                                                case 1:
                                                    echo '<span class="text-warning">Aguardando pagamento</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="text-info">Em análise</span>';
                                                    break;
                                                case 3:
                                                    echo '<span class="text-success">Paga</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="text-success">Disponível</span>';
                                                    break;
                                                case 5:
                                                    echo '<span class="text-warning">Em disputa</span>';
                                                    break;
                                                case 6:
                                                    echo '<span class="text-danger">Devolvida</span>';
                                                    break;
                                                case 7:
                                                    echo '<span class="text-danger">Cancelada</span>';
                                                    break;
                                                case 8:
                                                    echo '<span class="text-success">Debitada</span>';
                                                    break;
                                                case 9:
                                                    echo '<span class="text-warning">Retençao temporária/span>';
                                                    break;
                                            }
                                        ?>
                                    </a>
                                    </h5>
                                </div>
                                <div id="collapse-<?php echo $i?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion-<?php echo $i?>">
                                    <div class="card-body">
                                        <table class="table">                                                                              
                                            <thead>
                                                <tr>
                                                    <th class="li-product-thumbnail">Imagem</th>
                                                    <th class="cart-product-name">Data do pedido</th>
                                                    <th class="cart-product-name">Produto</th>
                                                    <th class="li-product-price">Situacao</th>
                                                    <th class="li-product-subtotal">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>  
                                                    <tr>                                                                             
                                                    <td class="li-product-thumbnail"><img  width="50"src="<?php echo base_url('uploads/products/small/'.$pedido->photo_path)?>" alt="Li's Product Image"></td>
                                                    <td class="li-product-name px-0" style="font-size: 12px;"><?php echo formata_data_banco_com_hora($pedido->request_date_start)?></td>
                                                    <td class="li-product-name px-0" style="font-size: 12px;">                                                        
                                                        <a><?php echo word_limiter($pedido->produto_nome,5)?></a>                                                        
                                                    </td>
                                                    <td class="li-product-price px-0" style="font-size: 12px;">
                                                        <?php 
                                                            switch($pedido->pedido_status){
                                                                case 1:
                                                                    echo '<span class="text-warning">Aguardando pagamento</span>';
                                                                    break;
                                                                case 2:
                                                                    echo '<span class="text-info">Em análise</span>';
                                                                    break;
                                                                case 3:
                                                                    echo '<span class="text-success">Paga</span>';
                                                                    break;
                                                                case 4:
                                                                    echo '<span class="text-success">Disponível</span>';
                                                                    break;
                                                                case 5:
                                                                    echo '<span class="text-warning">Em disputa</span>';
                                                                    break;
                                                                case 6:
                                                                    echo '<span class="text-danger">Devolvida</span>';
                                                                    break;
                                                                case 7:
                                                                    echo '<span class="text-danger">Cancelada</span>';
                                                                    break;
                                                                case 8:
                                                                    echo '<span class="text-success">Debitada</span>';
                                                                    break;
                                                                case 9:
                                                                    echo '<span class="text-warning">Retençao temporária/span>';
                                                                    break;
                                                            }
                                                        ?>
                                                    </td>                                                    
                                                    <td class="product-subtotal" style="font-size: 12px;"><span class="amount"><?php echo 'R$&nbsp;'.number_format($pedido->request_value_total, 2)?></span></td>                                                    
                                                </tr>                                                                                              
                                            </tbody>                                            
                                        </table>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                    <?php $i++?>
                <?php endforeach;?>
                <!--Frequently Accordin End Here -->
            </div>
        <?php else: ?>
                <div class="col-12 pt-20">
                    <h6 class="mb-20">Voce ainda nao realizou nenhuma compra</h6>
                    <div class="coupon-all">
                        <div class="coupon">
                            <a href="<?php echo base_url('/')?>" class="btn btn-dark">Que tal comprar agora?</a>
                            <div class="container text-center">
                                <img width="40%" style="margin-left: 50%;" src="<?php echo base_url('public/web/images/sem_pedidos.svg')?>">
                            </div>
                        </div>
                    </div>
                </div>
        <?php endif;?>
            
        </div>
    </div>
</div>