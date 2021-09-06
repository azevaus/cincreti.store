<?php $this->load->view('web/layout/navbar'); ?>
<div class="breadcrumb-area">
                <div class="container">
                    <div class="breadcrumb-content">
                        <ul>
                            <li><a href="<?php echo base_url('/')?>">Home</a></li>
                            <li class="active"><?php echo $categoria?></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Li's Breadcrumb Area End Here -->
            <!-- Begin Li's Content Wraper Area -->
            <div class="content-wraper pt-60 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Begin Li's Banner Area -->
                            <div class="single-banner shop-page-banner">
                                <a href="#">
                                    <img src="<?php echo base_url('public/web/images/bg-banner/2.jpg')?>" alt="Li's Static Banner">
                                </a>
                            </div>

                            <div class="shop-products-wrapper">
                                <div class="tab-content">
                                    <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                                        <div class="product-area shop-product-area">
                                            <div class="row">
                                                <?php foreach($produtos as $produto):?>
                                                <div class="col-lg-3 col-md-4 col-sm-6 mt-40 mb-50">
                                                    <!-- single-product-wrap start -->
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
                                                                    <?php 
                                                                        switch($produto->nota){
                                                                            
                                                                            case  $produto->nota <= 1:
                                                                                echo '
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                                ';
                                                                                break;
                                                                            case $produto->nota >= 2 && $produto->nota < 3:
                                                                                echo '
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                                ';
                                                                                break;
                                                                            case $produto->nota >= 3 && $produto->nota < 4:
                                                                                echo '
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li lass="no-star"><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                                ';
                                                                                break;
                                                                            case $produto->nota >= 4 && $produto->nota < 5:
                                                                                echo '
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                                ';
                                                                                break;
                                                                            case $produto->nota >= 5:
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
                                                    <!-- single-product-wrap end -->
                                                </div>
                                                <?php endforeach;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- shop-products-wrapper end -->
                        </div>
                    </div>
                </div>
            </div>