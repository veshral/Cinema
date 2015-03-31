<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>

<div id="content-wrapper"> <!-- DEBUT content-wrapper -->

    <div class="panel panel-success"> <!-- DEBUT DIV infos réalisateur -->
        <div class="panel-heading">
            <span class="panel-title text-lg"><?php echo $user->username; ?>

            </span>
            <div class="panel-heading-controls">
                <a href="<?php echo site_url('user/lister'); ?>"><button class="btn btn-outline btn-sm btn-labeled btn-primary"><span class="btn-label icon fa fa-reply"></span>Retour</button></a>
                <div class="panel-heading-icon"><i class="fa fa-user"></i></div>
            </div>
        </div>
        <div class="panel-body row">

            <div class="col-md-3">
                <img class="img-thumbnail" src="<?php echo $user->avatar; ?>" alt="<?php echo $user->username; ?>">
            </div>

            <div class="col-md-9">

                <div class="row">
                    <div class="col-md-6 well">
                        <p><span class="text-bg">Email:</span> <?php echo safe_mailto($user->email, $user->email); ?></p>
                        <p><span class="text-bg">Rôle:</span>
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
                        </p>
                        <p><span class="text-bg">Date de création:</span><?php echo $user->created_at; ?></p>
                        <p><span class="text-bg">Dernière connexion:</span><?php echo $user->last_login; ?></p>
                    </div>

                    <div class="col-md-6 well">
                        <p><span class="text-bg">Adresse:</span</p>
                        <p><?php echo $user->ville; ?></p>
                        <p><?php echo $user->zipcode; ?></p>

                    </div>


                </div>


            </div>
        </div>
    </div> <!-- DEBUT DIV infos réalisateur -->



</div> <!-- FIN content-wrapper -->

<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>




