<?php $this->load->view('restrict/layout/navbar'); ?>
<?php $this->load->view('restrict/layout/sidebar'); ?>
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-block">
              <h4><?php echo $titulo; ?></h4>
              <a href="<?php echo base_url('restrict/products/core'); ?>" class="btn btn-primary float-right">Cadastrar</a>
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
                      <th>Código</th>
                      <th>Nome do produto</th>
                      <th>Marca</th>
                      <th>Categoria</th>
                      <th>Valor</th>
                      <th>Status</th>
                      <th class="nosort">Açao</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($produtos as $produto) : ?>
                      <tr>
                        <td> <?php echo $produto->pro_code; ?> </td>
                        <td> <?php echo word_limiter($produto->pro_name, 5); ?> </td>
                        <td> <?php echo $produto->brand_name ?> </td>
                        <td> <?php echo $produto->categorie_name ?> </td>
                        <td>R$ <?php echo number_format($produto->pro_value, 2) ?> </td>
                        <td> <?php echo ($produto->pro_active == 1 ? '<span class="badge badge-success">Ativa</span>' : '<span class="badge badge-danger">Inativa</span>') ?> </td>
                        <td>
                          <a href="<?php echo base_url('restrict/products/core/' . $produto->pro_id); ?>" class="btn btn-dark btn-icon"><i class="far fa-edit"></i></a>
                          <a href="<?php echo base_url('restrict/products/delete/' . $produto->pro_id); ?>" class="btn btn-danger btn-icon delete" data-confirm="Deseja mesmo apagar essa categorias Master?"><i class="fas fa-times"></i></a>
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
  <?php $this->load->view('restrict/layout/sidebar_settings'); ?>
</div>