<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pulse</title>
    <meta name="description" content="...">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

    <!-- CSS -->
    <link href="<?php echo base_url('assets/frontend/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/frontend/css/style.css'); ?>" rel="stylesheet">

    <link href="<?php echo base_url('assets/frontend/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/frontend/css/owl.carousel.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/frontend/css/animate.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/frontend/css/magnific-popup.css'); ?>" rel="stylesheet">


    <!-- Modernizr -->
    <script src="<?php echo base_url('assets/frontend/js/modernizr-2.6.2.min.js'); ?>"></script>

    <!-- Google font -->
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900' rel='stylesheet' type='text/css'>

    <script>
        var mainColor = 'blue';
    </script>
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="70">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="wrapper">

    <!-- Home: carousel -->
    <div id="home" class="section carousel slide home-carousel carousel-fade" data-ride="carousel">

        <!-- Wrapper for slides -->
        <div class="carousel-inner">


            <?php
            $i = 1;
            foreach($sliders as $slider) { ?>

                <!-- Carrousel -->
                <style type="text/css">
                    #home .carousel-inner .item.item-<?php echo $i; ?> {
                        background-image: url(<?php echo $slider->image; ?>);
                    }
                </style>

                <div class="item item-<?php echo $i; ?> <?php if ($i==1) { ?>active<?php }else{ ?> striped-image<?php } ?>">
                    <div class="container">
                        <div class="content">
                            <div class="logo wow bounceInDown" data-wow-duration="1s" data-wow-delay=".5s"><div class="wrap"><div><i class="fa fa-film"></i></div></div></div>
                            <div class="text font-white">
                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2">
                                        <h1 class="wow bounceInUp"><?php echo $slider->title; ?></h1>
                                        <h2 class="wow bounceInDown">Catégorie: <?php echo $slider->categorie; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $i++; ?>

            <?php } ?>


        </div>

        <!-- Controls -->
        <div class="carousel-controls">
            <div class="carousel-nav">
                <div class="container">
                    <a class="prev carousel-control" href=".home-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    <a class="next carousel-control" href=".home-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- Scroll to the next section -->
        <a class="j-scroll scrollDown" href="#features">
            <span class="fa fa-arrow-circle-down"></span>
        </a>
    </div>

    <!-- Header -->
    <header id="header">
        <!-- Static navbar -->
        <div class="navbar navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle visible-xs" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand j-scroll" href="#home">Cinema</a>
                </div>
                <nav class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#home" class="j-scroll" title="Home">Accueil</a></li>
                        <li><a href="#features" class="j-scroll" title="Features">Acteurs</a></li>
                        <li><a href="#portfolio" class="j-scroll" title="Portfolio">Séances</a></li>
                        <li><a href="#about" class="j-scroll" title="About">Catégories</a></li>
                        <li><a href="#blog" class="j-scroll" title="Blog">Films</a></li>
                        <li><a href="#team" class="j-scroll" title="Our Team">Réalisateurs</a></li>
                        <li><a href="#pricing" class="j-scroll" title="Pricing">Prix</a></li>
                        <li><a href="#contact" class="j-scroll" title="Contact">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>