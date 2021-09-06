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
                      <th>Cliente</th>
                      <th>E-mail</th>
                      <th>Data de cadastro</th>
                      <th>Nota</th>
                      <th class="nosort">Açao</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($avaliacoes as $avaliacao) : ?>
                      <tr>
                        <td> <?php echo $avaliacao->avaliacao_cliente_nome; ?> </td>
                        <td> <?php echo $avaliacao->client_email; ?> </td>
                        <td><?php echo formata_data_banco_com_hora($avaliacao->note_date_start); ?> </td>
                        <td> <?php echo $avaliacao->note ?> </td>
                        <td>
                          <a href="<?php echo base_url('restrita/avaliacoes/view/' . $avaliacao->note_id); ?>" data-toggle="tooltip" data-title="Detalhes da avaliação" class="btn btn-info btn-icon"><i class="fa fa-eye"></i></a> 
                          <a href="<?php echo base_url('restrita/avaliacoes/delete/' . $avaliacao->note_id); ?>" data-toggle="tooltip" data-title="Apagar" class="btn btn-danger btn-icon"><i class="fa fa-times "></i></a>
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