<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['restrict'] = 'restrict/home/index';
$route['product/(:any)'] = 'product/index/$1';
$route['masters/(:any)'] = 'masters/index/$1';
$route['categorie/(:any)'] = 'categories/index/$1';
$route['brands/(:any)'] = 'brands/index/$1';
$route['busca'] = 'busca/index/';
$route['sucesso'] = 'pay/sucesso/';

