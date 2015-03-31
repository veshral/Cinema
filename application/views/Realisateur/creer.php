<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>

<script>
    init.push(function () {
        $('textarea').summernote({
            height: 200,
            tabsize: 2,
            codemirror: {
                theme: 'monokai'
            }
        });

        $('textarea').code('');

        $('#image').pixelFileInput({placeholder: 'Aucun fichier…'});
    });
</script>


<div id="content-wrapper">


    <form class="panel form-horizontal" action="<?php echo site_url('realisateur/creer'); ?>" method="post" enctype="multipart/form-data">
        <div class="panel-heading">
            <span class="panel-title">Créer un réalisateur</span><span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>
        <div class="panel-body">

            <div class="form-group">
                <label for="nom" class="col-sm-2 control-label">Nom<sup class="text-danger">*</sup></label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo set_value('lastname'); ?>" pattern="^[a-zA-Z ,.'-]{3,}$" class="form-control" id="nom" name="lastname" placeholder="min 3 caractères" required>
                    <?php echo form_error('lastname', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div> <!-- / .form-group -->

            <div class="form-group">
                <label for="prenom" class="col-sm-2 control-label">Prénom<sup class="text-danger">*</sup></label>
                <div class="col-sm-10">
                    <input type="text" value="<?php echo set_value('firstname'); ?>" pattern="^[a-zA-Z ,.'-]{3,}$" class="form-control" id="prenom" name="firstname" placeholder="min 3 caractères" required>
                    <?php echo form_error('firstname', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div> <!-- / .form-group -->

            <div class="form-group">
                <label for="dob" class="col-sm-2 control-label">date de naissance<sup class="text-danger">*</sup></label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" value="<?php echo set_value('dob'); ?>" id="dob" name="dob" required>
                    <?php echo form_error('dob', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div> <!-- / .form-group -->


            <div class="form-group">
                <label for="biography" class="col-sm-2 control-label">Biographie</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="biography" placeholder="min 10 caractères"><?php echo set_value('biography'); ?></textarea>
                    <?php echo form_error('biography', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div> <!-- / .form-group -->

            <div class="form-group">
                <label class="col-sm-2 control-label" for="image">Image</label>
                <div class="col-sm-10">
                    <input accept="image/*" capture="capture" type="file" name="image" id="image" />

                    <!-- affiche les erreurs d'upload -->
                    <?php if(isset($error)){ ?>
                        <div class="alert alert-dark alert-danger">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <?php echo $error; ?>
                        </div>
                    <?php } ?>

                </div>

            </div>

            <div class="form-group" style="margin-bottom: 0;">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Enregistrer</button>
                </div>

            </div> <!-- / .form-group -->
        </div>
    </form>






</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>