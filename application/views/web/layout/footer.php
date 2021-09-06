<div class="footer">
    <div class="footer-static-middle">
        <div class="container">
            <div class="footer-logo-wrap pt-30 pb-15">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <ul class="des">
                            <?php $sistema = info_header_footer(); ?>
                            <li>
                                <span class="text-dark">Endereço: </span>
                                <span><?php echo $sistema->sistema_endereco . ' - ' . $sistema->sistema_numero . ' - ' . $sistema->sistema_cidade; ?>
                                <?php echo ' - ' . $sistema->sistema_estado . ' <br> ' . $sistema->sistema_cep.''?></span>
                            </li>
                            <li>
                                <span class="text-dark">Telefone: </span>
                                <span><?php echo $sistema->sistema_telefone_fixo . ' - ' . $sistema->sistema_telefone_movel ?></span>
                            </li>
                            <li>
                                <span class="text-dark">Email: </span>
                                <span><a href="mailto://<?php echo $sistema->sistema_email ?>"><?php echo $sistema->sistema_email ?></a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-6"></div>
                    <div class="col-lg-2 col-md-3 col-sm-6"></div>
                    <div class="col-lg-4">
                        <div class="footer-block">
                            <h4 class="footer-block-title">Confira mais sobre a Cincreti</h4>
                            <ul class="social-link text-center">
                                <li class="twitter">
                                    <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                                <li class="rss">
                                    <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="RSS">
                                        <i class="fa fa-rss"></i>
                                    </a>
                                </li>
                                <li class="google-plus">
                                    <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </li>
                                <li class="facebook">
                                    <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li class="youtube">
                                    <a href="https://www.youtube.com/" data-toggle="tooltip" target="_blank" title="Youtube">
                                        <i class="fa fa-youtube"></i>
                                    </a>
                                </li>
                                <li class="instagram">
                                    <a href="https://www.instagram.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="text-center"> ©2021 todos os direitos reservados Cincreti </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- SCRIPTS -->
<script src="<?php echo base_url('public/web/js/vendor/jquery-1.12.4.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/vendor/popper.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/ajax-mail.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.meanmenu.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/wow.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/slick.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.magnific-popup.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/isotope.pkgd.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/imagesloaded.pkgd.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.mixitup.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.countdown.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.counterup.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/waypoints.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.barrating.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery-ui.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/venobox.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/jquery.nice-select.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/scrollUp.min.js') ?>"></script>
<script src="<?php echo base_url('public/web/js/main.js') ?>"></script>
<script src="<?php echo base_url('public/assets/js/util.js'); ?>"></script>
<?php if (isset($scripts)) : ?>
    <?php foreach ($scripts as $script) : ?>
        <script src="<?php echo base_url('public/assets/' . $script); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>