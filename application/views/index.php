<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<script type="text/javascript"src="https://maps.googleapis.com/maps/api/js"></script>

<script>

    init.push(function () {

        $('.removetweet').click(function(e){
            e.preventDefault(); // j'annule l'évènement href de redirection quand je clique sur mon lien

            var current = $(this); // je récupère mon élément courant sur lequel je fais mon évènement clique

            //module AJAX en Jquery
            $.ajax({
                type: 'GET', // type de la requête : GET/POST
                url: current.attr('href'), // URL d'envoie de ma requête

                // le data réceptionne les données envoyées par le contrôleur
                success: function(data) {
                    // ligne ci-dessous pour activer le flash data
                    $.growl.notice({ message: data });

                    current.parents('.message').slideUp('slow');
                },

                error: function() {
                    alert('la requète n\'a pas abouti');
                }
            });
        });

        $('#addtweet').submit(function(e) {
            e.preventDefault();

            var current = $(this);

            $.ajax({
                type: 'POST',
                url: current.attr('action'), // URL d'envoie de ma requête
                data: {tweet: current.find('textarea').val() }
                });

            $.growl.notice({ message: 'Tweet ajouté !' });

            current.find('textarea').val('');

            return false; //Pour annuler l'envoi
        });



        function ajaxTweets() {

            $.ajax({
                url: "<?php echo site_url('welcome/ajaxtweets'); ?>",

                success: function(data) {
                    $('#tweets .block-tweets').html(data); // data modélise la réponse du serveur
                        setTimeout(ajaxTweets, 10000); //setTimeout
                }
            });

        };

        ajaxTweets();




    /**
     * Google Map à compléter pour l'exercice
     */
    var myLatlng = new google.maps.LatLng(45.764043,4.835659);
    var myLatlng2 = new google.maps.LatLng(45.763714, 4.850594);
    var mapOptions = {
        zoom: 15,
        center: myLatlng
    }
    var map = new google.maps.Map(document.getElementById("widget-maps-example"), mapOptions);

    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
        '<div id="bodyContent">'+
        '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
        'sandstone rock formation in the southern part of the '+
        'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
        'south west of the nearest large town, Alice Springs; 450&#160;km '+
        '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
        'features of the Uluru - Kata Tjuta National Park. Uluru is '+
        'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
        'Aboriginal people of the area. It has many springs, waterholes, '+
        'rock caves and ancient paintings. Uluru is listed as a World '+
        'Heritage Site.</p>'+
        '<p>Attribution: Uluru, <a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
        'http://en.wikipedia.org/w/index.php?title=Uluru</a> '+
        '(last visited June 22, 2009).</p>'+
        '</div>'+
        '</div>';


    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    // To add the marker to the map, use the 'map' property
    var marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        title:"Coucou 3WA!",
        draggable:true,
        animation: google.maps.Animation.DROP,
        title: 'Uluru (Ayers Rock)'

    });

    // To add the marker to the map, use the 'map' property
    var marker2 = new google.maps.Marker({
        position: myLatlng2,
        map: map,
        title:"Hello la promo L3!",
        draggable:true,
        animation: google.maps.Animation.DROP,
        title: 'Uluru (Ayers Rock)'

    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
    });



});
</script>


            <div id="content-wrapper">

            <div class="page-header">

                <div class="row">
                    <!-- Page header, center on small screens -->
                    <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Dashboard</h1>

                    <div class="col-xs-12 col-sm-8">
                        <div class="row">
                            <hr class="visible-xs no-grid-gutter-h">
                            <!-- Margin -->
                            <div class="visible-xs clearfix form-group-margin"></div>

                            <form method="post" action="<?php echo site_url('Movie/rechercher'); ?>" class="pull-right col-xs-12 col-sm-6">
                                <div class="input-group no-margin">
                                    <span class="input-group-addon" style="border:none;background: #fff;background: rgba(0,0,0,.05);"><i class="fa fa-search"></i></span>
                                    <input type="text" placeholder="Rechercher un film..." required name="mot" class="form-control no-padding-hr" style="border:none;background: #fff;background: rgba(0,0,0,.05);">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            // Je récupère mon message flash grace à ma clé success
            $message = $this->session->flashdata('success');
            if(!empty($message)) { ?>

                <script>
                    init.push(function () {
                        $.growl.notice({ message: "<?php echo $message; ?>" });
                    });
                </script>

            <?php } ?>



<!--            Google Map à compléter-->
            <div class="row">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title"><i class="panel-title-icon fa fa-map-marker"></i>Les prochaines séances</span>
                    </div> <!-- / .panel-heading -->
                    <div class="panel-body" style="position:relative;height: 300px;">
                        <div class="widget-maps" id="widget-maps-example" >
                        </div> <!-- / .panel-body -->
                    </div>
                </div>
            </div>
