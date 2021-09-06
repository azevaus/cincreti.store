<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html"> <img alt="image" src="<?php echo base_url('public/assets/img/logo_preto_horizontal.png') ?>" class="header-logo" /> 
    </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Main</li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'home' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict') ?>" class="nav-link"><i data-feather="home"></i><span>Home</span></a>
      </li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'clients' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict/clients') ?>" class="nav-link"><i data-feather="users"></i><span>Clientes</span></a>
      </li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'products' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict/products') ?>" class="nav-link"><i data-feather="archive"></i><span>Produtos</span></a>
      </li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'requests' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict/requests') ?>" class="nav-link"><i data-feather="shopping-cart"></i><span>Pedidos</span></a>
      </li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'transactions' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict/transactions') ?>" class="nav-link"><i data-feather="dollar-sign"></i><span>Transaçoes</span></a>
      </li>
      <li class="dropdown <?php echo $this->router->fetch_class() == 'users' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
        <a href="<?php echo base_url('restrict/users') ?>" class="nav-link"><i data-feather="users"></i><span>Usuários</span></a>
      </li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="home"></i><span>Minha loja</span></a>
        <ul class="dropdown-menu">
          <li class="dropdown">
            <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="package"></i><span>Categorias</span></a>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="<?php echo base_url('restrict/masters') ?>">Categorias Master</a></li>
            </ul>
            <ul class="dropdown-menu">
              <li><a class="nav-link" href="<?php echo base_url('restrict/categories') ?>">Categorias</a></li>
            </ul>
          </li>
          <li><a class="nav-link" href="<?php echo base_url('restrict/brands') ?>">Marcas</a></li>
          <li><a class="nav-link" href="<?php echo base_url('restrict/banners') ?>">Meus Banners</a></li>
          <li><a class="nav-link" href="<?php echo base_url('restrict/notes') ?>">Avaliacoes dos produtos</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="settings"></i><span>Configuraçoes</span></a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?php echo base_url('restrict/system') ?>">Sistema</a></li>
          <li><a class="nav-link" href="<?php echo base_url('restrict/system/correios') ?>">Correios</a></li>
          <li><a class="nav-link" href="<?php echo base_url('restrict/system/pagseguro') ?>">PagSeguro</a></li>
        </ul>
      </li>
      
    </ul>
  </aside>
</div>