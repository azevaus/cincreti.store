<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/')?>">Home</a></li>
                <li><a href="<?php echo base_url('master/'.$produto->master_meta_link)?>"><?php echo $produto->master_name?></a></li>
                <li class="active"><a href="<?php echo base_url('master/'.$produto->categorie_meta_link)?>"><?php echo $produto->categorie_name?></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- TUDO SOBRE O PRODUTO-->
    <div class="content-wraper mt-20">
        <div class="container">
            <div class="row single-product-area">
                <div class="col-lg-5 col-md-6">
                    <div class="product-details-left">
                        <div class="product-details-images slider-navigation-1">
                            <?php foreach($fotos_produto as $foto):?>
                                <div class="lg-image">
                                    <a class="popup-img venobox vbox-item" href="<?php echo base_url('uploads/products/'.$foto->photo_path)?>" data-gall="myGallery">
                                        <img src="<?php echo base_url('uploads/products/'.$foto->photo_path)?>" alt="product image">
                                    </a>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="product-details-thumbs slider-thumbs-1">   
                            <?php foreach($fotos_produto as $foto):?> 
                                <div class="sm-image" style="padding:5px;">
                                    <img src="<?php echo base_url('uploads/products/small/'.$foto->photo_path)?>" alt="product image thumb">
                                </div>
                            <?php endforeach;?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="product-details-view-content pt-60">
                        <div class="product-info">
                            <h2><?php echo $produto->pro_name?></h2>
                            <span class="product-details-ref">Código: <?php echo $produto->pro_code?></span>
                            <p class="mt-10"><span class="product-details-ref">Marca:&nbsp;<a href="<?php echo $produto->pro_qtd_stock?>"><?php echo $produto->brand_name?></a></span></p>
                            <!--<p class="mt-10"><span class="product-details-ref">Estoque:&nbsp;<?php echo ($produto->pro_qtd_stock > 0 ? '<span class="badge badge-success" style="font-size:14px;">'.$produto->pro_qtd_stock.'</sapn>' : '<span class="badge badge-danger" style="font-size:14px;">Indisponível</span>')?></span></p> -->
                            <div class="price-box pt-10">
                                <span class="new-price new-price-2"><?php echo 'R$&nbsp;'.number_format($produto->pro_value, 2)?></span>
                            </div>
                            <div class="mb-5">
                                <a href="#" title="ver parcelamento" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter">Ver parcelamento</a>
                            </div>
                            <?php 
                                $atributos = array(
                                    'class' => 'cart-quantity'
                                );
                            ?>
                            <?php echo form_open('ajax', $atributos) ?>
                            <div class=" quantity">                                
                                <div class=".cart-plus-minus" style="min-width:140px; float:left; position:relative; text-align:left;">
                                    <input type="text" name="cep" id="cep" class="cart-plus-minus-box cep" placeholder="Informe seu CEP" >                                        
                                </div>                                    
                            </div> 
                            <button type="button" id="btn_calcula_frete" data-id="<?php echo $produto->pro_id?>" class="add-to-cart bg-info" style="padding: 8px 20px">Calcular</button>
                            <div id="retorno_frete" class="mt-15"></div>
                            <?php echo form_close();?>                               
                            </div>
                            <div class="pt-10 text-info" id="retorno_frete"></div>
                            <?php if($produto->pro_qtd_stock > 0): ?>
                                <div class="single-add-to-cart">                                        
                                    <?php 
                                        $atributos = array(
                                            'class' => 'cart-quantity'
                                        );
                                    ?>
                                    <?php echo form_open('carrinho', $atributos) ?>
                                        <div class="quantity">
                                            <label>Quantidade</label>
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box mask-produto-qty" id="produto_quantidade" name="produto_quantidade" value="1" type="text">
                                                    <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                                                    <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                                                </div>
                                            </div>
                                            <button class="add-to-cart btn-add-produto" data-id="<?php echo $produto->pro_id?>" type="button">Adicionar ao carrinho</button>
                                            <div id="mensagem"></div>
                                        </div>
                                    <?php echo form_close();?>
                                </div>
                            <?php else: ?>
                                <div class="cart-quantity">
                                    <button class="add-to-cart bg-danger" type="button">Indisponível</button>
                                </div>                                        
                            <?php endif;?>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
