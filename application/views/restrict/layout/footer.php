<?php if ($this->router->fetch_class() != 'login') : ?>
  <?php if ($this->router->fetch_method() != 'imprimir') : ?>
    <?php if ($this->router->fetch_method() != 'diarias') : ?>
      <?php if ($this->router->fetch_method() != 'vendidos') : ?>
        <footer class="main-footer">
          <div class="footer-left">
            <a href="#">Layout Templateshub - Sistema desenvolvido por Azevaus</a></a>
          </div>
          <div class="footer-right">
          </div>
        </footer>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>
</div>
</div>
<script src="<?php echo base_url('public/assets/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('public/assets/js/util.js'); ?>"></script>
<?php if (isset($scripts)) : ?>
  <?php foreach ($scripts as $script) : ?>
    <script src="<?php echo base_url('public/assets/' . $script); ?>"></script>
  <?php endforeach; ?>
<?php endif; ?>
<script src="<?php echo base_url('public/assets/js/scripts.js'); ?>"></script>
<!-- Custom JS File -->
<script src="<?php echo base_url('public/assets/js/custom.js'); ?>"></script>
<script>
  $('.delete').on("click", function(event) {
    event.preventDefault();
    var choice = confirm($(this).attr('data-confirm'));
    if (choice) {
      window.location.href = $(this).attr('href');
    }
  });
  $('#btn_atualizar_massa').on("click", function(event) {
    event.preventDefault();
    var choice = confirm($(this).attr('data-confirm'));
    if (choice) {
      window.location.href = $(this).attr('href');
    }
  });
</script>
</body>

</html>