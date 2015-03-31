<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

    <div class="row"> <!-- DEBUT DIV ROW Affiche la séance -->
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning panel-dark">
                <div class="panel-heading">
                    <span class="panel-title text-lg">Séance du <?php echo $seance->adate_session; ?> à <?php echo $seance->heure_session; ?></span>
                    <div class="panel-heading-controls">
                        <a href="<?php echo site_url('seance/lister'); ?>"><button class="btn btn-outline btn-sm btn-labeled btn-primary"><span class="btn-label icon fa fa-reply"></span>Retour</button></a>
                        <div class="panel-heading-icon"><i class="fa fa-tag"></i></div>
                    </div>
                </div>

            </div>
        </div>
    </div> <!-- FIN DIV ROW Affiche la séance -->

    <div class="row">

        <div class="col-md-6"> <!-- film de la séance -->
            <div class="panel panel-info panel-dark">
                <div class="panel-heading">
                    <span class="panel-title text-bg">Film de la séance</span>
                    <div class="panel-heading-controls">
                        <div class="panel-heading-icon"><i class="fa fa-film"></i></div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="text-center">
                        <img class="img-responsive" src="<?php echo $film->image; ?>" alt="<?php echo $film->title; ?>">
                        <a href="<?php echo site_url('movie/voir/' . $film->id); ?>" class="text-bg text-bold"><?php echo $film->title; ?></a><br>
                        <a href="<?php echo site_url('movie/voir/' . $film->id); ?>"><button class="btn btn-flat btn-sm btn-labeled btn-info"><span class="btn-label icon fa fa-eye"></span>voir</button></a>
                    </div>

                </div>
            </div>
        </div> <!-- Fin film de la séance -->

        <div class="col-md-6"> <!-- cinéma de la séance -->
            <div class="panel panel-success panel-dark">
                <div class="panel-heading">
                    <span class="panel-title text-bg">Cinéma</span>
                    <div class="panel-heading-controls">
                        <div class="panel-heading-icon"><i class="fa fa-simplybuilt"></i></div>
                    </div>
                </div>

                <div class="panel-body">

                    <div class="text-center">
                        <a href="<?php echo site_url('cinema/voir/' . $cine->id); ?>" class="text-bg text-bold"><?php echo $cine->title; ?></a><br>
                        <?php echo $cine->ville; ?><br>
                        <a href="<?php echo site_url('cinema/voir/' . $cine->id); ?>"><button class="btn btn-flat btn-sm btn-labeled btn-info"><span class="btn-label icon fa fa-eye"></span>voir</button></a>
                    </div>

                </div>
            </div>
        </div> <!-- Fin cinéma de la séance -->

    </div>

</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>




