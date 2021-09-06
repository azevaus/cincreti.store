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
              <?php if (isset($produtos)) : ?>
                <div class="table-responsive">
                  <table class="table table-striped data-table">
                    <thead>
                      <tr>
                        <th>Nome do produto</th>
                        <th>Valor unitário</th>
                        <th class="text-center">Quantidade</th>
                      </tr>
                    </thead>
                    <tbody>                      
                      <?php foreach ($produtos as $produto) : ?> 
                        <tr>                       
                          <td> <?php echo word_limiter($produto->produto_nome, 8); ?> </td>
                          <td> <?php echo 'R$&nbsp;'. number_format($produto->produto_valor_unitario. 2) ?> </td>
                          <td class="text-center"> <div class="badge badge-primary badge-shadow"><?php echo $produto->vendidos?></div> </td>       
                        </tr>                   
                      <?php endforeach; ?>                      
                    </tbody>
                  </table>
                </div>
              <?php else : ?>
                <p class="text-center">Nao foi encontrado dados de produtos mais vendidos</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>