<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">


    <div class="page-header">

        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-simplybuilt page-header-icon"></i>&nbsp;&nbsp;Séances</h1>

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

    <!-- 45.1. $JQUERY_DATA_TABLES_EXAMPLE =============================================================

            Examples
    -->
    <!-- Javascript -->
    <script>
        init.push(function () {
            $('#jq-datatables-example').dataTable( {
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            } );
            $('#jq-datatables-example').dataTable();
            $('#jq-datatables-example_wrapper .table-caption').text('Liste des séances');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Rechercher...');
            $('#jq-datatables-example_previous > a').html('Précédent');
            $('#jq-datatables-example_next > a').html('Suivant');
            // $('#champ-action-films').removeClass();

        });
    </script>
    <!-- / Javascript -->


   <div class="row">
            <a class="btn btn-sm btn-success btn-flat pull-right" href="<?php echo site_url('seance/creer'); ?>"><i class="fa fa-plus"></i> Ajouter une séance</a>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-12">
            <div class="table-primary">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                    <thead>

                    <tr>
                        <th>Date</th>
                        <th>Heure</th>
                        <th>Film</th>
                        <th>Cinema</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($allseances as $seance){ ?>
                        <tr class="">
                            <td><a href="<?php echo site_url('seance/voir/' . $seance->sid); ?>"><?php echo $seance->date_session; ?></a></td>
                            <td><a href="<?php echo site_url('seance/voir/' . $seance->sid); ?>"><?php echo $seance->heure_session; ?></a></td>
                            <td><a href="<?php echo site_url('movie/voir/' . $seance->filmid); ?>"><?php echo $seance->filmtitre; ?></a></td>
                            <td><a href="<?php echo site_url('cinema/voir/' . $seance->cineid); ?>"><?php echo $seance->cinetitre; ?></a></td>
                            <td class="text-center">
                                <a href="<?php echo site_url('seance/voir/' . $seance->sid); ?>"><button class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i> Voir</button></a>
                                <a href="<?php echo site_url('seance/editer/' . $seance->sid); ?>"><button class="btn btn-xs btn-warning btn-flat"><i class="fa fa-pencil-square-o"></i> Editer</button></a>


                                <!-- DEBUT modal suppression -->
                                <div id="modal<?php echo $seance->sid; ?>" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Confirmer la suppression de la séance du film <?php echo $seance->filmtitre; ?> du <?php echo $seance->date_session; ?> à <?php echo $seance->heure_session; ?> ?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <button type="button" class="btn btn-xs btn-flat" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                                <a href="<?php echo site_url('seance/supprimer/' . $seance->sid); ?>"><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i> Supprimer</button></a>


                                            </div>
                                        </div> <!-- / .modal-content -->
                                    </div> <!-- / .modal-dialog -->
                                </div> <!-- / .modal -->
                                <!-- / Small modal -->

                                <button class="btn btn-xs btn-danger btn-flat" data-toggle="modal" data-target="#modal<?php echo $seance->sid; ?>"><i class="fa fa-times"></i> Supprimer</button>

                                <!-- FIN modal suppression -->

                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /45. $JQUERY_DATA_TABLES -->






</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>