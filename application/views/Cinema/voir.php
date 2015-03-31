<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

    <div class="row"> <!-- DEBUT DIV ROW Affiche la catégorie -->
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-warning panel-dark">
                <div class="panel-heading">
                    <span class="panel-title text-lg"><?php echo $cine->title; ?></span>
                    <div class="panel-heading-controls">
                        <a href="<?php echo site_url('cinema/lister'); ?>"><button class="btn btn-outline btn-sm btn-labeled btn-primary"><span class="btn-label icon fa fa-reply"></span>Retour</button></a>
                        <div class="panel-heading-icon"><i class="fa fa-tasks"></i></div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">



                            <div class="col-md-12">
                                <h4>Ville :</h4>
                                <?php echo $cine->ville; ?>

                            </div>



                    </div>
                </div>
            </div>
        </div>
    </div> <!-- FIN DIV ROW Affiche la catégorie -->

    <div class="panel panel-info panel-dark">
        <div class="panel-heading">
            <span class="panel-title text-bg">Les films du cinema <?php echo $cine->title; ?></span>
            <div class="panel-heading-controls">
                <div class="panel-heading-icon"><i class="fa fa-film"></i></div>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">

                <?php
                if (!empty($filmsparcine)) {

                    foreach ($filmsparcine as $filmparcine) { ?>
                        <div class="col-md-4 text-center">
                            <img class="img-responsive" src="<?php echo $filmparcine->image; ?>" alt="<?php echo $filmparcine->title; ?>">
                            <a href="<?php echo site_url('movie/voir/' . $filmparcine->id); ?>" class="text-bg text-bold"><?php echo $filmparcine->title; ?></a><br>
                            <a href="<?php echo site_url('movie/voir/' . $filmparcine->id); ?>"><button class="btn btn-flat btn-sm btn-labeled btn-info"><span class="btn-label icon fa fa-eye"></span>voir</button></a>
                        </div>
                    <?php } ?>

                <?php } else { ?>

                    <div class="col-md-4 col-md-offset-4 text-center">
                        <div class="alert">
                            <button type="button" class="close" data-dismiss="alert"></button>
                            <strong>Aucun film dans ce cinema</strong>
                        </div>
                    </div>

                <?php  } ?>



            </div>
        </div>
    </div>

</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>




