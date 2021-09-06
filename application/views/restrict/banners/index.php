<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-block">
              <h4><?php echo $titulo; ?></h4>
              <a href="<?php echo base_url('restrita/banners/core'); ?>" class="btn btn-primary float-right">Cadastrar</a>
            </div>
            <div class="card-body">
              <?php if ($message = $this->session->flashdata('sucesso')) : ?>
                <div class="alert alert-success alert-dismissible alert-has-icon">
                  <div class="alert-icon"><i class="fas fa-check-circle"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Perfeito!</div>
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    <?php echo $message ?>
                  </div>
                </div>
              <?php endif; ?>
              <?php if ($message = $this->session->flashdata('erro')) : ?>
                <div class="alert alert-danger alert-dismissible alert-has-icon">
                  <div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Atençao</div>
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    <?php echo $message ?>
                  </div>
                </div>
              <?php endif; ?>
              <div class="table-responsive">
                <table class="table table-striped data-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nome</th>
                      <th>Arquivo</th>
                      <th class="nosort">Açao</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($banners as $banner) : ?>
                      <tr>
                        <td> <?php echo $banner->banner_id; ?> </td>
                        <td> <?php echo $banner->banner_nome; ?> </td>
                        <td> <?php echo $banner->banner_foto_caminho ?> </td>
                        <td>
                          <a href="<?php echo base_url('restrita/banners/core/' . $banner->banner_id); ?>" class="btn btn-dark btn-icon"><i class="far fa-edit"></i></a>
                          <a href="<?php echo base_url('restrita/banners/delete/' . $banner->banner_id); ?>" class="btn btn-danger btn-icon delete" data-confirm="Deseja mesmo apagar essa categorias Master?"><i class="fas fa-times"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php $this->load->view('restrita/layout/sidebar_settings'); ?>
</div>