<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>




<script>

    init.push(function () {

        $('.removecom').click(function(e){
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

                    current.parents('.comment').fadeOut('slow');
                },

                error: function() {
                    alert('la requète n\'a pas abouti');
                }
            });
        });


    });


</script>


<div id="content-wrapper"> <!-- DEBUT DIV content -->

    <div class="panel panel-warning panel-dark"> <!-- DEBUT DIV vue du film -->
        <div class="panel-heading">
            <span class="panel-title text-lg"><?php echo $film->title; ?></span>
            <div class="panel-heading-controls">
                <a href="<?php echo site_url('movie/lister'); ?>"><button class="btn btn-outline btn-sm btn-labeled btn-primary"><span class="btn-label icon fa fa-reply"></span>Retour</button></a>
                <div class="panel-heading-icon"><i class="fa fa-film"></i></div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">

                <div class="col-md-4">

                    <img src="<?php echo $film->image; ?>" alt="<?php echo $film->title; ?>" class="img-thumbnail">

                </div>

                <div class="col-md-8">

                    <div class="row">

                        <div class="col-md-12">
                            <h4>Description :</h4>
                            <?php echo substr(strip_tags($film->description), 0, strrpos(substr(strip_tags($film->description), 0, 300), ' ')); ?>
                            <?php
                            if (strlen(strip_tags($film->description)) >=300) { ?>
                                ... <a href="#" class="text-bold" data-toggle="modal" data-target="#modal-description-film">en savoir +</a>

                                <!-- Large modal -->
                                <div id="modal-description-film" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title"><i class="fa fa-film"></i> Description du film "<?php echo $film->title; ?>"</h4>
                                            </div>
                                            <div class="modal-body">
                                                <?php echo strip_tags($film->description) ?>
                                            </div>
                                        </div> <!-- / .modal-content -->
                                    </div> <!-- / .modal-dialog -->
                                </div> <!-- / .modal -->
                                <!-- / Large modal -->




                            <?php } ?>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">

                            Distributeur: <span class="text-bold"><?php echo strip_tags($film->distributeur); ?></span><br>
                            Type: <span class="text-bold"><?php echo strip_tags($film->type_film); ?></span><br>
                            Année: <span class="text-bold"><?php echo strip_tags($film->annee); ?></span><br>
                            Durée: <span class="text-bold"><?php echo strip_tags($film->duree); ?> heure(s)</span><br>
                            Date de sortie: <span class="text-bold"><?php echo strip_tags($film->date_release); ?></span><br>
                            Budget: <span class="text-bold"><?php echo $film->budget; ?> &euro;</span><br>
                            Langue: <span class="text-bold"><?php echo $film->languages; ?></span><br>
                            BO: <span class="text-bold"><?php echo $film->bo; ?></span><br>
                            Note:
                            <?php
                            $i = 1;
                            while ($i <= $film->note_presse) { ?>
                                <i class="fa fa-star text-warning"></i>
                                <?php $i++; }
                            while ($i <= 5) { ?>
                                <i class="fa fa-star-o text-warning"></i>
                                <?php $i++; }
                            ?>
                            <br>
                            <span class="text-danger"><i class="fa fa-heart"></i> <?php echo strip_tags($film->views); ?> vues</span>
                            <?php if ($film->visible == 1) { ?><span class="text-success"><i class="fa fa-check"></i> Visible</span> <?php ;} ?><br>
                            <?php if ($film->cover == 1) { ?><span class="text-success"><i class="fa fa-check"></i> En page d'accueil</span><?php ;} ?><br>

                        </div>

                        <div class="col-md-7">
                            <div class="embed-responsive"><?php echo $film->trailer; ?></div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div> <!-- FIN DIV vue du film -->

    <div> <!-- DEBUT DIV commentaires, acteurs et réalisateurs -->

            <!-- Info -->
            <div class="panel-group panel-group-info" id="accordion-info-example">
                <div class="panel">
                    <div class="panel-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-info-example" href="#collapseOne-info">
                            <i class="fa fa-comments"></i> Les commentaires du film
                        </a>
                    </div> <!-- / .panel-heading -->
                    <div id="collapseOne-info" class="panel-collapse collapse" style="height: 0px;">
                        <div class="panel-body">
                            <div class="widget-comments tab-pane no-padding fade active in" id="dashboard-recent-comments">
                                <!-- Panel padding, without vertical padding -->
                                <div class="panel-padding no-padding-vr">



                                    <?php
                                    if (!empty($comsfrommovie)) {
                                        foreach ($comsfrommovie AS $comfrommovie) {
                                            ?>

                                            <div class="comment">
                                                <img src="<?php echo $comfrommovie->avatar; ?>" alt="<?php echo $comfrommovie->username; ?>" class="comment-avatar">
                                                <div class="comment-body">
                                                    Note : <?php
                                                    $i = 1;
                                                    while ($i <= $comfrommovie->note) { ?>
                                                        <i class="fa fa-star text-info"></i>
                                                        <?php $i++; }
                                                    while ($i <= 5) { ?>
                                                        <i class="fa fa-star-o text-info"></i>
                                                        <?php $i++; }
                                                    ?>

                                                    <div class="comment-by">
                                                        Par : <a href="#" title=""><?php echo $comfrommovie->username; ?></a>
                                                    </div>
                                                    <div class="comment-text">
                                                        <?php echo $comfrommovie->content; ?>
                                                    </div>
                                                    <div class="comment-actions">
                                                        <a href="#"><i class="fa fa-pencil"></i>Modifier</a>
                                                        <a href="<?php echo site_url('comment/supprimer/' . $film->id); ?>" class="removecom"><i class="fa fa-times"></i>Supprimer</a>
                                                        <span class="pull-right"><?php echo getRelativeTime($comfrommovie->date_created); ?></span>
                                                    </div>
                                                </div> <!-- / .comment-body -->
                                            </div> <!-- / .comment -->

                                        <?php }
                                    } else { ?>
                                        <div class="col-md-4 col-md-offset-4">
                                            <div class="alert-danger">
                                                <div class="alert alert-danger">
                                                    <button type="button" class="close" data-dismiss="alert"></button>
                                                    <strong>Aucun commentaire sur ce film</strong>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } ?>


                                </div>
                            </div> <!-- / .widget-comments -->
                        </div> <!-- / .panel-body -->
                    </div> <!-- / .collapse -->
                </div> <!-- / .panel -->

                <div class="panel">
                    <div class="panel-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-info-example" href="#collapseTwo-info">
                            <i class="fa fa-user"></i> Les acteurs du film
                        </a>
                    </div> <!-- / .panel-heading -->
                    <div id="collapseTwo-info" class="panel-collapse collapse">


                            <div class="panel-body row">

                                <?php foreach($actorsfrommovie as $actorfrommovie){ ?>

                                    <div class="col-md-3">

                                        <div class="panel panel-danger panel-dark panel-body-colorful widget-profile widget-profile-centered">
                                            <div class="panel-heading">
                                                <img src="<?php echo $actorfrommovie->image; ?>" alt="<?php echo $actorfrommovie->firstname; ?> <?php echo $actorfrommovie->lastname; ?>" class="widget-profile-avatar">
                                                <div class="widget-profile-header">
                                                    <span><?php echo $actorfrommovie->firstname; ?> <?php echo $actorfrommovie->lastname; ?></span><br>
                                                    <?php echo $actorfrommovie->age; ?> ans - <?php echo $actorfrommovie->city; ?>
                                                </div>
                                            </div> <!-- / .panel-heading -->
                                            <div class="panel-body">
                                                <div class="widget-profile-text" style="padding: 0;">
                                                    <?php echo substr(strip_tags($actorfrommovie->biography), 0, strrpos(substr(strip_tags($actorfrommovie->biography), 0, 200), ' ')); ?>...<br>
                                                    <a href="<?php echo site_url('acteur/voir/' . $actorfrommovie->id); ?>"><button class="btn btn-info btn-sm">En savoir +</button></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                <?php } ?>

                            </div>


                    </div> <!-- / .collapse -->
                </div> <!-- / .panel -->

                <div class="panel">
                    <div class="panel-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion-info-example" href="#collapseThree-info">
                            <i class="fa fa-video-camera"></i> Les réalisateurs du film
                        </a>
                    </div> <!-- / .panel-heading -->
                    <div id="collapseThree-info" class="panel-collapse collapse">
                        <div class="panel-body">




                            <?php foreach($directorsfrommovie as $directorfrommovie){ ?>

                                <div class="col-md-3">

                                    <div class="panel panel-info panel-dark panel-body-colorful widget-profile widget-profile-centered">
                                        <div class="panel-heading">
                                            <img src="<?php echo $directorfrommovie->image; ?>" alt="<?php echo $directorfrommovie->firstname; ?> <?php echo $directorfrommovie->lastname; ?>" class="widget-profile-avatar">
                                            <div class="widget-profile-header">
                                                <span><?php echo $directorfrommovie->firstname; ?> <?php echo $directorfrommovie->lastname; ?></span><br>
                                                <?php echo $directorfrommovie->age; ?> ans
                                            </div>
                                        </div> <!-- / .panel-heading -->
                                        <div class="panel-body">
                                            <div class="widget-profile-text" style="padding: 0;">
                                                <?php echo substr(strip_tags($directorfrommovie->biography), 0, strrpos(substr(strip_tags($directorfrommovie->biography), 0, 200), ' ')); ?>...<br>
                                                <a href="<?php echo site_url('realisateur/voir/' . $directorfrommovie->id); ?>"><button class="btn btn-warning btn-sm">En savoir +</button></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            <?php } ?>






                        </div> <!-- / .panel-body -->
                    </div> <!-- / .collapse -->
                </div> <!-- / .panel -->
            </div> <!-- / .panel-group -->
            <!-- / Info -->


    </div> <!-- FIN DIV commentaires, acteurs et réalisateurs -->




</div> <!-- FIN DIV content -->

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>