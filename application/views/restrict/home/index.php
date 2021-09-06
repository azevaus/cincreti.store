<?php $this->load->view('restrict/layout/navbar'); ?>
<?php $this->load->view('restrict/layout/sidebar'); ?>
<div class="main-content">
  <section class="section">
    <div class="section-body">
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
      <div class="row">
        <div class="col-xl-3 col-lg-6">
          <div class="card">
            <div class="card-body card-type-3">
              <div class="row">
                <div class="col">
                  <h6 class="text-muted mb-0">Vendas concluídas</h6>
                  <span class="font-weight-bold mb-0 font-28"><?php echo $vendas_concluidas ?></span>
                </div>
                <div class="col-auto">
                  <div class="card-circle bg-success text-white p-4">
                    <i class="fas fa-shopping-cart"></i>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card">
            <div class="card-body card-type-3">
              <div class="row">
                <div class="col">
                  <h6 class="text-muted mb-0">Vendas canceladas</h6>
                  <span class="font-weight-bold mb-0 font-28"><?php echo $vendas_canceladas ?></span>
                </div>
                <div class="col-auto">
                  <div class="card-circle bg-danger text-white p-4">
                    <i class="fas fa-strikethrough"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card">
            <div class="card-body card-type-3">
              <div class="row">
                <div class="col">
                  <h6 class="text-muted mb-0">Total de clientes</h6>
                  <span class="font-weight-bold mb-0 font-28"><?php echo $total_clientes ?></span>
                </div>
                <div class="col-auto">
                  <div class="card-circle bg-primary text-white p-4">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card">
            <div class="card-body card-type-3">
              <div class="row">
                <div class="col">
                  <h6 class="text-muted mb-0">Total de vendas</h6>
                  <span class="font-weight-bold mb-0 font-28"><?php echo 'R$&nbsp' . ($total_vendas->total_vendas != null ? number_format($total_vendas->total_vendas) : '0,') ?></span>
                </div>
                <div class="col-auto">
                  <div class="card-circle bg-teal text-white p-4">
                    <i class="fas fa-dollar-sign"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row ">
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Pagamentos com cartao</h5>
                      <h2 class="mb-3 font-28"><?php echo $pagamentos_cartao ?></h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="<?php echo base_url('public/assets/img/pagamentos_cartao.svg') ?>" width="60%" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15"> Pagamentos com boleto</h5>
                      <h2 class="mb-3 font-28"><?php echo $pagamentos_boleto ?></h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="<?php echo base_url('public/assets/img/pagamentos_boleto.svg') ?>" width="83%" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="card">
            <div class="card-statistic-4">
              <div class="align-items-center justify-content-between">
                <div class="row ">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                    <div class="card-content">
                      <h5 class="font-15">Pagamento via transferencia</h5>
                      <h2 class="mb-3 font-28"><?php echo $pagamentos_transferencia ?></h2>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                    <div class="banner-img">
                      <img src="<?php echo base_url('public/assets/img/pagamentos_transferencia.svg') ?>" width="66%" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
  <?php $this->load->view('restrict/layout/sidebar_settings'); ?>
</div>