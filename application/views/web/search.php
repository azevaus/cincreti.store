<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="<?php echo base_url('/')?>">Home</a></li>
                <li class="active"><?php echo $produto_buscado?></li>
            </ul>
        </div>
    </div>
</div>
<div class="content-wraper pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">                        
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">
                                    <?php if(isset($produtos)):?>
                                        <?php foreach($produtos as $produto):?>
                                            <div class="col-lg-3 col-md-4 col-sm-6 mt-40 mb-50">
                                                <div class="single-product-wrap">
                                                    <div class="product-image">
                                                        <a href="<?php echo base_url('produto/'.$produto->pro_meta_link)?>">
                                                            <img src="<?php echo base_url('uploads/products/'.$produto->photo_path)?>" alt="Li's Product Image">
                                                        </a>
                                                        <span class="sticker">New</span>
                                                    </div>
                                                    <div class="product_desc">
                                                        <div class="product_desc_info">
                                                            <div class="product-review">
                                                                <h5 class="manufacturer">
                                                                <a href="product-details.html">Avaliaçoes</a>
                                                                </h5>
                                                                <div class="rating-box">
                                                                    <ul class="rating">
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        <li><i class="fa fa-star-o"></i></li>
                                                                        <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                        <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <h4><a class="product_name" href="single-product.html"><?php echo word_limiter($produto->pro_name, 4)?></a></h4>
                                                            <div class="price-box">
                                                                <span class="new-price"><?php echo 'R$&nbsp;'. number_format($produto->pro_value, 2) ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="add-actions">
                                                            <ul class="add-actions-link">
                                                                <li class="add-cart active" ><a href="<?php echo base_url('produto/'.$produto->pro_meta_link)?>">Ver Produto</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach;?>
                                    <?php else: ?>
                                        <div class="col-lg-12 text-center mt-0">
                                            <h5 class="mb-40">Infelizmente nao encontramos seu produto</h5>
                                            <img width="50%" src="<?php echo base_url('public/web/images/produto_nao_encontrado.svg')?>">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>