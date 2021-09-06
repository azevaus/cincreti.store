
<?php $this->load->view('web/layout/navbar'); ?>
<!-- BANNERS DO SLIDER-->
<div class="slider-with-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-8">
                <div class="slider-area">
                    <div class="slider-active owl-carousel">
                        <?php foreach($produtos_destaques as $produto):?>
                            <div class="single-slide align-center-left animation-style-01 bg-1" style="background-image: url(<?php echo base_url('public/web/images/slider/4.jpg') ?>);">
                                
                                <div class="slider-content">
                                    <h5>Ofertas <span>-20% Off</span> Esta semana</h5>
                                    <h2><?php echo word_limiter($produto->pro_name,2)?></h2>
                                    <h3>Compre por <span><?php echo 'R$&nbsp;'. number_format($produto->pro_value, 2)?></span></h3>
                                    <div class="default-btn slide-btn">
                                        <a class="links" href="<?php echo base_url('produto/'.$produto->pro_meta_link)?>">Compre Agora</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- FIM DO SLIDER-->
<!-- PRODUTOS APRESENTADOS-->
<div class="product-area pt-60 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#li-new-product"><span>em destaque</span></a></li>
                    </ul>               
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="li-new-product" class="tab-pane active show" role="tabpanel">
                <div class="row">                
                    <div class="product-active owl-carousel"> <!-- PRODUTOS EM DESTAQUE -->
                        <?php foreach($produtos_destaques as $produto): ?>
                            <div class="col-lg-12">                                    
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">
                                            <img style="width: 206px; height: 206px" src="<?php echo base_url('uploads/products/'.$produto->photo_path); ?>" alt="<?php echo word_limiter($produto->pro_name, 3)?>">
                                        </a>
                                        <span class="sticker">New</span>
                                    </div>
                                    <div class="product_desc"> 
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    <a href="<?php echo base_url('produto/avaliacoes')?>">Avaliações</a>
                                                </h5>
                                                <div class="rating-box">
                                                    <ul class="rating">
                                                    <?php 
                                                        switch($produto->nota){
                                                            case  $produto->nota == 0 && $produto->nota < 1:
                                                                echo '
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                ';
                                                                break;
                                                            case  $produto->nota >= 1 && $produto->nota < 2:
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
                                            <h4><a class="product_name" href="single-product.html"><?php echo word_limiter($produto->pro_name, 3)?></a></h4>
                                            <div class="price-box">
                                                <span class="new-price"><?php echo 'R$&nbsp;'. number_format($produto->pro_value, 2)?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active"><a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">Ver Produto</a></li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        <?php endforeach; ?>
                    </div>                    
                </div>
            </div>            
        </div>
    </div>
</div>
<!-- FIM DOS PRODUTOS APRESENTADOS-->
<!-- PRODUTOS DE UMA CATEGORIA-->
<section class="product-area li-laptop-product pt-60 pb-45">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#li-new-product"><span>+ vendidos</span></a></li>
                    </ul>               
                </div>
                <div class="row">                                
                    <div class="product-active owl-carousel">
                        <?php foreach($produtos_mais_vendidos as $produto): ?>
                            <div class="col-lg-12">                                    
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">
                                            <img style="width: 206px; height: 206px" src="<?php echo base_url('uploads/products/'.$produto->photo_path); ?>" alt="<?php echo word_limiter($produto->pro_name, 3)?>">
                                        </a>
                                        
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    <a href="shop-left-sidebar.html">Avaliações</a>
                                                </h5>
                                                <div class="rating-box">
                                                    <ul class="rating">
                                                        <?php 
                                                            switch($produto->nota){
                                                            case  $produto->nota == 0 && $produto->nota < 1:
                                                                echo '
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                                <li class="no-star"><i class="fa fa-star-o"></i></li>                                                                            
                                                                ';
                                                                break;
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
                                            <h4><a class="product_name" href="single-product.html"><?php echo word_limiter($produto->pro_name, 3)?></a></h4>
                                            <div class="price-box">
                                                <span class="new-price"><?php echo 'R$&nbsp;'. number_format($produto->pro_value, 2)?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active"><a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">Ver Produto</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        <?php endforeach; ?>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- FIM DOS PRODUTOS POR CATEGORIAS-->
<section class="product-area li-laptop-product pt-60 pb-45 mb-45">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li><a class="active" data-toggle="tab" href="#li-new-product"><span>acessorios</span></a></li>
                    </ul>               
                </div>
                <div class="row">                                
                    <div class="product-active owl-carousel">
                        <?php foreach($produtos_categoria as $produto): ?>
                            <div class="col-lg-12">                                    
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">
                                            <img style="width: 206px; height: 206px" src="<?php echo base_url('uploads/products/'.$produto->photo_path); ?>" alt="<?php echo word_limiter($produto->pro_name, 3)?>">
                                        </a>
                                        
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    <a href="shop-left-sidebar.html">Avaliações</a>
                                                </h5>
                                                <div class="rating-box">
                                                    <ul class="rating">   
                                                        <li>
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
                                                        </li>  
                                                    </ul>
                                                </div>
                                            </div>
                                            <h4><a class="product_name" href="single-product.html"><?php echo word_limiter($produto->pro_name, 3)?></a></h4>
                                            <div class="price-box">
                                                <span class="new-price"><?php echo 'R$&nbsp;'. number_format($produto->pro_value, 2)?></span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active"><a href="<?php echo base_url('product/'.$produto->pro_meta_link)?>">Ver Produto</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        <?php endforeach; ?>
                    </div>   
                </div>
            </div>
        </div>
    </div>
</section>
<!-- POLITICA DE PRIVACIDADE -->
<div class="modal" id="mymodal" tabindex="-1" role="dialog" style="position: fixed; top: 80%; right: 0; bottom:0; z-index:1050; display:block; overflow: hidden;outline:0;">
  <div class="modal-dialog modal-lg" role="document" style="max-width: 79%;">
    <div class="modal-content">      
      <div class="modal-body" style="display: flex; justify-content:space-between;align-items: baseline;">
        <p>a gente usa cookies para personalizar anúncios e melhorar a sua experiência no site. Ao continuar navegando, você concorda com a nossa <a href="#">Política de Privacidade</a>.</p> 
        <button type="button" class="btn add-to-cart" style="background-color: #1c1c1c;color:#fff; border-radius:3px;">Aceitar e continuar</button>
      </div>      
    </div>
  </div>
</div>
<!-- FIM DA POLITICA DE PRIVACIDADE -->
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<script>
    $('button').click(function(){
        $('#mymodal').css({display:'none'});
    });
</script>
<!-- *************************************************************************************-->