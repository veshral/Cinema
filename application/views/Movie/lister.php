<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

    <div class="page-header">

        <div class="row">
            <!-- Page header, center on small screens -->
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-film page-header-icon"></i>&nbsp;&nbsp;Films</h1>

            </div>

    </div>
    <!-- 45.1. $JQUERY_DATA_TABLES_EXAMPLE =============================================================

            Examples
    -->
    <!-- Javascript -->
    <script>

        init.push(function () {

            $('#jq-datatables-example').dataTable( {
                "paging": false,
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ]
            } );
            $('#jq-datatables-example').dataTable();
            $('#jq-datatables-example_wrapper .table-caption').text('Liste de mes films');
            $('#jq-datatables-example_wrapper .dataTables_filter input').attr('placeholder', 'Rechercher...');
            $('#jq-datatables-example_previous > a').html('Précédent');
            $('#jq-datatables-example_next > a').html('Suivant');
            // $('#champ-action-films').removeClass();


        });
    </script>
    <!-- / Javascript -->





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



    <div class="row">
            <a class="btn btn-sm btn-success btn-flat pull-right" href="<?php echo site_url('movie/creer'); ?>"><i class="fa fa-plus"></i> Ajouter un film</a>
    </div>
    <hr />
    
    <div class="row">
        <div class="col-md-12">
            <div class="table-primary">
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="jq-datatables-example">
                    <thead>

                        <tr>
                            <th class="reduce">Titre</th>
                            <th>Prix</th>
                            <th class="reduce">Synopsis</th>
                            <th>Etoiles</th>
                            <th>Visibilité</th>
                            <th>Création</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach($filmscat as $film){ ?>
                            <tr class="">
                                <td><a href="<?php echo site_url('movie/voir/' . $film->id); ?>" class="text-bold"><?php echo $film->title; ?></a></td>
                                <td><?php echo price($film->prix); ?></td>
                                <td><div class="reduce"><?php echo substr(strip_tags($film->syno), 0, strrpos(substr(strip_tags($film->syno), 0, 200), ' ')); ?> ... <a href="<?php echo site_url('movie/voir/' . $film->id); ?>">lire la suite</a></div></td>
                                <td>
                                    <?php
                                        $i = 1;
                                        while ($i <= $film->stars) { ?>
                                            <i class="fa fa-star"></i>
                                       <?php $i++; }
                                    ?>


                                </td>
                                <td>
                                    <?php
                                    echo visibility($film->visible);
                                    echo cover($film->cover);
                                    ?>


                                </td>
                                <td><?php echo ago($film->date); ?></td>
                                <td class="text-center">

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-leaf"></i> Actions&nbsp;<i class="fa fa-caret-down"></i></button>

                                        <ul class="dropdown-menu">
                                            <li><a href="<?php echo site_url('movie/voir/' . $film->id); ?>"><i class="fa fa-search"></i>Voir ce film</a></li>
                                            <li><a href="<?php echo site_url('movie/editer/' . $film->id); ?>"><i class="fa fa-pencil"></i> Editer ce film</a></li>
                                            <li><a data-toggle="modal" data-target="#modal<?php echo $film->id; ?>"><i class="fa fa-times"></i> Supprimer ce film</a></li>
                                            <li><a href="<?php echo site_url('movie/addCart/' . $film->id) ?>"><i class="fa fa-search"></i> Ajouter au panier</a></li>
                                            <?php
                                            if ($film->visible == true) { ?>
                                                <li><a href="<?php echo site_url('movie/visibilityoff/' . $film->id); ?>">
                                                    <i class="fa fa-check-circle-o"></i> Désactiver ce film</a></li>
                                            <?php } else { ?>
                                                <li><a href="<?php echo site_url('movie/visibilityon/' . $film->id); ?>">
                                                        <i class="fa fa-check-circle"></i> Activer ce film</a></li>
                                            <?php } ?>

                                            <li class="divider"></li>
                                            <?php
                                            if ($film->cover == true) { ?>
                                               <li> <a href="<?php echo site_url('movie/coveroff/' . $film->id); ?>">
                                                        <i class="fa fa-times"></i> Retirer de l'avant</a></li>
                                            <?php } else { ?>
                                                <li> <a href="<?php echo site_url('movie/coveron/' . $film->id); ?>">
                                                        <i class="fa fa-heart"></i> Mettre en avant</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>


                                    <!-- DEBUT modal suppression -->
                                    <div id="modal<?php echo $film->id; ?>" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 class="modal-title">Confirmer la suppression du film "<?php echo $film->title; ?>"?</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <button type="button" class="btn btn-xs btn-flat" data-dismiss="modal" aria-hidden="true">Annuler</button>
                                                    <a href="<?php echo site_url('movie/supprimer/' . $film->id); ?>"><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-times"></i> Supprimer</button></a>


                                                </div>
                                            </div> <!-- / .modal-content -->
                                        </div> <!-- / .modal-dialog -->
                                    </div> <!-- / .modal -->
                                    <!-- / Small modal -->

                                    <!-- FIN modal suppression -->

                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>
    <!-- /45. $JQUERY_DATA_TABLES -->






</div>

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>