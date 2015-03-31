<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


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


<div id="content-wrapper">

    <div class="page-header">

        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-camera page-header-icon"></i>&nbsp;&nbsp;Album photo</h1>

        </div>

    </div>

   <div class="row">
            <a class="btn btn-sm btn-success btn-flat pull-right" href="<?php echo site_url('album/creer'); ?>"><i class="fa fa-plus"></i> Ajouter une image</a>
    </div>
    <hr />

    <h3>Liste des images de <?php echo $user->username; ?></h3>
    <div class="row">
        <?php
        foreach ($useralbum as $album) { ?>

            <div class="col-md-4 thumbnail">
                <img src="<?php echo $album->photo; ?>" alt="<?php echo $album->title; ?>" style="max-height:250px;">
                <div class="caption">
                    <h3 class="text-center"><?php echo $album->title; ?></h3>
                    <p><?php echo $album->description; ?></p>
                    <p class="text-light-gray"><em>Date de création: <?php echo $album->date_created; ?></em></p>
                    <p>

                        <!-- DEBUT modal suppression -->
                    <div id="modal<?php echo $album->id; ?>" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h4 class="modal-title">Confirmer la suppression de la photo "<?php echo $album->title; ?>" ?</h4>
                                </div>
                                <div class="modal-body">
                                    <button type="button" class="btn btn-xs btn-flat" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                    <a href="<?php echo site_url('album/supprimer/' .$album->id); ?>"><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i> Supprimer</button></a>


                                </div>
                            </div> <!-- / .modal-content -->
                        </div> <!-- / .modal-dialog -->
                    </div> <!-- / .modal -->
                    <!-- / Small modal -->

                    <button class="btn btn-xs btn-danger btn-flat" data-toggle="modal" data-target="#modal<?php echo $album->id; ?>"><i class="fa fa-times"></i> Supprimer</button>

                    <!-- FIN modal suppression -->






                    <a href="<?php echo site_url('album/editer/'.$album->id); ?>" class="btn btn-xs btn-warning btn-flat" role="button"><i class="fa fa-pencil-square-o"></i> Editer</a>
                    </p>

                </div>
            </div>


        <?php } ?>

    </div>

</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>