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

        $('#image').pixelFileInput({placeholder: 'Aucun fichier...'})
    });
</script>



<div id="content-wrapper">



    <form action="<?php echo site_url('album/creer'); ?>" method="post" class="panel form-horizontal" enctype="multipart/form-data">
        <div class="panel-heading">
            <span class="panel-title">Ajout de photos</span><span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>
        <div class="panel-body">
            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label">Titre<sup class="text-danger">*</sup></label>
                <div class="col-sm-8 col-md-10">
                    <input type="text" name="title" class="form-control" placeholder="Titre de l'image" required value="<?php echo set_value('title'); ?>">
                    <?php echo form_error('title', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>


            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label">Description</label>
                <div class="col-sm-8 col-md-10">
                    <textarea rows="4" name="description" class="form-control expanding-input-target" placeholder="Description de l'image"><?php echo set_value('description'); ?></textarea>
                    <?php echo form_error('description', '<div class="alert alert-dark alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div>


            <div class="row form-group">
                <label class="col-sm-2 control-label">Image<sup class="text-danger">*</sup></label>
                <div class="col-sm-10">
                    <input accept="image/*" class="form-control" capture="capture" type="file" name="image" id="image" />
                    <?php
                    if (isset($error)) {
                    echo $error;
                    }
                    ?>
                </div>
            </div>





        </div>
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-primary">Ajouter cette photo</button>
        </div>
    </form>


</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>