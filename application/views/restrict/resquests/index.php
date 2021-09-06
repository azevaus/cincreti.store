<?php $this->load->view('restrita/layout/navbar'); ?>
<?php $this->load->view('restrita/layout/sidebar'); ?>
<div class="main-content">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-block">
              <h4 class="mb-4 mt-3"><?php echo $titulo?></h4>
              <div class="dropdown d-inline mr-2">
                <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton3"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Relatórios
                </button>
                <div class="dropdown-menu">
                  <a target="_blanck" class="dropdown-item" href="<?php echo base_url('restrita/pedidos/diarias')?>">Vendas diárias</a>
                  <a target="_blanck" class="dropdown-item" href="<?php echo base_url('restrita/pedidos/vendidos')?>">Produtos mais vendidos</a>
                </div>
              </div>
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
                      <th>Data do pedido</th>
                      <th>Cliente</th>
                      <th>Valor do pedidos</th>
                      <th>Status</th>
                      <th class="nosort">Açao</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($pedidos as $pedido) : ?>
                      <tr>
                        <td> <?php echo $pedido->pedido_codigo; ?> </td>
                        <td> <?php echo formata_data_banco_com_hora($pedido->pedido_data_cadastro); ?> </td>
                        <td> <?php echo $pedido->pedido_cliente_nome ?> </td>
                        <td>R$ <?php echo number_format($pedido->pedido_valor_final, 2) ?> </td>
                        <td> 
                          <?php 
                            switch($pedido->pedido_status){
                              case 1:
                                  echo '<div class="badge badge-shadow badge-warning">Aguardando pagamento</div>';
                                  break;
                              case 2:
                                  echo '<div class="badge badge-shadow badge-info">Em análise</div>';
                                  break;
                              case 3:
                                  echo '<div class="badge badge-shadow badge-success">Paga</div>';
                                  break;
                              case 4:
                                  echo '<div class="badge badge-shadow badge-success">Disponível</div>';
                                  break;
                              case 5:
                                  echo '<div class="badge badge-shadow badge-warning">Em disputa</div>';
                                  break;
                              case 6:
                                  echo '<div class="badge badge-shadow badge-dark">Devolvida</div>';
                                  break;
                              case 7:
                                  echo '<div class="badge badge-shadow badge-danger">Cancelada</div>';
                                  break;
                              case 8:
                                  echo '<div class="badge badge-shadow badge-success">Debitada</div>';
                                  break;
                              case 9:
                                  echo '<div class="badge badge-shadow badge-warning">Retençao temporária/div>';
                                  break;
                              }
                          ?>
                        </td>
                        <td>
                          <a target="_blank" href="<?php echo base_url('restrita/pedidos/imprimir/' . $pedido->pedido_codigo); ?>" class="btn btn-dark btn-icon"><i class="fa fa-print"></i></a>
                          
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