<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <?php echo (isset($titulo) ? '<title> Store | ' . $titulo . '</title>' : '<title>Cincreti Store</title>') ?>
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/app.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/components.css'); ?>">
  <?php if (isset($styles)) : ?>
    <?php foreach ($styles as $style) : ?>
      <link rel="stylesheet" href="<?php echo base_url('public/assets/' . $style); ?>">
    <?php endforeach; ?>
  <?php endif; ?>
  <link rel="stylesheet" href="<?php echo base_url('public/assets/css/custom.css'); ?>">
  <link rel='shortcut icon' type='image/x-icon' href='' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">