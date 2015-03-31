<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>

<div id="content-wrapper"> <!-- DEBUT content-wrapper -->

    <div class="panel panel-success"> <!-- DEBUT DIV infos réalisateur -->
        <div class="panel-heading">
            <span class="panel-title text-lg"><?php echo $realisateur->firstname; ?> <?php echo $realisateur->lastname; ?>
                <span class="text-bg"> / <?php echo $realisateur->age; ?> ans</span>
            </span>
            <div class="panel-heading-controls">
                <a href="<?php echo site_url('realisateur/lister'); ?>"><button class="btn btn-outline btn-sm btn-labeled btn-primary"><span class="btn-label icon fa fa-reply"></span>Retour</button></a>
                <div class="panel-heading-icon"><i class="fa fa-video-camera"></i></div>
            </div>
        </div>
        <div class="panel-body row">

            <div class="col-md-3">
                <img class="img-thumbnail" src="<?php echo $realisateur->image; ?>" alt="<?php echo $realisateur->firstname; ?> <?php echo $realisateur->lastname; ?>">
            </div>

            <div class="col-md-9">

                <div class="row">

                    <div class="col-md-12">
                        <h4>Biographie :</h4>
                        <?php echo substr(strip_tags($realisateur->biography), 0, strrpos(substr(strip_tags($realisateur->biography), 0, 400), ' ')); ?>
                        <?php
                        if (strlen(strip_tags($realisateur->biography)) >=400) { ?>
                            ... <a href="#" class="text-bold" data-toggle="modal" data-target="#modal-biographie-realisateur">en savoir +</a>

                            <!-- Large modal -->
                            <div id="modal-biographie-realisateur" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            <h4 class="modal-title"><i class="fa fa-user"></i> Biographie du réalisateur "<?php echo $realisateur->firstname; ?> <?php echo $realisateur->lastname; ?>"</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo strip_tags($realisateur->biography) ?>
                                        </div>
                                    </div> <!-- / .modal-content -->
                                </div> <!-- / .modal-dialog -->
                            </div> <!-- / .modal -->
                            <!-- / Large modal -->

                        <?php } ?>



                    </div>

                    <hr>

                </div>


            </div>
        </div>
    </div> <!-- DEBUT DIV infos réalisateur -->

    <div class="panel panel-warning"> <!-- DEBUT DIV films réalisés par le réalisateur -->
        <div class="panel-heading">
            <span class="panel-title text-bg">Les films réalisés par <?php echo $realisateur->firstname; ?> <?php echo $realisateur->lastname; ?>

            </span>
            <div class="panel-heading-controls">
                <div class="panel-heading-icon"><i class="fa fa-film"></i></div>
            </div>
        </div>
        <div class="panel-body row">

            <?php
            if (!empty($moviesfromdirector)) {

                foreach($moviesfromdirector AS $moviefromdirector) { ?>
                    <div class="col-md-4 text-center">
                        <img class="img-responsive" src="<?php echo $moviefromdirector->image ?>" alt="<?php echo $moviefromdirector->title ?>">
                        <a href="<?php echo site_url('movie/voir/' . $moviefromdirector->id); ?>" class="text-bg text-bold"><?php echo $moviefromdirector->title; ?></a><br>
                        <a href="<?php echo site_url('movie/voir/' . $moviefromdirector->id); ?>"><button class="btn btn-flat btn-sm btn-labeled btn-info"><span class="btn-label icon fa fa-eye"></span>voir</button></a>
                    </div>
                <?php } ?>

            <?php } else { ?>

            <div class="col-md-4 col-md-offset-4 text-center">
                <div class="alert-danger">
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert"></button>
                        <strong>Aucun film réalisé</strong>
                    </div>
                </div>

                <?php  } ?>

            </div>
        </div>


    </div> <!-- FIN DIV films réalisés par le réalisateur -->

</div> <!-- FIN content-wrapper -->

    <!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>




