<!doctype html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <title>Application Cinema</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

            <!-- Open Sans font from Google CDN -->
            <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

            <!-- Pixel Admin's stylesheets -->
            <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
            <link href="<?php echo base_url('assets/css/pixel-admin.min.css'); ?>" rel="stylesheet" type="text/css">
            <link href="<?php echo base_url('assets/css/widgets.min.css'); ?>" rel="stylesheet" type="text/css">
            <link href="<?php echo base_url('assets/css/rtl.min.css'); ?>" rel="stylesheet" type="text/css">
            <link href="<?php echo base_url('assets/css/themes.min.css'); ?>" rel="stylesheet" type="text/css">

            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

            <!-- css perso -->
            <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css'); ?>">

            <!--[if lt IE 9]>
            <script src="<?php echo base_url('assets/js/ie.min.js'); ?>"></script>
            <![endif]-->
        </head>


        <body class="theme-asphalt main-menu-animated">

        <script>var init = [];</script>


        <script type="text/javascript">

            init.push(function() {

                $( ".searchfilms" ).autocomplete({
                    source: function (request, response) {

                        $.ajax({
                            url: "<?php echo site_url('movie/ajaxmovies') ?>",
                            type: "POST",
                            data: { mot: request.term },
                            minLength: 2,
                            dataType: "json",
                            success: function (data) {

                                var transformed = $.map(data, function (el) {
                                    return {
                                        label: el.mtitle
                                    };
                                });

                                response(transformed);
                            }

                        });
                    }
                });
            });

        </script>




        <div id="main-wrapper">


            <!-- 2. $MAIN_NAVIGATION ===========================================================================

                Main navigation
            -->
            <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
            <!-- Main menu toggle -->
            <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

            <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">

                <!-- Logo -->
                <a href="<?php echo site_url("welcome/index") ?>" class="navbar-brand">

                    <div><img alt="Pixel Admin" src="http://assistance.orange.fr/Image/2173_logo-cine-plus-club.png"></div>
                    Cinema - Gestion
                </a>

                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

            </div> <!-- / .navbar-header -->

            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
            
            <?php $user  = $this->session->userdata('user'); ?>
            <div>

            <ul class="nav navbar-nav">
                <?php if(!empty($user)){ ?>
                    <li <?php if (uri_string() == 'welcome/index') { ?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('welcome/index'); ?>"><i class="fa fa-home"></i> Accueil</a>
                    </li>
                    <li <?php if (uri_string() == 'movie/lister') { ?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('movie/lister'); ?>"><i class="fa fa-film"></i> Films</a>
                    </li>
                    <li <?php if (uri_string() == 'categorie/lister') { ?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('categorie/lister'); ?>"><i class="fa fa-tasks"></i> Catégories</a>
                    </li>
                    <li <?php if (uri_string() == 'acteur/lister') { ?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('acteur/lister'); ?>"><i class="fa fa-users"></i> Acteurs</a>
                    </li>
                    <li <?php if (uri_string() == 'realisateur/lister') { ?>class="active" <?php } ?>>
                        <a href="<?php echo site_url('realisateur/lister'); ?>"><i class="fa fa-video-camera"></i> Réalisateurs</a>
                    </li>

                    <li class="dropdown 
                    <?php if ($this->uri->segment(1) == "tag" 
                            || $this->uri->segment(1) == "cinema" 
                            || $this->uri->segment(1) == "seance"
                            || $this->uri->segment(1) == "comment"
                            || $this->uri->segment(1) == "user"
                            || $this->uri->segment(1) == "album"
                    )
                     { ?>active <?php } ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i> Plus</a>
                        <ul class="dropdown-menu">
                            <li <?php if (uri_string() == 'tag/lister') { ?>class="active" <?php } ?>>
                                <a href="<?php echo site_url('tag/lister'); ?>"><i class="fa fa-tags"></i> Tags</a>
                            </li>
                            <li <?php if (uri_string() == 'cinema/lister') { ?>class="active" <?php } ?>>
                                <a href="<?php echo site_url('cinema/lister'); ?>"><i class="fa fa-simplybuilt"></i> Cinemas</a>
                            </li>
                            <li <?php if (uri_string() == 'seance/lister') { ?>class="active" <?php } ?>>
                                <a href="<?php echo site_url('seance/lister'); ?>"><i class="fa fa-ticket"></i> Séances</a>
                            </li>
                            <li <?php if (uri_string() == 'comment/lister') { ?>class="active" <?php } ?>>
                                <a href="<?php echo site_url('comment/lister'); ?>"><i class="fa fa-comments"></i> Commentaires</a>
                            </li>
                                <?php $user = $this->session->userdata('user'); ?>
                                <?php if(!empty($user) && $user->is_admin == 2){ ?>
                                    <li <?php if (uri_string() == 'user/lister') { ?>class="active" <?php } ?>>
                                        <a href="<?php echo site_url('user/lister'); ?>"><i class="fa fa-users"></i> Utilisateurs</a>
                                    </li>
                                <?php } ?>
                            <li <?php if (uri_string() == 'album/lister') { ?>class="active" <?php } ?>>
                                <a href="<?php echo site_url('album/lister'); ?>"><i class="fa fa-picture-o"></i> Album photos</a>
                            </li>

                        </ul>
                    </li>




                    <?php } ?>
            </ul> <!-- / .navbar-nav -->

            <div class="right clearfix">
            <ul class="nav navbar-nav pull-right right-navbar-nav">

            <!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================

                                        Navbar Icon Buttons

                                        NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.

                                        Classes:
                                        * 'nav-icon-btn-info'
                                        * 'nav-icon-btn-success'
                                        * 'nav-icon-btn-warning'
                                        * 'nav-icon-btn-danger'

            <li class="nav-icon-btn nav-icon-btn-danger dropdown">
                <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="label">5</span>
                    <i class="nav-icon fa fa-bullhorn"></i>
                    <span class="small-screen-text">Notifications</span>
                </a>
             -->
                <!-- NOTIFICATIONS -->

                <!-- Javascript -->
                <script>
                    init.push(function () {
                        $('#main-navbar-notifications').slimScroll({ height: 250 });
                    });
                </script>
                <!-- / Javascript -->

                <?php 
                    $panier = $this->panier->getPanier();
                    $nbtotal = $this->panier->countItem();

                ?>
            </li>

            <li class="nav-icon-btn nav-icon-btn-success dropdown">
                <a href="#messages" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="label"><?php echo $nbtotal; ?></span>
                    <i class="nav-icon fa fa-shopping-cart"></i>
                    <span class="small-screen-text">Income messages</span>
                </a>

                <!-- MESSAGES -->

                <!-- Javascript -->
                <script>
                    init.push(function () {
                        $('#main-navbar-messages').slimScroll({ height: 250 });
                    });
                </script>
                <!-- / Javascript -->

                <?php if(!empty($user)) { ?>
                <div class="dropdown-menu widget-messages-alt no-padding" style="width: 300px;">
                    <div class="messages-list" id="main-navbar-messages">

                        <?php if(!empty($user) && !empty($panier)) { ?>
                            <?php foreach($panier as $movie){ ?>
                                <div class="message">
                                    <span class="pull-right badge badge-danger">X <?php echo $movie['quantity'] ?></span>

                                    <img src="<?php echo $movie['image'] ?>" alt="" class="message-avatar">
                                    <a href="" class="message-subject"><?php echo $movie['title'] ?> <br /><?php echo $movie['price'] ?> €</a>
                                </div> <!-- / .message -->
                            <?php } } else{ ?>
                                <div class="alert alert-danger alert-dark"> Votre panier est vide </div>
                            <?php } ?>


                    </div> <!-- / .messages-list -->
                    <a href="<?php echo site_url('movie/recapitulatif') ?>" class="messages-link"><span class="fa fa-plus"></span> Récapitulatif de commentande</a>
                </div> <!-- / .dropdown-menu -->
            </li>
            <!-- /3. $END_NAVBAR_ICON_BUTTONS -->

            <li>
                <form class="navbar-form pull-left" method="post" action="<?php echo site_url('Movie/rechercher'); ?>">
                    <input type="text" class="form-control searchfilms" placeholder="Rechercher" required name="mot" value="<?php echo set_value('mot'); ?>" >
                </form>
            </li>

            <li>
                <a target="_blank" href="<?php echo site_url('frontend/index') ?>"><i class="fa fa-star"></i> Front-Office</a>
            </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                        <img src="<?php echo $user->avatar ?>" >
                        <span><?php echo $user->email ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url('welcome/logout'); ?>"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Deconnexion</a></li>
                    </ul>
                </li>

                <?php } ?>

            </ul> <!-- / .navbar-nav -->
            </div> <!-- / .right -->
            </div>
            </div> <!-- / #main-navbar-collapse -->
            </div> <!-- / .navbar-inner -->
            </div> <!-- / #main-navbar -->
            <!-- /2. $END_MAIN_NAVIGATION -->
