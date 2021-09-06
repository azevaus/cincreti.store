<header>
    <!-- HEADER COM TELEFONES, ACESSO E MARCAS-->
        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div class="header-top-left">
                            <ul class="phone-wrap">
                                <?php $sistema = info_header_footer();?>
                                <li><span>Nossos telefones:&nbsp;<?php echo $sistema->sistema_telefone_fixo . ' - ' . $sistema->sistema_telefone_movel?></span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="header-top-right">
                            <ul class="ht-menu">
                                <li>
                                    <div class="ht-setting-trigger"><span>Grandes Marcas</span></div>
                                    <div class="setting ht-setting">
                                        <ul class="ht-setting-list">
                                            <?php $grandes_marcas = grandes_marcas_navbar()?>
                                            <?php foreach($grandes_marcas as $master):  ?>
                                                <li><a href="<?php echo base_url('brand/'. $master->brand_meta_link)?>"><?php echo $master->brand_name?></a></li>
                                            <?php endforeach;?>                                        
                                        </ul>
                                    </div>
                                </li>
                                <li>
                                    <?php $cliente_logado = $this->ion_auth->logged_in() ?>
                                    <div class="ht-currency-trigger"><span><?php echo (!$cliente_logado ? 'Entre ou cadastre-se':'Olá, '.$this->session->userdata('client_name'))?></span></div>
                                    <div class="currency ht-currency">
                                        <ul class="ht-settings-list">
                                            <?php if(!$cliente_logado): ?>
                                                <li><a href="<?php echo base_url('login')?>">Entrar</a></li>
                                            <?php else:?>
                                                <li><a href="<?php echo base_url('profile')?>">Perfil</a></li>
                                                <li><a href="<?php echo base_url('request');?>">Pedidos</a></li>  
                                                <li><a href="<?php echo base_url('login/logout');?>">Sair</a></li>                                            
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- FIM DO HEADER COM TELEFONES, ACESSO E MARCAS-->
    <!-- HEADER COM LOGO, CAMPO DE PESQUISA, FAVORITOS E CARRINHO-->
        <div class="header-middle pl-sm-0 pr-sm-0 pl-xs-0 pr-xs-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="logo pb-sm-30 pb-xs-30">
                            <a href="<?php echo base_url('/')?>">
                                <img style="width:250px;"src="<?php echo base_url('public/assets/img/logo_branco_horizontal.png')?>" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 pl-0 ml-sm-15 ml-xs-15">
                        <?php
                            $atributos = array(
                                'class'=>'hm-searchbox'
                            );
                        ?>
                        <?php echo form_open('busca', $atributos)?>                                    
                            <input type="text" name="busca" placeholder="Qual produto voce está procurando?">
                            <button class="li-btn" type="submit"><i class="fa fa-search"></i></button>
                        <?php echo form_close();?>
                        <div class="header-middle-right">
                            <ul class="hm-menu">     
                                                                  
                                <li class="hm-minicart">
                                    <div id="top-cart" class="hm-minicart-trigger">
                                        <span class="item-icon"></span>
                                        <span class="item-text"><?php echo ($this->carrinho_compras->get_total() > '0,00' ? 'R$&nbsp;'.$this->carrinho_compras->get_total() : '0,00');?>
                                            <?php if($this->carrinho_compras->get_total_itens() > 0):?>
                                                <span class="cart-item-count"><?php echo $this->carrinho_compras->get_total_itens()?></span>
                                            <?php endif;?>
                                        </span>
                                    </div>
                                    <span></span>
                                    <div id="list-itens" class="minicart">
                                        <ul class="minicart-product-list">
                                            <?php if($this->carrinho_compras->get_total_itens() > 0):?>
                                                <?php 
                                                    $carrinho = $this->carrinho_compras->get_all();
                                                ?>
                                                <?php foreach($carrinho as $produto):?>
                                                    <li>
                                                        <a href="<?php echo base_url('produto/'.$produto['pro_meta_link'])?>" class="minicart-product-image">
                                                            <img src="<?php echo base_url('uploads/products/small/'.$produto['product_photo']) ?>" alt="">
                                                        </a>
                                                        <div class="minicart-product-details">
                                                            <h6><a href="<?php echo base_url('produto/'.$produto['pro_meta_link'])?>"><?php echo word_limiter($produto['pro_name'], 3) ?></a></h6>
                                                            <span><?php echo 'R$&nbsp;'.number_format($produto['pro_value'], 2)?> x <?php echo $produto['pro_quantity']?></span>
                                                        </div>
                                                    </li>
                                                <?php endforeach;?>
                                            <?php endif;?>
                                        </ul>
                                        <p class="minicart-total">SUBTOTAL: <span><?php echo 'R$&nbsp;'.$this->carrinho_compras->get_total();?></span></p>
                                        <div class="minicart-button">
                                            <?php if($this->carrinho_compras->get_total_itens() > 0):?>
                                                <a href="<?php echo base_url('carrinho')?>" class="li-button li-button-fullwidth li-button-warning">
                                                    <span>Ver carrinho</span>
                                                    <a href="<?php echo base_url('checkout')?>" class="li-button li-button-fullwidth">
                                                        <span>Finalizar</span>
                                                    </a>
                                                </a>
                                            <?php else:?>
                                                <a href="<?php echo base_url('carrinho')?>" class="li-button li-button-fullwidth">
                                                    <span>Carrinho vazio</span>
                                                </a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- FIM DO HEADER COM LOGO, CAMPO DE PESQUISA, FAVORITOS E CARRINHO-->
    <!-- MENU DO SITE-->
        <div class="header-bottom header-sticky d-none d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="hb-menu">
                            <nav>
                                <ul>
                                    <li class="dropdown-holder"><a href="<?php echo base_url('/')?>">Home</a></li>
                                    <?php $categorias_pai = categorias_master_navbar()?> 
                                    <?php foreach($categorias_pai as $cat_pai):?>
                                    <?php $categorias_filhas = categorias_navbar($cat_pai->master_id)?>
                                        <li class="dropdown-holder"><a href="<?php echo base_url('master/'.$cat_pai->master_meta_link)?>"><?php echo $cat_pai->master_name ?></a>
                                            <ul class="hb-dropdown">
                                                <?php foreach($categorias_filhas as $cat_filha):?>
                                                    <li class="active"><a href="<?php echo base_url('categoria/'.$cat_filha->categorie_meta_link)?>"><?php echo $cat_filha->categorie_name ?></a></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- MENU RESPONSIVO-->
        <div class="mobile-menu-area d-lg-none d-xl-none col-12">
            <div class="container"> 
                <div class="row">
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
        <!-- FIM DO MENU RESPONSIVO-->
    <!-- FIM DO MENU DO SITE-->
</header>
