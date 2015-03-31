<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">


    <div class="page-header">

        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-comments page-header-icon"></i>&nbsp;&nbsp;Commentaires</h1>

        </div>

    </div>

    <!-- 45.1. $JQUERY_DATA_TABLES_EXAMPLE =============================================================

            Examples
    -->
    <!-- Javascript -->
    <script>



        init.push(function () {

            $('#jq-datatables-example').dataTable( {
                 "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ]
            } );
            $('#jq-datatables-example').dataTable();
            $('#jq-datatables-example_wrapper .table-caption').text('Liste des commentaires');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Rechercher...');
            $('#jq-datatables-example_previous > a').html('Précédent');
            $('#jq-datatables-example_next > a').html('Suivant');
            // $('#champ-action-films').removeClass();


            //AJAX - suppression des commentaires
            $('.removecom').click(function(e){
                e.preventDefault(); // j'annule l'évènement href de redirection quand je clique sur mon lien

                var current = $(this); // je récupère mon élément courant sur lequel je fais mon évènement clique

                //module AJAX en Jquery
                $.ajax({
                    type: 'GET', // type de la requête : GET/POST
                    url: current.attr('href'), // URL d'envoie de ma requête

                    // le data réceptionne les données envoyées par le contrôleur
                    success: function(data) {

                        $.growl.notice({ message: data });

                        current.parents('.block-comment').fadeOut('slow');
                        // Mettre ligne ci-dessous en cas de modal
                        $('.modal').modal('hide');
                    },

                    error: function() {
                        alert('la requète n\'a pas abouti');
                    }
                });
            });




        });
    </script>
    <!-- / Javascript -->







    <div class="row">
        <div class="col-md-12">
            <div class="table-primary">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                    <thead>

                    <tr>
                        <th>Utilisateur</th>
                        <th>Commentaire</th>
                        <th>Note</th>
                        <th>Film</th>
                        <th>Création</th>
                        <th>Etat</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach($comments as $comment){ ?>
                        <tr class="block-comment">
                            <td><?php echo $comment->username; ?></td>
                            <td><?php echo $comment->content; ?></td>
                            <td>
                                <?php
                                $i = 1;
                                while ($i <= $comment->note) { ?>
                                    <i class="fa fa-star"></i>
                                    <?php $i++; }
                                ?>


                            </td>
                            <td><a href="<?php echo site_url('movie/voir/' . $comment->mid); ?>"><?php echo $comment->mtitle; ?></a></td>
                            <td><?php echo getRelativeTime($comment->date); ?></a></td>
                            <td>
                                <?php
                                if ($comment->state == 0) { ?>
                                    <span class="text-danger">Désactivé</span>
                                <?php } elseif ($comment->state == 1) { ?>
                                    <span class="text-warning">En cours de modération</span>
                                <?php } elseif ($comment->state == 2) { ?>
                                    <span class="text-success">Activé</span>
                                <?php } else { ?>
                                    Aucun état
                                <?php } ?>

                            </td>

                            <td class="text-center">
                                <a href="<?php echo site_url('comment/activer/' . $comment->cid); ?>"><button class="btn btn-xs btn-success btn-flat" <?php if($comment->state == 2 ) {?>style="display: none;"<?php } ?>><i class="fa fa-check"></i> Activer</button></a>
                                <a href="<?php echo site_url('comment/desactiver/' . $comment->cid); ?>"><button class="btn btn-xs btn-warning btn-flat" <?php if($comment->state == 0 ) {?>style="display: none;"<?php } ?>><i class="fa fa-times"></i> Désactiver</button></a>
                                <a href="<?php echo site_url('comment/validation/' . $comment->cid); ?>"><button class="btn btn-xs btn-info btn-flat" <?php if($comment->state == 1 ) {?>style="display: none;"<?php } ?>><i class="fa fa-pencil-square-o"></i> En modération</button></a>


                                <!-- DEBUT modal suppression -->
                                <div id="modal<?php echo $comment->cid; ?>" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Confirmer la suppression du commentaire de "<?php echo $comment->username; ?>"?</h4>
                                            </div>
                                            <div class="modal-body">
                                                <button type="button" class="btn btn-xs btn-flat" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                                <a href="<?php echo site_url('comment/supprimer/' . $comment->cid); ?>" class="removecom"><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i> Supprimer</button></a>


                                            </div>
                                        </div> <!-- / .modal-content -->
                                    </div> <!-- / .modal-dialog -->
                                </div> <!-- / .modal -->
                                <!-- / Small modal -->

                                <button class="btn btn-xs btn-danger btn-flat" data-toggle="modal" data-target="#modal<?php echo $comment->cid; ?>"><i class="fa fa-times"></i> Supprimer</button>

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