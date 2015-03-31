<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">




    <form action="<?php echo site_url('tag/editer/' . $tag->id); ?>" method="post" class="panel form-horizontal">
        <div class="panel-heading">
            <span class="panel-title">Edition de tag</span><span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>
        <div class="panel-body">
            <div class="row form-group">
                <label class="col-sm-4 col-md-2 control-label" for="word">Nom<sup class="text-danger">*</sup></label>
                <div class="col-sm-8 col-md-10">
                    <input type="text" pattern="^.{3,}$" name="word" class="form-control" placeholder="Nom du tag" required value="<?php echo $tag->word; ?>">
                    <?php echo form_error('word', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>




        </div>
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-primary">Modifier le tag</button>
        </div>
    </form>


</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>