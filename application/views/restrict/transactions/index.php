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
              <a id="btn_atualizar_massa" data-confirm="Está açao atualizará todas as transaçoes. E levará algum tempo para ser concluida. Tem certeza que quer prosseguir?" href="<?php echo base_url('restrita/transacoes/atualizar'); ?>" class="btn btn-danger float-right"><i class="fas fa-exclamation-triangle"></i>&nbsp;Atualizar em massa </a>
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
                      <th>Código da transaçao</th>
                      <th>Data</th>
                      <th>Método de pagamento</th>
                      <th>Status</th>
                      <th class="nosort">Açoes</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($transacoes as $transacao) : ?>
                      <tr>
                        <td> <?php echo $transacao->transacao_codigo_hash; ?> </td>
                        <td> <?php echo formata_data_banco_com_hora($transacao->transacao_data); ?> </td>
                        <td> 
                        <?php 
                            switch($transacao->transacao_tipo_metodo_pagamento){
                              case 1:
                                  echo '<div class="badge badge-shadow badge-success"><i class="fa fa-credit-card"></i>&nbsp;Cartao de crédito</div>';
                                  break;
                              case 2:
                                  echo '<div class="badge badge-shadow badge-dark"><i class="fa fa-barcode"></i>&nbsp;Boleto bancário</div>';
                                  break;
                              default:
                                  echo '<div class="badge badge-shadow badge-primary"><i class="fa fa-exchance-alt"></i>&nbsp;Transferencia bancária</div>';
                                  break;
                              }
                          ?>
                        </td>
                        <td> 
                          <?php 
                            switch($transacao->transacao_status){
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
                              default:
                                  echo '<div class="badge badge-shadow badge-warning">Status desconhecido/div>';
                                  break;
                              }
                          ?>
                        </td>
                        <td>
                          <a href="<?php echo base_url('restrita/transacoes/view/' . $transacao->transacao_id); ?>" data-toggle="tooltip" data-title="Detalhes da transaçao" class="btn btn-dark btn-icon"><i class="fa fa-eye"></i></a> 
                          <a href="<?php echo base_url('restrict/transactions/update/' . $transacao->transacao_codigo_hash); ?>" data-toggle="tooltip" data-title="Atualizar status" class="btn btn-info btn-icon"><i class="fas fa-sync-alt "></i></a>                         
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