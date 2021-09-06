<div class="container" style="margin-top: 3rem;">
  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-blok">
              <h4 style="margin-top: 1rem;"><?php echo $titulo ?></h4>
            </div>
            <div class="card-body">
              <?php if (isset($pedidos)) : ?>
                <div class="table-responsive">
                  <table class="table table-striped data-table">
                    <thead>
                      <tr>
                        <th>Cód. do pedido</th>
                        <th>Data</th>
                        <th>Cliente</th>
                        <th>Frete</th>
                        <th>Status</th>
                        <th>Valor dos produtos</th>
                        <th>Valor do frete</th>
                        <th>Valor do final</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $grand_total_fretes = 0;
                      $gran_total_pedidos = 0
                      ?>
                      <?php foreach ($pedidos as $pedido) : ?>
                        <?php
                        $grand_total_fretes += $pedido->pedido_valor_frete;
                        $gran_total_pedidos += $pedido->pedido_valor_final;
                        ?>
                        <tr>
                          <td> <?php echo $pedido->pedido_codigo; ?> </td>
                          <td> <?php echo formata_data_banco_com_hora($pedido->pedido_data_cadastro); ?> </td>
                          <td> <?php echo $pedido->pedido_cliente_nome ?> </td>
                          <td> <?php echo ($pedido->pedido_forma_envio == 1 ? 'SEDEX' : 'PAC') ?> </td>
                          <td>
                            <?php
                            switch ($pedido->pedido_status) {
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
                          <td> <?php echo 'R$&nbsp;' . number_format($pedido->pedido_valor_produtos, 2) ?> </td>
                          <td> <?php echo 'R$&nbsp;' . number_format($pedido->pedido_valor_frete, 2) ?> </td>
                          <td> <?php echo 'R$&nbsp;' . number_format($pedido->pedido_valor_final, 2) ?> </td>
                        </tr>
                      <?php endforeach; ?>
                      <tr>
                        <th colspan="6" class="text-right">Total geral</th>
                        <td>R$ <?php echo number_format($grand_total_fretes, 2) ?> </td>
                        <td>R$ <?php echo number_format($gran_total_pedidos, 2) ?> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              <?php else : ?>
                <p class="text-center">Nao foi realizado nenhum pedido hoje</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>