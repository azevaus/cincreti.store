<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a></li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
      <i data-feather="maximize"></i> </a></li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">    
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
      <i class="fas fa-user-cog text-dark"></i><span class="d-sm-none d-lg-inline-block"></span></a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title">Olá.</div>
        <a href="<?php echo base_url('restrita/usuarios/core/'.$this->session->userdata('user_id')) ?>" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil</a> 
        <div class="dropdown-divider"></div>
        <a href="<?php echo base_url('restrita/login/logout')?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>Sair</a>
      </div>
    </li>
  </ul>
</nav>