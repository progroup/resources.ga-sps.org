<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="<?php echo $page->description()->or($site->description()) ?>">
    <meta name="keywords" content="<?php echo $page->keywords()->or($site->keywords()) ?>">
    <title><?php echo $page->title()->html() ?> | <?php echo $site->title()->html() ?></title>
    <link rel="alternate" type="application/rss+xml" title="Resources" href="/resources/rss/">    
    <?php echo css('//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css') ?>
    <?php echo css('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css') ?>
    <?php echo css('//fonts.googleapis.com/css?family=Roboto:300,400,700') ?>
    <?php if ($page->isHomePage()) : ?>
        <?php echo css('assets/royalslider/royalslider.css') ?>
    <?php endif ?>
    <?php echo css('assets/css/app.css') ?>
    <?php echo css('assets/css/style.css') ?>
    <?php echo css('assets/css/flaticon.css') ?>

    
    <!--[if lt IE 9]>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body class="site <?php echo $page->uid() ?>">
<?php snippet('nav') ?>
<main class="site-content">