<!-- FIM DO TUDO SOBRE O PRODUTO-->
<!-- DESCRICAO DO PRODUTO -->
<div class="product-area pt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#description"><span>Descriçao</span></a></li>                                   
                    </ul>               
                </div>
                <div class="tab-content">
                    <div id="description" class="tab-pane active show" role="tabpanel">
                        <div class="product-description">
                            <span><?php echo $produto->pro_description?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#description"><span>Ficha técnica</span></a></li>                                   
                    </ul>               
                </div>
                <div class="tab-content">
                    <div id="description" class="tab-pane active show" role="tabpanel">
                        <div class="product-description">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="table-fixo">Codigo</th>
                                <th class="table-auto"><?php echo $produto->pro_code ?></th>
                            </tr>
                            <tr>
                                <th class="table-fixo">Marca</th>
                                <th class="table-auto"><?php echo $produto->brand_name ?></th>
                            </tr>
                            <tr>
                                <th class="table-fixo">Dimenssões do produto</th>
                                <th class="table-auto"><?php echo 'A: '.$produto->pro_altura.'cm,&nbsp;L: '.$produto->pro_largura .'cm,&nbspC: ' . $produto->pro_comprimento. 'cm' ?></th>
                            </tr>
                            <tr>
                                <th class="table-fixo">Conteudo da embalagem</th>
                                <th class="table-auto"><?php echo $produto->content_package ?></th>
                            </tr>
                            <tr>
                                <th class="table-fixo">Referencia do modelo</th>
                                <th class="table-auto"><?php echo $produto->pro_model ?></th>
                            </tr>
                            </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <hr>
        <div class="li-comment-section mt-6">
            <h3 class="text-center">O que as pessoas estão achando</h3>
            <ul>
                <?php foreach($avaliacoes as $nota):?>
                    <?php if($nota->note_product_id == $produto->pro_id): ?>
                    <li>                  
                        <div class="comment-body pl-15">
                            <h5 class="comment-author pt-15"><?php echo $nota->avaliacao_cliente_nome?></h5>
                            <div class="comment-review">
                                <ul class="rating">
                                    <?php 
                                        switch($nota->avaliacao_nota){
                                            case  $nota->avaliacao_nota == 0 && $nota->avaliacao_nota < 1:
                                                echo '
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;
                                            case  $nota->avaliacao_nota <= 1:
                                                echo '
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;
                                            case $nota->avaliacao_nota >= 2 && $nota->avaliacao_nota < 3:
                                                echo '
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;
                                            case $nota->avaliacao_nota >= 3 && $nota->avaliacao_nota < 4:
                                                echo '
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li lass="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;
                                            case $nota->avaliacao_nota >= 4 && $nota->avaliacao_nota < 5:
                                                echo '
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;
                                            case $nota->avaliacao_nota >= 5:
                                                echo '
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>                                                                            
                                                ';
                                                break;                                                                    
                                        }
                                    ?>
                                </ul>
                            </div>
                            <div class="comment-post-date">
                                <?php echo formata_data_banco_com_hora($nota->avaliacao_data_cadastro)?>
                            </div>
                            <p><?php echo $nota->avaliacao_comentario?></p>
                        </div>                      
                    </li>                                               
                    <?php endif;?>                         
                <?php endforeach;?>          
            </ul>
        </div>
        <?php $cliente_logado = $this->ion_auth->logged_in() ?>
            <?php if($cliente_logado): ?>
                <hr>
                <div class="li-blog-comment-wrapper">
                    <h3>Deixe sua avaliaçao</h3>            
                    <?php echo form_open('avaliacoes/core/'.$produto->pro_meta_link)?>
                        <div class="comment-post-box">
                            <div class="row" style="margin-top:10px">
                                <div class="col-lg-6">
                                    <label>O que voce achou?</label>
                                    <textarea class="form-control" name="avaliacao_comentario" style="border: 1px solid #4e4e4e; border-radius:1px;"  placeholder="Escreva seu comentário"></textarea>
                                    <?php echo form_error('avaliacao_comentario', '<span class="text-danger">', '</span>'); ?>
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-4 mb-sm-20 mb-xs-20" >
                                        <label>Deixe algumas estrelas</label>
                                        <span>
                                            <select class="star-rating" name="avaliacao_nota">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </span>
                                </div>
                                <div class="col-lg-12">
                                    <input type="hidden" name="note_client_id" value="<?php echo $cliente['cliente_user_id']?>">
                                    <input type="hidden" name="note_product_id" value="<?php echo $produto->produto_id?>">
                                    <div class="coment-btn pt-30 mb-30 pb-sm-30 pb-xs-30 f-left">
                                        <button type="submit" class="register-button mt-0">avaliar</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            <?php endif;?>
    </div>
</div>
<!-- FIM DA DESCRIÇAO DO PRODUTO -->
<!-- MODAL PARCELAMENTO -->
<div class="modal fade modal-wrapper" id="exampleModalCenter" >
    <div class="modal-dialog modal-dialog-centered" role="document">    
        <div class="modal-content">        
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="modal-inner-area row">
                    <div class="col-lg-1 col-md-6 col-sm-6"></div>
                    <div class="col-lg-10 col-md-6 col-sm-6">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="li-product-tab">
                                        <ul class="nav li-product-menu">
                                            <li><a class="active" data-toggle="tab" href="#li-new-product"><span>Cartões </span></a></li>
                                            <li><a data-toggle="tab" href="#li-bestseller-product"><span>Cartão Cincreti</span></a></li>
                                        </ul>               
                                    </div>
                                </div>
                            </div>
                            <div class="tab-content">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Quantidade</th>
                                            <th scope="col">Valor da parcela</th>
                                            <th scope="col">Juros</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>2X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/2, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>3X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/3, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>4X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/4, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>5X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/5, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>6X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/6, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>7X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/7, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>8X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/8, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>9X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/9, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                        <tr>
                                            <td>10X</td>
                                            <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/10, 2)?></td>
                                            <td>0%</td>
                                        </tr>
                                    </tbody>
                                </table>                      
                                <div id="li-bestseller-product" class="col-lg-12 col-md-6 col-sm-6 tab-pane" role="tabpanel">
                                    <div class="tab-content">
                                        <table  class="table">
                                            <tbody>
                                                <tr>
                                                    <td>11X</td>
                                                    <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/11, 2)?></td>
                                                    <td>0%</td>
                                                </tr>
                                                <tr>
                                                    <td>12X</td>
                                                    <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/12, 2)?></td>
                                                    <td>0%</td>
                                                </tr>
                                                <tr>
                                                    <td>13X</td>
                                                    <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/13, 2)?></td>
                                                    <td>0%</td>
                                                </tr>
                                                <tr>
                                                    <td>14X</td>
                                                    <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/14, 2)?></td>
                                                    <td>0%</td>
                                                </tr>
                                                <tr>
                                                    <td>15X</td>
                                                    <td><?php echo 'R$&nbsp;'.number_format($produto->pro_value/15, 2)?></td>
                                                    <td>0%</td>
                                                </tr>
                                            </tbody>
                                        </table>    
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
<!-- FIM DO MODAL -->