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

    });
</script>



<div id="content-wrapper">




    <form action="<?php echo site_url('cinema/editer/' . $cine->id); ?>" method="post" class="panel form-horizontal">
        <div class="panel-heading">
            <span class="panel-title">Edition de cinema</span><span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>
        <div class="panel-body">

            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label" for="title">Nom<sup class="text-danger">*</sup></label>
                <div class="col-sm-8 col-md-10">
                    <input type="text" name="title" pattern="^.{3,}$" value="<?php echo $cine->title; ?>" class="form-control" placeholder="Nom du cinema" required>
                    <?php echo form_error('title', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>

            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label" for="ville">Ville<sup class="text-danger">*</sup></label>
                <div class="col-sm-8 col-md-10">
                    <input type="text" name="ville" pattern="^.{3,}$" value="<?php echo $cine->ville; ?>" class="form-control" placeholder="Ville" required>
                    <?php echo form_error('ville', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>

            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label" for="position">Position</label>
                <div class="col-sm-8 col-md-10">
                    <input type="text" name="position" pattern="^[0-9]+$" value="<?php echo $cine->position; ?>" class="form-control" placeholder="chiffre">
                    <?php echo form_error('position', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>



        </div>
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-primary">Modifier ce cinema</button>
        </div>
    </form>


</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>