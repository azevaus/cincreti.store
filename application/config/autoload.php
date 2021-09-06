<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$autoload['packages'] = array();
$autoload['libraries'] = array(
    'ion_auth', 
    'database', 
    'form_validation', 
    'carrinho_compras',
    'user_agent',
    'favoritos_compras'
);
$autoload['drivers'] = array();
$autoload['helper'] = array('url', 'array', 'recursos', 'string', 'text');
$autoload['config'] = array();
$autoload['language'] = array();
$autoload['model'] = array(
    'core_model',
    'produtos_model',
    'store_model',
    'pedidos_model',
    'home_model'
);