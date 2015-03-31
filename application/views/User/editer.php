<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>

<script>
    init.push(function () {

        $('#image').pixelFileInput({placeholder: 'Aucun fichier...'})

    });
</script>


<div id="content-wrapper">


    <div class="panel">

        <div class="panel-heading">
            <span class="panel-title">Modification d'utilisateur</span> <span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>

        <div class="panel-body">

            <form class="form-horizontal" id="jq-validation-form" method="post" action="<?php echo site_url('user/editer/' .$user->id); ?>" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Nom d'utilisateur<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $user->username; ?>" required="required" class="form-control" id="username" name="username" placeholder="min. 3 caractères" readonly="readonly">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Adresse e-mail<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="email" value="<?php echo $user->email; ?>" required="required" class="form-control" id="email" name="email" placeholder="toto@exemple.com">
                        <?php echo form_error('email', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password1" class="col-sm-3 control-label">Mot de passe<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="password" value="<?php echo $user->password; ?>" required="required" class="form-control" id="password1" name="password1" placeholder="min. 8 caractères">
                        <?php echo form_error('password1', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password2" class="col-sm-3 control-label">Retaper le mot de passe<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="password" value="<?php echo $user->password; ?>" required="required" class="form-control" id="password2" name="password2" placeholder="">
                        <?php echo form_error('password2', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role" class="col-sm-3 control-label">Rôle<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Sélectionnez un rôle</option>
                            <option value="0" <?php if($user->is_admin == "0") {?>selected<?php }?> >Utilisateur</option>
                            <option value="1" <?php if($user->is_admin == "1") {?>selected<?php }?> >Admin</option>
                            <option value="2" <?php if($user->is_admin == "2") {?>selected<?php }?> >Super Admin</option>
                        </select>

                        <?php echo form_error('role', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>



                <div class="form-group">

                    <label class="col-sm-3 control-label">Image</label>
                    <div class="col-sm-9">
                        <input accept="image/*" class="form-control" capture="capture" type="file" name="image" id="image" />

                        <?php
                        if (isset($user->avatar)) { ?>
                            <img class="col-md-3 thumbnail" src="<?php echo $user->avatar; ?>" />
                        <?php } else { ?>
                            <p class="text-light-gray text-xs"><em>Aucune image</em></p>
                        <?php } ?>

                        <!-- affiche les erreurs d'upload -->
                        <?php if(isset($error)){ ?>
                            <div class="alert alert-dark alert-danger">
                                <button type="button" class="close" data-dismiss="alert">x</button>
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>

                    </div>


                </div>



        </div>

        <hr class="panel-wide">


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Enregistrer</button>
            </div>
        </div>
        </form>
    </div>
</div>
<!-- /5. $JQUERY_VALIDATION -->



</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>