<!--            Fin Google Map à compléter-->

                <div class="row"> <!-- Div row qui contient les films à l'affiche
                 et les films les plus attendus -->

                    <div class="col-md-6" id="filmsaffiches"> <!-- Films à l'affiche -->
                        <h1 class="text-primary text-center"><i class="fa fa-film"></i> Films à l'affiche</h1>

                        <?php foreach($filmsaffiches as $film){ ?>
                        <div class="panel panel-info panel-dark">
                            <div class="panel-heading">
                                <span class="panel-title"><strong><?php echo $film->title; ?></strong></span>
                                <div class="panel-heading-controls">
                                    <span class="label label-default"><i class="fa  fa-clock-o"></i> <?php echo $film->annee; ?></span>
                                    <span class="label label-warning"><i class="fa fa-star-o"></i> <?php echo $film->note_presse; ?>/5</span>
                                    <span class="badge badge-info"><i class="fa fa-eur"></i> <?php echo $film->budget; ?></span>
                                </div>
                            </div> <!-- / .panel-heading -->
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img class="img-thumbnail" src="<?php echo $film->image; ?>" alt="<?php echo $film->title; ?>">
                                    </div>
                                    <div class="col-md-7">
                                        <b>Description</b>: <br><?php echo substr(strip_tags($film->synopsis), 0, strrpos(substr(strip_tags($film->synopsis), 0, 300), ' ')); ?>...
                                        <br><a href="<?php echo site_url('movie/voir/' . $film->id); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                    </div><!-- FIN Films à l'affiche -->

                    <div class="col-md-6" id="filmsattendus"> <!-- Films les plus attendus -->

                        <h1 class="text-primary text-center"><i class="fa fa-film"></i> Films les plus attendus</h1>
                        <?php foreach($filmsattendus as $film){ ?>

                            <div class="panel panel-info panel-dark">
                                <div class="panel-heading">
                                    <span class="panel-title"><strong><?php echo $film->title; ?></strong></strong></span>
                                    <div class="panel-heading-controls">
                                        <span class="label label-default"><?php echo $film->annee; ?></span>
                                        <span class="label label-warning"><i class="fa fa-star-o"></i> <?php echo $film->note_presse; ?>/5</span>
                                        <span class="badge badge-info"><i class="fa fa-eur"></i> <?php echo $film->budget; ?></span>
                                    </div>
                                </div> <!-- / .panel-heading -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <img class="img-thumbnail" src="<?php echo $film->image; ?>" alt="<?php echo $film->title; ?>">
                                        </div>
                                        <div class="col-md-7">
                                            <b>Description</b>: <br><?php echo substr(strip_tags($film->synopsis), 0, strrpos(substr(strip_tags($film->synopsis), 0, 300), ' ')); ?>...
                                            <br><a href="<?php echo site_url('movie/voir/' . $film->id); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div> <!-- FIN Films les plus attendus -->

                </div><!-- FIN Div row qui contient les films à l'affiche
                et les films les plus attendus -->




                <div class="row"> <!-- Div row qui contient les 4 meilleurs acteurs -->

                    <div class="col-md-12 text-center">
                        <h1 class="text-danger text-center">Les 4 meilleurs acteurs</h1>
                    </div>
                    <?php foreach($meilleursacteurs as $meilleuracteur){ ?>

                        <div class="col-md-3">

                            <div class="panel panel-primary panel-dark panel-body-colorful widget-profile widget-profile-centered">
                                <div class="panel-heading">
                                    <img src="<?php echo $meilleuracteur->image; ?>" alt="<?php echo $meilleuracteur->firstname; ?> <?php echo $meilleuracteur->lastname; ?>" class="widget-profile-avatar">
                                    <div class="widget-profile-header">
                                        <span><?php echo $meilleuracteur->firstname; ?> <?php echo $meilleuracteur->lastname; ?></span><br>
                                        <?php echo $meilleuracteur->age; ?> ans - <?php echo $meilleuracteur->city; ?>
                                    </div>
                                </div> <!-- / .panel-heading -->
                                <div class="panel-body">
                                    <div class="widget-profile-text" style="padding: 0;">
                                        <?php echo substr(strip_tags($meilleuracteur->biography), 0, strrpos(substr(strip_tags($meilleuracteur->biography), 0, 200), ' ')); ?>...<br>
                                        <a href="<?php echo site_url('acteur/voir/' . $meilleuracteur->id); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php } ?>

                </div> <!-- FIN Div row qui contient les 4 meilleurs acteurs -->

                <div class="row" id="meilleursrealisateurs"> <!-- Div row qui contient les 4 meilleurs réalisateurs -->

                    <div class="col-md-12 text-center">
                        <h1 class="text-info text-center">Les 4 meilleurs réalisateurs</h1>
                    </div>
                    <?php foreach($meilleursrealisateurs as $meilleurrealisateur){ ?>

                        <div class="col-md-3">

                            <div class="panel panel-warning panel-dark panel-body-colorful widget-profile widget-profile-centered">
                                <div class="panel-heading">
                                    <img src="<?php echo $meilleurrealisateur->image; ?>" alt="<?php echo $meilleurrealisateur->firstname; ?> <?php echo $meilleurrealisateur->lastname; ?>" class="widget-profile-avatar">
                                    <div class="widget-profile-header">
                                        <span><?php echo $meilleurrealisateur->firstname; ?> <?php echo $meilleurrealisateur->lastname; ?></span><br>
                                        <?php echo $meilleurrealisateur->age; ?> ans
                                    </div>
                                </div> <!-- / .panel-heading -->
                                <div class="panel-body">
                                    <div class="widget-profile-text" style="padding: 0;">
                                        <?php echo substr(strip_tags($meilleurrealisateur->biography), 0, strrpos(substr(strip_tags($meilleurrealisateur->biography), 0, 200), ' ')); ?>...<br>
                                        <a href="<?php echo site_url('realisateur/voir/' . $meilleurrealisateur->id); ?>"><button class="btn btn-warning btn-sm">En savoir +</button></a>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php } ?>

                </div> <!-- FIN Div row qui contient les 4 meilleurs réalisateurs -->

                <div class="row"> <!-- DIV qui contient les catégories,
                                    le nuage de tags et un film au hasard-->

                    <div class="col-md-4"> <!-- Les catégories -->
                        <h1 class="text-center">Les catégories</h1>

                        <div class="list-group">

                        <?php foreach($categories as $categorie){ ?>


                            <a href="<?php echo site_url('categorie/voir/' . $categorie->id); ?>" class="list-group-item">
                                <span class="badge badge-primary"><?php echo $categorie->nbmov; ?></span>
                                <?php echo $categorie->cat; ?>
                            </a>

                        <?php } ?>

                        </div>

                    </div> <!-- FIN Les catégories -->


                    <div class="col-md-5"> <!-- DEBUT prochaine séance à lyon -->
                        <h1 class="text-info text-center">Prochaine séance à Lyon</h1>

                        <div class="panel panel-info">

                            <?php if(!empty($prochaineseance)){ ?>
                            <div class="panel-heading">
                                <span class="panel-title"><?php echo $prochaineseance->mtitre; ?></span>
                                <div class="panel-heading-controls">
                                    <span class="badge badge-info">Le <?php echo $prochaineseance->mdate; ?> à <?php echo $prochaineseance->mheure; ?></span>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <img src="<?php echo $prochaineseance->mimage; ?>" alt="<?php echo $prochaineseance->mtitre; ?>" class="img-responsive">
                                    </div>
                                    <div class="col-md-7">
                                        <b>Description</b>: <br><?php echo substr(strip_tags($prochaineseance->msyno), 0, strrpos(substr(strip_tags($film->synopsis), 0, 300), ' ')); ?>...
                                        <br><a href="<?php echo site_url('movie/voir/' . $prochaineseance->mid); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                                    </div>
                                </div>
                            </div>
                            <?php } else { ?>
                                <div class="panel-body">
                                    <div class="row">
                                      <div class="alert alert-danger">Aucune séance de prévue à Lyon</div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- FIN prochaine séance à lyon -->


                    <div class="col-md-3"> <!-- Nuage de tags -->
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <span class="panel-title">Nuage de tags</span>
                                <div class="panel-heading-controls">
                                    <div class="panel-heading-icon"></div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <?php foreach($nuagetags as $tag){ ?>

                                    <?php if ($tag->nbtag < 2) {?>
                                        <button class="btn btn-xs btn-rounded">
                                    <?php } elseif ($tag->nbtag >= 6) { ?>
                                        <button class="btn btn-lg btn-rounded">
                                    <?php } else { ?>
                                        <button class="btn btn-rounded">
                                    <?php } ?>

                                    <?php echo $tag->tagname; ?></button>

                                <?php } ?>
                            </div>
                        </div>
                    </div> <!-- FIN Nuage de tags -->

                </div><!-- FIN DIV qui contient les catégories,
                        le nuage de tags et la prochaine session à Lyon -->

                <div class="row"> <!-- div row qui contient le film au hasard + les 5 derniers commentaires + les 5 dernières sessions -->

                    <div class="col-md-5"><!-- Film au hasard -->
                        <div class="panel colourable">
                            <div class="panel-heading">
                                <span class="panel-title"><h1>Un film au hasard</h1></span>
                            </div>
                            <div class="panel-body">
                                <img class="img-responsive" src="<?php echo $filmauhasard->image; ?>" alt="<?php echo $filmauhasard->title; ?>">
                                <b>Description</b>: <br><?php echo substr(strip_tags($filmauhasard->synopsis), 0, strrpos(substr(strip_tags($filmauhasard->synopsis), 0, 300), ' ')); ?>...
                                <br><a href="<?php echo site_url('movie/voir/' . $filmauhasard->id); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                            </div>
                        </div>
                    </div><!-- Fin film au hasard -->

                    <div class="col-md-7">
                        <div class="row"> <!-- div row qui contient 5 derniers commentaires + 5 prochaines séances -->

                            <div class="col-md-12">
                            <!-- 5 derniers commentaires -->

                                <!-- Javascript -->
                                <script>
                                    init.push(function () {
                                        $('#dashboard-recent .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
                                    })
                                </script>
                                <!-- / Javascript -->




                                <div class="panel panel-warning" id="dashboard-recent">
                                <div class="panel-heading">
                                    <span class="panel-title">Les 5 derniers commentaires</span>
                                    <ul class="nav nav-tabs nav-tabs-xs">
                                        <li class="active">
                                            <a href="#dashboard-recent-actifs" data-toggle="tab">Actifs</a>
                                        </li>
                                        <li>
                                            <a href="#dashboard-recent-valid" data-toggle="tab">En cours de validation</a>
                                        </li>
                                        <li>
                                            <a href="#dashboard-recent-inactifs" data-toggle="tab">Inactifs</a>
                                        </li>
                                    </ul>
                                </div> <!-- / .panel-heading -->
                                <div class="tab-content">

                                <!-- Comments widget -->

                                <!-- Without padding -->
                                <div class="widget-comments panel-body tab-pane no-padding fade active in" id="dashboard-recent-actifs">
                                    <!-- Panel padding, without vertical padding -->
                                    <div class="panel-padding no-padding-vr">

                                        <?php foreach($commac AS $com) { ?>
                                            <div class="comment">
                                                <img src="<?php echo $com->uavatar; ?>" alt="<?php echo $com->username; ?>" class="comment-avatar">
                                                <div class="comment-body">
                                                    <div class="comment-by">
                                                        <span class="label label-warning"><i class="fa fa-star-o"></i><?php echo $com->cnote; ?>/5</span>
                                                        <a href="#" title=""><?php echo $com->username; ?></a> à propos du film <a href="<?php echo site_url('movie/voir/' . $com->filmid); ?>" title=""><?php echo $com->film; ?></a>
                                                    </div>
                                                    <div class="comment-text">
                                                        <?php echo $com->ccontent; ?>
                                                    </div>
                                                    <div class="comment-actions">
                                                        <a href="#"><i class="fa fa-pencil"></i>Edit</a>
                                                        <a href="#"><i class="fa fa-times"></i>Remove</a>
                                                        <span class="pull-right">Le <?php echo $com->cdate; ?> à <?php echo $com->cheure; ?></span>
                                                    </div>
                                                </div> <!-- / .comment-body -->
                                            </div> <!-- / .comment -->

                                        <?php } ?>
                                    </div>
                                </div> <!-- / .widget-comments -->

                                    <div class="widget-comments panel-body tab-pane no-padding fade" id="dashboard-recent-valid">
                                        <!-- Panel padding, without vertical padding -->
                                        <div class="panel-padding no-padding-vr">

                                            <?php foreach($commval AS $com) { ?>
                                                <div class="comment">
                                                    <img src="<?php echo $com->uavatar; ?>" alt="<?php echo $com->username; ?>" class="comment-avatar">
                                                    <div class="comment-body">
                                                        <div class="comment-by">
                                                            <span class="label label-warning"><i class="fa fa-star-o"></i><?php echo $com->cnote; ?>/5</span>
                                                            <a href="#" title=""><?php echo $com->username; ?></a> à propos du film <a href="<?php echo site_url('movie/voir/' . $com->filmid); ?>" title=""><?php echo $com->film; ?></a>
                                                        </div>
                                                        <div class="comment-text">
                                                            <?php echo $com->ccontent; ?>
                                                        </div>
                                                        <div class="comment-actions">
                                                            <a href="#"><i class="fa fa-pencil"></i>Edit</a>
                                                            <a href="#"><i class="fa fa-times"></i>Remove</a>
                                                            <span class="pull-right">Le <?php echo $com->cdate; ?> à <?php echo $com->cheure; ?></span>
                                                        </div>
                                                    </div> <!-- / .comment-body -->
                                                </div> <!-- / .comment -->

                                            <?php } ?>
                                        </div>
                                    </div> <!-- / .widget-comments -->

                                    <div class="widget-comments panel-body tab-pane no-padding fade" id="dashboard-recent-inactifs">
                                        <!-- Panel padding, without vertical padding -->
                                        <div class="panel-padding no-padding-vr">

                                            <?php foreach($comminac AS $com) { ?>
                                                <div class="comment">
                                                    <img src="<?php echo $com->uavatar; ?>" alt="<?php echo $com->username; ?>" class="comment-avatar">
                                                    <div class="comment-body">
                                                        <div class="comment-by">
                                                            <span class="label label-warning"><i class="fa fa-star-o"></i><?php echo $com->cnote; ?>/5</span>
                                                            <a href="#" title=""><?php echo $com->username; ?></a> à propos du film <a href="<?php echo site_url('movie/voir/' . $com->filmid); ?>" title=""><?php echo $com->film; ?></a>
                                                        </div>
                                                        <div class="comment-text">
                                                            <?php echo $com->ccontent; ?>
                                                        </div>
                                                        <div class="comment-actions">
                                                            <a href="#"><i class="fa fa-pencil"></i>Edit</a>
                                                            <a href="#"><i class="fa fa-times"></i>Remove</a>
                                                            <span class="pull-right">Le <?php echo $com->cdate; ?> à <?php echo $com->cheure; ?></span>
                                                        </div>
                                                    </div> <!-- / .comment-body -->
                                                </div> <!-- / .comment -->

                                            <?php } ?>
                                        </div>
                                    </div> <!-- / .widget-comments -->


                                </div>
                                </div> <!-- / .widget-threads -->


                            </div><!-- FIN 5 derniers commentaires -->

                            <div class="col-md-12"> <!-- DEBUT 5 prochaines séances -->
                                <!-- 10. $SUPPORT_TICKETS ==========================================================================

                                                                   Support tickets
                                                       -->
                                <!-- Javascript -->
                                <script>
                                    init.push(function () {
                                        $('#dashboard-support-tickets .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
                                    })
                                </script>
                                <!-- / Javascript -->


                                <div class="panel panel-success widget-support-tickets" id="dashboard-support-tickets">
                                    <div class="panel-heading">
                                        <span class="panel-title">Les 5 prochaines séances</span>
                                        <div class="panel-heading-controls">
                                            <div class="panel-heading-text"></div>
                                        </div>
                                    </div> <!-- / .panel-heading -->
                                    <div class="panel-body tab-content-padding">
                                        <!-- Panel padding, without vertical padding -->
                                        <div class="panel-padding no-padding-vr">

                                            <?php foreach($prochainesseances as $seance) { ?>

                                                <div class="ticket">
                                                    <span class="label label-success ticket-label"><?php echo $seance->cinema; ?></span>
                                                    <a href="<?php echo site_url('movie/voir/' . $seance->mid); ?>" title="" class="ticket-title"><b><?php echo $seance->film; ?></b><span>, le <strong><?php echo $seance->sdate; ?> à <?php echo $seance->sheure; ?></strong></span></a>
                                                     <span class="ticket-info">
                                                        A <?php echo $seance->ville; ?><br>
                                                    </span>
                                                </div> <!-- / .ticket -->

                                            <?php } ?>

                                        </div>
                                    </div> <!-- / .panel-body -->
                                </div> <!-- / .panel -->

                                <!-- /10. $SUPPORT_TICKETS -->
                            </div><!-- FIN 5 prochaines séances -->

                        </div> <!-- fin div row qui contient 5 derniers commentaires + 5 prochaines séances -->

                    </div>


                </div>  <!-- FIN div row qui contient le film au hasard + les 5 derniers commentaires + les 5 dernières sessions -->

                <div class="row"><!-- DIV row stats -->
                    <div class="col-md-4"> <!-- DEBUT Stats générales (nb champs) -->
                        <!-- DEBUT STATS -->
                        <div class="stat-cell col-sm-4 bordered no-border-r padding-sm-hr valign-top">
                            <!-- Small padding, without top padding, extra small horizontal padding -->
                            <h4 class="padding-sm no-padding-t padding-xs-hr"><i class="fa fa-tasks text-primary"></i>&nbsp;&nbsp;Statistiques</h4>
                            <!-- Without margin -->
                            <ul class="list-group no-margin">
                                <!-- Without left and right borders, extra small horizontal padding -->
                                <li class="list-group-item no-border-hr padding-xs-hr">
                                    Nb de catégories <span class="label label-danger pull-right"><?php echo $nbcategories->nb;?></span>
                                </li> <!-- / .list-group-item -->
                                <!-- Without left and right borders, extra small horizontal padding -->
                                <li class="list-group-item no-border-hr padding-xs-hr">
                                    Nb de films <span class="label label-success pull-right"><?php echo $nbfilms->nb;?></span>
                                </li> <!-- / .list-group-item -->
                                <!-- Without left and right borders, without bottom border, extra small horizontal padding -->
                                <li class="list-group-item no-border-hr no-border-b padding-xs-hr">
                                    Nb d'acteurs <span class="label label-pa-purple pull-right"><?php echo $nbacteurs->nb;?></span>
                                </li> <!-- / .list-group-item -->
                                <li class="list-group-item no-border-hr no-border-b padding-xs-hr">
                                    Nb de réalisateurs <span class="label label-warning pull-right"><?php echo $nbrealisateurs->nb;?></span>
                                </li> <!-- / .list-group-item -->
                            </ul>
                        </div>

                        <!-- FIN STATS -->
                    </div> <!-- FIN Stats générales (nb champs) -->

                    <div class="col-md-4"> <!-- début stat budget film -->
                        <div class="stat-panel">
                            <div class="stat-cell bg-danger valign-middle">
                                <!-- Stat panel bg icon -->
                                <i class="fa fa-trophy bg-icon"></i>
                                <!-- Big text -->
                                <span class="text-bg">Budget total</span><br>
                               
                                <!-- Extra large text -->
                                <span class="text-xlg"><strong><?php echo number_format($budgettotal->nb, 0, ',',' '); ?> <span class="text-lg text-slim">€</span></strong></span><br>
                            </div>
                        </div>


                    </div> <!-- fin stat budget film -->

                    <div class="col-md-4"> <!-- début stat nb commentaires -->
                        <div class="stat-panel">
                            <!-- Success background. vertically centered text -->
                            <div class="stat-cell bg-danger valign-middle">
                                <!-- Stat panel bg icon -->
                                <i class="fa fa-comments bg-icon"></i>
                                <!-- Extra large text -->
                                <span class="text-xlg"><strong><?php echo $nbcomtotal->nb; ?></strong></span><br>
                                <!-- Big text -->
                                <span class="text-bg">Commentaires</span><br>
                                <!-- Small text -->
                                <span class="text-sm">total</span>
                            </div> <!-- /.stat-cell -->
                        </div>
                    </div> <!-- Fin stat nb commentaires -->

                </div><!-- FIN DIV row stats -->

                <div class="row"> <!-- Début DIV ROW stats pies -->

                    <!-- 6. $EASY_PIE_CHARTS ===========================================================================

				Easy Pie charts
-->
                    <!-- Javascript -->
                    <script>
                        init.push(function () {
                            // Easy Pie Charts
                            var easyPieChartDefaults = {
                                animate: 2000,
                                scaleColor: false,
                                lineWidth: 6,
                                lineCap: 'square',
                                size: 90,
                                trackColor: '#e5e5e5'
                            }
                            $('#easy-pie-chart-1').easyPieChart($.extend({}, easyPieChartDefaults, {
                                barColor: PixelAdmin.settings.consts.COLORS[1]
                            }));
                            $('#easy-pie-chart-2').easyPieChart($.extend({}, easyPieChartDefaults, {
                                barColor: PixelAdmin.settings.consts.COLORS[1]
                            }));
                            $('#easy-pie-chart-3').easyPieChart($.extend({}, easyPieChartDefaults, {
                                barColor: PixelAdmin.settings.consts.COLORS[1]
                            }));
                        });
                    </script>
                    <!-- / Javascript -->


                        <div class="col-md-4">
                            <div class="stat-panel text-center">
                                <div class="stat-row">
                                    <!-- Dark gray background, small padding, extra small text, semibold text -->
                                    <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                        <i class="fa fa-comments"></i>&nbsp;&nbsp;Taux de commentaires actifs
                                    </div>
                                </div> <!-- /.stat-row -->
                                <div class="stat-row">
                                    <!-- Bordered, without top border, without horizontal padding -->
                                    <div class="stat-cell bordered no-border-t no-padding-hr">
                                        <div class="pie-chart" data-percent="<?php echo $nbcomac->nb/$nbcomtotal->nb*100; ?>" id="easy-pie-chart-1">
                                            <div class="pie-chart-label"><?php echo round($nbcomac->nb/$nbcomtotal->nb*100); ?>%</div>
                                        </div>
                                    </div>
                                </div> <!-- /.stat-row -->
                            </div> <!-- /.stat-panel -->
                        </div>

                        <div class="col-md-4">
                            <div class="stat-panel text-center">
                                <div class="stat-row">
                                    <!-- Dark gray background, small padding, extra small text, semibold text -->
                                    <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                        <i class="fa fa-star"></i>&nbsp;&nbsp;Taux de films en favoris
                                    </div>
                                </div> <!-- /.stat-row -->
                                <div class="stat-row">
                                    <!-- Bordered, without top border, without horizontal padding -->
                                    <div class="stat-cell bordered no-border-t no-padding-hr">
                                        <div class="pie-chart" data-percent="<?php echo $nbfilmsfav->nb/$nbfilms->nb*100; ?>" id="easy-pie-chart-2">
                                            <div class="pie-chart-label"><?php echo round($nbfilmsfav->nb/$nbfilms->nb*100); ?>%</div>
                                        </div>
                                    </div>
                                </div> <!-- /.stat-row -->
                            </div> <!-- /.stat-panel -->
                        </div>

                        <div class="col-md-4">
                            <div class="stat-panel text-center">
                                <div class="stat-row">
                                    <!-- Dark gray background, small padding, extra small text, semibold text -->
                                    <div class="stat-cell bg-dark-gray padding-sm text-xs text-semibold">
                                        <i class="fa fa-video-camera"></i>&nbsp;&nbsp;Taux de films diffusés
                                    </div>
                                </div> <!-- /.stat-row -->
                                <div class="stat-row">
                                    <!-- Bordered, without top border, without horizontal padding -->
                                    <div class="stat-cell bordered no-border-t no-padding-hr">
                                        <div class="pie-chart" data-percent="<?php echo $nbfilmsdif->nb/$nbfilms->nb*100; ?>" id="easy-pie-chart-3">
                                            <div class="pie-chart-label"><?php echo round($nbfilmsdif->nb/$nbfilms->nb*100); ?>%</div>
                                        </div>
                                    </div>
                                </div> <!-- /.stat-row -->
                            </div> <!-- /.stat-panel -->
                        </div>


                <!-- /6. $EASY_PIE_CHARTS -->

                </div><!-- Fin DIV ROW stats pies -->

                    <div class="row"><!-- DEBUT DIV ROW stats panel -->


                    <div class="col-md-6"> <!-- Moyenne age acteurs -->

                        <!-- 5. $EXAMPLE_NOTIFICATIONS =====================================================================

                                        Notifications example
                        -->
                        <div class="stat-panel">
                            <!-- Success background, bordered, without top and bottom borders, without left border, without padding, vertically and horizontally centered text, large text -->
                            <a href="#" class="stat-cell col-xs-5 bg-success bordered no-border-vr no-border-l no-padding valign-middle text-center text-bg">
                                Moyenne d'age des acteurs<br><span class="text-lg"><strong><?php echo floor($ageacteurs->nb); ?></strong> ans</span>
                            </a> <!-- /.stat-cell -->
                            <!-- Without padding, extra small text -->
                            <div class="stat-cell col-xs-7 no-padding valign-middle">
                                <!-- Add parent div.stat-rows if you want build nested rows -->
                                <div class="stat-rows">
                                    <div class="stat-row">
                                        <!-- Success background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-success padding-sm valign-middle">
                                           <?php echo $nbacteurslyon->nb; ?> à Lyon
                                        </a>
                                    </div>
                                    <div class="stat-row">
                                        <!-- Success darken background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-success darken padding-sm valign-middle">
                                            <?php echo $nbacteursparis->nb; ?> à Paris
                                        </a>
                                    </div>
                                    <div class="stat-row">
                                        <!-- Success darker background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-success darker padding-sm valign-middle">
                                            <?php echo $nbacteursmarseille->nb; ?> à Marseille
                                        </a>
                                    </div>
                                </div> <!-- /.stat-rows -->
                            </div> <!-- /.stat-cell -->
                        </div> <!-- /.stat-panel -->

                    </div> <!-- Fin Moyenne age acteurs -->

                    <div class="col-md-6"> <!-- stats commentaires -->

                        <div class="stat-panel">
                            <!-- Success background, bordered, without top and bottom borders, without left border, without padding, vertically and horizontally centered text, large text -->
                            <a href="#" class="stat-cell col-xs-5 bg-warning bordered no-border-vr no-border-l no-padding valign-middle text-center text-bg">
                                Nombre de commentaires<br><span class="text-lg"><strong><?php echo $nbcomtotal->nb ?></strong></span>
                            </a> <!-- /.stat-cell -->
                            <!-- Without padding, extra small text -->
                            <div class="stat-cell col-xs-7 no-padding valign-middle">
                                <!-- Add parent div.stat-rows if you want build nested rows -->
                                <div class="stat-rows">
                                    <div class="stat-row">
                                        <!-- Success background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-warning padding-sm valign-middle">
                                            <?php echo $nbcomac->nb ?> actifs

                                        </a>
                                    </div>
                                    <div class="stat-row">
                                        <!-- Success darken background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-warning darken padding-sm valign-middle">
                                            <?php echo $nbcomval->nb ?> en cours de validation

                                        </a>
                                    </div>
                                    <div class="stat-row">
                                        <!-- Success darker background, small padding, vertically aligned text -->
                                        <a href="#" class="stat-cell bg-warning darker padding-sm valign-middle">
                                            <?php echo $nbcominac->nb ?> inactifs

                                        </a>
                                    </div>
                                </div> <!-- /.stat-rows -->
                            </div> <!-- /.stat-cell -->
                        </div> <!-- /.stat-panel -->
                        <!-- /5. $EXAMPLE_NOTIFICATIONS -->

                    </div>  <!-- Fin stats commentaires -->



                </div><!-- FIN DIV ROW stats panel -->

                <div class="row"> <!-- Début DIV ROW stats répartitions -->

                    <div class="col-md-6"> <!-- DEBUT DIV répartition des films/catégories -->
                        <!-- 10. $FLOTJS_PIE ===============================================================================

                        Flot.js Pie / Doughnut  -->
                        <!-- Javascript -->
                        <script>
                            init.push(function () {
                                // Doughnut Chart Data
                                var doughnutChartData = [

                                    <?php foreach($nbfilmbycat AS $nbfilm) { ?>
                                        {
                                            label: "<?php echo $nbfilm->titre ?>", data: <?php echo $nbfilm->nb ?>
                                        },
                                    <?php } ?>

                                ];

                                // Init Chart
                                $('#jq-flot-pie').pixelPlot(doughnutChartData, {
                                    series: {
                                        pie: {
                                            show: true,
                                            radius: 1,
                                            innerRadius: 0.5,
                                            label: {
                                                show: true,
                                                radius: 3 / 4,
                                                formatter: function (label, series) {
                                                    return '<div style="font-size:14px;text-align:center;padding:2px;color:white;">' + Math.round(series.percent) + '%</div>';
                                                },
                                                background: { opacity: 0 }
                                            }
                                        }
                                    }
                                }, {
                                    height: 205
                                });
                            });
                        </script>
                        <!-- / Javascript -->

                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Répartition des films/catégories</span>
                            </div>
                            <div class="panel-body">


                                <div class="graph-container">
                                    <div id="jq-flot-pie"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /10. $FLOTJS_PIE -->



                    </div> <!-- FIN DIV répartition des films/catégories -->

                    <div class="col-md-6"> <!-- Début DIV répartition des films/mois -->

                        <!-- 7. $MORRISJS_BARS =============================================================================

				        Morris.js Bars-->

                        <!-- Javascript -->
                        <script>
                            init.push(function () {
                                Morris.Bar({
                                    element: 'hero-bar',
                                    data: [

                                        <?php foreach($filmsbymois AS $films) { ?>

                                        { device: '<?php echo $films->mois; ?>', geekbench: <?php echo $films->nb; ?> },

                                        <?php } ?>

                                    ],
                                    xkey: 'device',
                                    ykeys: ['geekbench'],
                                    labels: ['Films'],
                                    barRatio: 0.4,
                                    xLabelAngle: 35,
                                    hideHover: 'auto',
                                    barColors: PixelAdmin.settings.consts.COLORS,
                                    gridLineColor: '#cfcfcf',
                                    resize: true
                                });
                            });
                        </script>
                        <!-- / Javascript -->

                        <div class="panel">
                            <div class="panel-heading">
                                <span class="panel-title">Répartition des films/mois (date de sortie)</span>
                            </div>
                            <div class="panel-body">


                                <div class="graph-container">
                                    <div id="hero-bar" class="graph"></div>
                                </div>
                            </div>
                        </div>
                        <!-- /7. $MORRISJS_BARS -->

                    </div> <!-- Fin DIV répartition des films/mois -->

                </div> <!-- FIN DIV ROW stats répartitions -->


            <div class="col-md-12">
                <div class="panel panel-info panel-dark widget-profile">
                    <div class="panel-heading">
                        <span class="pull-right">Crée le <?php echo $tweetsinfos->created_at; ?></span><br>

                        <div class="widget-profile-bg-icon"><i class="fa fa-twitter"></i></div>
                        <img src="<?php echo $tweetsinfos->profile_image_url; ?>" alt="" class="widget-profile-avatar">
                        <div class="widget-profile-header">
                            <span><?php echo $tweetsinfos->screen_name; ?></span><br>
                            <a href="<?php echo $tweetsinfos->url; ?>"><?php echo $tweetsinfos->url; ?></a>
                        </div>
                    </div> <!-- / .panel-heading -->
                    <div class="widget-profile-counters">
                        <div class="col-xs-4"><span><?php echo $tweetsinfos->statuses_count; ?></span><br>TWEETS</div>
                        <div class="col-xs-4"><span><?php echo $tweetsinfos->followers_count; ?></span><br>FOLLOWERS</div>
                        <div class="col-xs-4"><span><?php echo $tweetsinfos->favourites_count; ?></span><br>FOLLOWING</div>
                    </div>
                    <div class="widget-profile-text">
                        <?php echo $tweetsinfos->description; ?>
                    </div>
                </div>
            </div>

             <!-- DEBUT TCHAT USERS -->
            <div class="col-md-6">
                <div class="panel panel-primary panel-dark panel-body-colorful widget-profile widget-profile-centered">
                    <div class="panel-heading">
                        <img src="<?php echo base_url() ?>assets/demo/avatars/1.jpg" alt="" class="widget-profile-avatar">
                        <div class="widget-profile-header">
                            <span>Tchater avec les derniers connectés</span><br>
                        </div>
                    </div> <!-- / .panel-heading -->
                    <div class="panel-body">
                            <?php foreach($users as $user){ ?>
                                 <div class="row">
                                    <a href="<?php echo site_url('welcome/discussion/'.$user->id); ?>" class="pull-left ">
                                        <i class="fa  fa-comments"></i> Tchater avec  <?php echo $user->username ?> ( <?php echo $user->email ?>)
                                    </a>

                                        <span class="badge badge-info pull-right"><?php echo ago($user->username) ?></span>
                                </div>
                                <hr />
                            <?php } ?>
                        </div>
                    </div>
                </div>
                 <!-- DEBUT TWITTER -->


            <div class="panel widget-messages-alt col-md-6" id="tweets">
                <div class="panel-heading">
                    <span class="panel-title text-info"><i class="panel-title-icon fa fa-twitter"></i>Tweets</span>
                </div> <!-- / .panel-heading -->
                <div class="panel-body padding-sm">
                    <div class="messages-list">

                        <div class="block-tweets">
                            <?php

                            foreach($tweets as $tweet) { ?>
                            <div class="message">
                                <img src="assets/demo/avatars/2.jpg" alt="" class="message-avatar">

                                <span class="message-subject"><?php echo $tweet['text']; ?></span>
                                <div class="message-description">
                                    par <a href="#"></a>
                                    &nbsp;&nbsp;·&nbsp;&nbsp;
                                    2h ago
                                    <a href="<?php echo site_url('welcome/suppressiontweet/'.$tweet['id']); ?>" class="pull-right removetweet"><i class="fa fa-times"></i>Supprimer</a>
                                </div> <!-- / .message-description -->




                            </div> <!-- / .message -->
                            <?php } ?>

                         </div>

                        <form id="addtweet" method="post" action="<?php echo site_url('welcome/ajoutertweet'); ?>">
                            <textarea class="form-control" rows="3" name="tweet"></textarea>
                            <div class="panel-footer text-right">
                                <button class="btn btn-primary"><i class="fa fa-twitter"></i> Ecrire un tweet</button>
                            </div>
                        </form>

                    </div> <!-- / .messages-list -->
                    <a href="#" class="messages-link">PLUS DE TWEETS</a>
                </div> <!-- / .panel-body -->
            </div> <!-- / .panel -->
            <!-- /8. $MESSAGES_LIST_ALT -->
                <!-- FIN TWITTER -->



            </div> <!-- Fin DIV content-wrapper -->

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>