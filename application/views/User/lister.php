<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

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
                    { "orderable": false, "targets": 5 }
                ]
            } );
            $('#jq-datatables-example').dataTable();
            $('#jq-datatables-example_wrapper .table-caption').text('Liste des utilisateurs');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Rechercher...');
            $('#jq-datatables-example_previous > a').html('Précédent');
            $('#jq-datatables-example_next > a').html('Suivant');
            // $('#champ-action-films').removeClass();

        });
    </script>
    <!-- / Javascript -->

   <div class="row">
            <a class="btn btn-sm btn-success btn-flat pull-right" href="<?php echo site_url('user/creer'); ?>"><i class="fa fa-plus"></i> Ajouter un utilisateur</a>
    </div>
    <hr />

    <div class="row">
        <div class="col-md-12">
            <div class="table-primary">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                    <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Dernière connexion</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($allusers as $user){ ?>
                        <tr class="">
                            <td>
                                <?php

                                if ($user->avatar == "") { ?>
                                    <span class="text-light-gray text-xs"><em>Aucune image</em></span>
                                <?php } else { ?>
                                <a href="<?php echo site_url('user/voir/' . $user->id); ?>"><img src="<?php echo $user->avatar; ?>" alt="<?php echo $user->username; ?>" class="img-thumbnail"></a></td>

                                <?php } ?>


                            <td><a href="<?php echo site_url('user/voir/' . $user->id); ?>" class="text-bold"><?php echo $user->username; ?></a></td>
                            <td><?php echo $user->email; ?></td>
                            <td>
                                <?php
                                    if ($user->is_admin == 0) { ?>
                                        <span class="text-info">Utilisateur</span>
                                    <?php } elseif ($user->is_admin == 1) { ?>
                                        <span class="text-warning">Admin</span>
                                    <?php } elseif ($user->is_admin == 2) { ?>
                                        <span class="text-danger">Super Admin</span>
                                    <?php } else { ?>
                                        <span class="text-light-gray">non défini</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                    if($user->last_login == "") { ?>
                                        <span class="text-light-gray"><em>Aucune connexion</em></span>
                                    <?php } else { ?>
                                        <?php echo getRelativeTime($user->last_login); ?>
                                    <?php } ?>

                            </td>

                            <td class="text-center">
                                <a href="<?php echo site_url('user/voir/' . $user->id); ?>"><button class="btn btn-xs btn-info btn-flat"><i class="fa fa-eye"></i> Voir</button></a>
                                <a href="<?php echo site_url('user/editer/' . $user->id); ?>"><button class="btn btn-xs btn-warning btn-flat"><i class="fa fa-pencil-square-o"></i> Editer</button></a>


                                <!-- DEBUT modal suppression -->
                                <div id="modal<?php echo $user->id; ?>" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Confirmer la suppression de l'utilisateur "<?php echo $user->username; ?>"?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <button type="button" class="btn btn-xs btn-flat" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                                <a href="<?php echo site_url('user/supprimer/' . $user->id); ?>"><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-user-times"></i> Supprimer</button></a>


                                            </div>
                                        </div> <!-- / .modal-content -->
                                    </div> <!-- / .modal-dialog -->
                                </div> <!-- / .modal -->
                                <!-- / Small modal -->

                                <button class="btn btn-xs btn-danger btn-flat" data-toggle="modal" data-target="#modal<?php echo $user->id; ?>"><i class="fa fa-user-times"></i> Supprimer</button>

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