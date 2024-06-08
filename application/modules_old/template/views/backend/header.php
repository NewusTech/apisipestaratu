<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo humanize($this->router->fetch_module()) ?> | Dashboard</title>
    <link href="<?php echo theme_assets('inspina') ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo theme_assets('inspina') ?>font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="<?php echo theme_assets('inspina') ?>css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <!-- Gritter -->
    <link href="<?php echo theme_assets('inspina') ?>js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
    <link href="<?php echo theme_assets('inspina') ?>css/animate.css" rel="stylesheet">
    <link href="<?php echo theme_assets('inspina') ?>css/style.css" rel="stylesheet">
    <!-- Load User Session On Main Header  -->
    <!-- Load Page CSS  -->
    <?php if(isset($header) && !empty($header)): ?>
        <?php foreach($header as $header): ?>
            <link href="<?php echo $header?>" rel="stylesheet">
        <?php endforeach ?>
    <?php endif ?>
</head>