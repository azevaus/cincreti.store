<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/') ?>">Home</a></li>
                <li class="active"><a href=""><?php echo $title; ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="Shopping-cart-area pt-60" style="padding-bottom: 193px !important;">
    <div class="container">
        <div class="row">
            <?php if (isset($cart) && !empty($cart)) : ?>
                <div class="col-12">
                    <div id="mensagem"></div>
                    <form>
                        <div class="table-content table-responsive">
                            <!-- TABELA -->
                            <table class="table table-borderless">
                                <thead>
                                    <!-- CABEÇALHO DA TABELA -->
                                    <tr>
                                        <th class="li-product-thumbnail">Foto do produto</th>
                                        <th class="li-product-thumbnail">Nome do produto</th>
                                        <th class="li-product-thumbnail">Preço</th> <!-- VERIFICAR A DIFERENCA DOS DOIS, JA ME ESQUECI -->
                                        <th class="li-product-thumbnail">Quantidade</th>
                                        <th class="li-product-thumbnail">Total</th> <!-- VERIFICAR A DIFERENCA DOS DOIS, JA ME ESQUECI -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- CORPO DA TABELA -->
                                    <?php foreach ($cart as $product) : ?>
                                        <tr>
                                            <td class="li-product-thumbnail" style="width: 20%;">
                                                <!-- FOTO DO PRODUTO -->
                                                <a href="">
                                                    <img width="35%" src="<?php echo base_url('uploads/products/small/' . $product['product_photo']) ?>">
                                                </a>
                                            </td>
                                            <td class="li-product-name">
                                                <!-- NOME DO PRODUTO -->
                                                <a href="<?php echo base_url('products/' . $product['pro_meta_link']) ?>">
                                                    <?php echo word_limiter($product['pro_name'], 4) ?>
                                                </a>
                                            </td>
                                            <td class="li-product-price">
                                                <!-- PREÇO DO PRODUTO -->
                                                <span class="amount">
                                                    <?php echo 'R$&nbsp;' . number_format($product['pro_value'], 2); ?>
                                                </span>
                                            </td>
                                            <td class="quantity">
                                                <!-- QUANTIDADE DE PRODUTOS -->
                                                <div>
                                                    <input id="produto_<?php echo $product['pro_id'] ?>" name="produto_quantidade" class="mask-produto-qty" value="<?php echo $product['pro_quantity'] ?>" type="number" readonly="" style="background:#fff; border:none; font-size:16px; color:#1c1c1c; text-align:center; font-weight:600;">
                                                </div>
                                            </td>
                                            <td class="product-subtotal">
                                                <!-- TOTAL A PAGAR -->
                                                <span class="amount"><?php echo "R$&nbsp;" . number_format($product['subtotal'], 2) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="border: none;">
                                        <td class="text-right" style="color: #1c1c1c; font-weight:600;" colspan="4">Total do frete</td>
                                        <td><span id="opcao_frete_ecolhido">R$ &nbsp; 0.00</span></li>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" style="color: #1c1c1c; font-weight:600;" colspan="4">Total com frete</td>
                                        <td><span id="total_final_carrinho"><?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></li>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="container mt-50">
                    <!-- PREPARAR PARA TROCAR O CONTAINER PARA FLUID-->
                    <?php $logged_in = $this->ion_auth->logged_in(); ?>
                    <?php if (!$logged_in) : ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <?php if ($message = $this->session->flashdata('error')) : ?>
                                            <div width="30%" class="alert alert-danger bg-danger text-white alert-dismissible alert-has-icon">
                                                <div class="alert-body">
                                                    <button class="close" data-dismiss="alert">
                                                        <span>&times;</span>
                                                    </button>
                                                    <?php echo $message ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="coupon-accordion">
                                    <!--Accordion Start-->
                                    <h3>Já é cliente? <span id="showlogin">Clique aqui para entrar</span></h3>
                                    <div id="checkout-login" class="coupon-content">
                                        <div class="coupon-info">
                                            <p class="coupon-text">Login.</p>
                                            <?php echo form_open('login/auth'); ?>
                                            <p class="form-row-first">
                                                <label>E-mail <span class="required">*</span></label>
                                                <input type="email" name="email">
                                            </p>
                                            <p class="form-row-last">
                                                <label>Password <span class="required">*</span></label>
                                                <input type="password" name="password">
                                            </p>
                                            <input type="hidden" name="login" value="checkout">
                                            <p class="form-row">
                                                <input value="Login" type="submit">
                                                <label>
                                                    <input type="checkbox" name="remember">
                                                    Manter conectado
                                                </label>
                                            </p>
                                            <p class="lost-password"><a href="<?php echo base_url('profile') ?>">Ainda nao é cliente?</a></p>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>
                                    <!--Accordion End-->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        
                        <div class="col-lg-6 col-12 mt-20">
                            <div class="your-order">
                                <h3>Pagamento</h3>
                                <div class="payment-method">
                                    <div class="payment-accordion">
                                        <div id="accordion">
                                            <div class="checkbox-form">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="country-select clearfix">
                                                            <label>Forma de pagamento <span class="required">*</span></label>
                                                            <select class="nice-select wide forma_pagamento" name="forma_pagamento" style="border-radius:1px;">
                                                                <option data-display="Cartao de crédito" value="1">Cartao de crédito</option>
                                                                <option value="2">Boleto bancário</option>
                                                                <option value="3">Débito em conta</option>
                                                            </select>
                                                            <div id="forma_pagamento" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7 cartao">
                                                        <div class="checkout-form-list">
                                                            <label>Nome do titular <span class="required">*</span></label>
                                                            <input name="cliente_nome_titular" placeholder="Nome impresso no cartao" value="<?php set_value('cliente_nome_titular') ?>" type="text" required="">
                                                            <div id="cliente_nome_titular" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 cartao">
                                                        <div class="checkout-form-list">
                                                            <label>Numero do Cartao <span class="required">*</span></label>
                                                            <input name="numero_cartao" class="card_number" placeholder="0000 0000 0000 0000" value="<?php set_value('numero_cartao') ?>" type="text" required="">
                                                            <div id="numero_cartao" class="text-danger"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 cartao">
                                                        <div class="checkout-form-list">
                                                            <label>Validade do cartao<span class="required">*</span></label>
                                                            <input name="validade_cartao" class="card_expire" placeholder="MM/AA" value="<?php set_value('validade_cartao') ?>" type="text" required="">
                                                            <div id="validade_cartao" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 cartao">
                                                        <div class="checkout-form-list">
                                                            <label>CCV<span class="required">*</span></label>
                                                            <input name="codigo_seguranca" class="card_cvv" placeholder="123" value="<?php set_value('codigo_seguranca') ?>" type="text" required="">
                                                            <div id="codigo_seguranca" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 cartao">
                                                        <div class="checkout-form-list">
                                                            <label>Parcelas<span class="required">*</span></label>
                                                            <select class="nice-select wide" name="cliente_parcelamento" style="border-radius:0;">
                                                                <option value="">Escolha</option>
                                                                <option value="1">1x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="2">2x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="3">3x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="4">4x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="5">5x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="6">6x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="7">7x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="8">8x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="9">9x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="10">10x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="11">11x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="12">12x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="13">13x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="14">14x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>
                                                                <option value="15">15x - <?php echo 'R$&nbsp;' . $this->cart_shop->get_total() ?></option>

                                                            </select>
                                                            <div id="numero_parcelas" class="text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 opcao_boleto d-none">
                                                        <div class="checkout-form-list">
                                                            <div class="alert alert-info" role="alert">
                                                                <i class="fa fa-barcode fa-lg"></i> &nbsp;Voce poderá emitir o boleto ao final da compra
                                                            </div>
                                                            <div class="col-md-12">
                                                                <button id="btn_pagar_boleto" class="btn btn-dark btn-block" type="button" style="border-radius:1px;height: 40px;width:100%;">Pagar com boleto</button>
                                                            </div>
                                                            <div id="opcao_boleto" class="mt-2"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 opcao_debito_conta d-none">
                                                        <div class="checkout-form-list">
                                                            <select class="nice-select wide" name="banco_escolhido">
                                                                <option value="">Escolha um banco</option>
                                                                <option value="itau">Itaú</option>
                                                                <option value="banrisul">Banrisul</option>
                                                                <option value="bradesco">Bradesco</option>
                                                                <option value="bancodobrasil">Banco do Brasil</option>
                                                            </select>
                                                            <div id="opcao_banco"></div>

                                                        </div>
                                                        <div class="alert alert-info mt-50" role="alert">
                                                            <i class="fa fa-university fa-lg"></i> &nbsp;Voce poderá acessar o ambiente do seu banco ao final da compra.
                                                        </div>
                                                        <div class="col-md-12">
                                                            <button id="btn_pagar_debito" class="btn btn-dark btn-block" type="button" style="border-radius:1px;height: 40px;width:100%;">Pagar com débito em conta</button>
                                                        </div>
                                                        <div id="opcao_debito" class="mt-2"></div>
                                                    </div>
                                                    <div class="col-md-12 cartao mt-30">
                                                        <div class="col-md-12">
                                                            <button id="btn_pagar_cartao" class="btn btn-dark btn-block" type="button" style="border-radius:1px;height: 40px;width:100%;">Pagar com cartao de crédito</button>
                                                        </div>
                                                        <div id="erro_cartao"></div>
                                                        <input id="token_pagamento" type="hidden" class="form-control" name="token_pagamento">
                                                        <div id="opcao_pagar_carto" class="mt-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="col-12 text-center">
                    <h6 class="mb-20">Seu carrinho está vazio.</h6>
                    <div class="coupon-all">
                        <div class="coupon">
                            <a href="<?php echo base_url('/') ?>" class="btn btn-dark">Continuar comprando</a>
                            <div class="container text-center">
                                <img width="30%" style="margin-top:4%;" src="<?php echo base_url('public/web/images/carrinho_vazio.svg') ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>