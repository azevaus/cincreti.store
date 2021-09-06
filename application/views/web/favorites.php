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
<div class="Shopping-cart-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <?php if(isset($favoritos) && !empty($favoritos)):?>
                <div class="col-12">
                <div id="mensagem"></div>
                <form action="#">
                    <div class="table-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="li-product-remove">Remover</th>
                                    <th class="li-product-thumbnail">Imagem</th>
                                    <th class="cart-product-name">Produto</th>
                                    <th class="li-product-price">Preço Unitário</th>
                                    <th class="li-product-quantity">Quantidade</th>
                                    <th class="li-product-subtotal">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($carrinho as $produto):?>
                                <tr>
                                    <td class="li-product-remove"><a class="btn-del-item" data-id="<?php echo $produto['produto_id']?> "href="#"><i class="fa fa-times"></i></a></td>
                                    <td class="li-product-thumbnail"><a href="<?php echo base_url('produto'.$produto['produto_meta_link'])?>"><img  width="50"src="<?php echo base_url('uploads/produtos/small/'.$produto['produto_foto'])?>" alt="Li's Product Image"></a></td>
                                    <td class="li-product-name"><a href="<?php echo base_url('produto'.$produto['produto_meta_link'])?>"><?php echo word_limiter($produto['produto_nome'], 3)?></a></td>
                                    <td class="li-product-price"><span class="amount"><?php echo 'R$&nbsp;'.number_format($produto['produto_valor'], 2)?></span></td>
                                    <td class="quantity" style="width: 150px;">
                                        <div class="cart-plus-minus float-left" >
                                            <input id="produto_<?php echo $produto['produto_id']?>" name="produto_quantidade" class="cart-plus-minus-box mask-produto-qty" value="<?php echo $produto['produto_quantidade']?>" type="text">
                                            <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                            <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                        </div>
                                        <button type="button" data-id="<?php echo $produto['produto_id'] ?>"title="Atualizar quantidade" class="btn-altera-quantidade btn btn-ligth" style="padding: 10px 15px;"><i class="fa fa-refresh"></i></button>
                                    </td>                                    
                                    <td class="product-subtotal"><span class="amount"><?php echo 'R$&nbsp;'.number_format($produto['subtotal'], 2)?></span></td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="coupon-all">
                                <div class="coupon">
                                    <button class="btn btn-outline-ligth btn-limpa-cart" type="submit">Limpar carrinho</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5 ml-auto">
                            <div class="cart-page-total">
                                <h2>Valor total</h2>
                                <ul>
                                    <li>Total de produtos <span><?php echo 'R$&nbsp;'.$this->carrinho_compras->get_total()?></span></li>
                                    <li>Total <span id="total_final_carrinho">R$ &nbsp;<?php echo 'R$&nbsp;'.$this->carrinho_compras->get_total()?></span></li>
                                </ul>
                                <a href="<?php echo base_url('checkout') ?>">Processar compra</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php else:?>
                <div class="col-12">
                    <h6 class="mb-20">Seu carrinho está vazio.</h6>
                    <div class="coupon-all">
                        <div class="coupon">
                            <a href="<?php echo base_url('/')?>" class="btn btn-dark">Continuar comprando</a>
                            <div class="container text-center">
                                <img width="40%" style="margin-left: 30%;" src="<?php echo base_url('public/web/images/carrinho_vazio.svg')?>">
                            </div>
                        </div>
                    </div>

                </div>
            <?php endif;?>
        </div>
    </div>
</div>