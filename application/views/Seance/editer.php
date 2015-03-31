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

        // date picker
        /*var options = {
            todayBtn: "linked",
            orientation: $('body').hasClass('right-to-left') ? "auto right" : 'auto auto'
        }
        $('#bs-datepicker-example').datepicker(options);
    */
        $('#abs-datepicker-component').datepicker({format:'yyyy-mm-dd'});

       /* var options2 = {
            orientation: $('body').hasClass('right-to-left') ? "auto right" : 'auto auto'
        }
        $('#bs-datepicker-range').datepicker(options2);

        $('#bs-datepicker-inline').datepicker();*/

        // Fin date picker

        // time picker

        var options = {
            minuteStep: 5,
            orientation: $('body').hasClass('right-to-left') ? { x: 'right', y: 'auto'} : { x: 'auto', y: 'auto'}
        }
        $('#bs-timepicker-example').timepicker(options);

        var options2 = {
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false,
            showInputs: false,
            orientation: $('body').hasClass('right-to-left') ? { x: 'right', y: 'auto'} : { x: 'auto', y: 'auto'}
        }
        $('#bs-timepicker-component').timepicker(options2);

        var options3 = {
            minuteStep: 5,
            template: 'modal',
            orientation: $('body').hasClass('right-to-left') ? { x: 'right', y: 'auto'} : { x: 'auto', y: 'auto'}
        }
        $('#bs-timepicker-modal').timepicker(options3);

        var options4 = {
            template: false,
            showInputs: false,
            minuteStep: 5
        }
        $('#bs-timepicker-w-template').timepicker(options4);

        // fin time picker

        $('#image').pixelFileInput({placeholder: 'Aucun fichier...'})
    });
</script>



<div id="content-wrapper">




    <form action="<?php echo site_url('seance/editer/' . $seance->id); ?>" method="post" class="panel form-horizontal">
        <div class="panel-heading">
            <span class="panel-title">Edition de séance</span><span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
        </div>
        <div class="panel-body">

            <div class="row form-group">
                <label for="date_session" class="col-sm-4 col-md-2 control-label">Date<sup class="text-danger">*</sup></label>

                <div class="input-group date col-sm-8 col-md-10" id="abs-datepicker-component">

                    <input value="<?php echo $seance->adate_session; ?>" type="text" name="date_session" class="form-control"><span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                    <?php echo form_error('date_session', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>


            <div class="row form-group">
                <label for="heure_session" class="col-sm-4 col-md-2 control-label">Heure<sup class="text-danger">*</sup></label>

                <div class="input-group date col-sm-8 col-md-10" id="bs-datepicker-component">
                    <input type="text" name="heure_session" class="form-control" id="bs-timepicker-component" value="<?php echo $seance->heure_session; ?>"><span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                    <?php echo form_error('heure_session', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>

            </div>


            <div class="row form-group">
                <label for="film" class="col-sm-4 col-md-2 control-label">Film</label>
                <div class="col-sm-8 col-md-10">
                    <select class="form-control" id="film" name="film">
                        <option value="">Sélectionnez un film</option>

                        <?php
                        foreach ($films as $film) { ?>
                            <option value="<?php echo $film->id; ?>"
                                <?php
                                if ($seance->movies_id == $film->id) { ?>
                                    selected

                                <?php } ?>

                                ><?php echo $film->title; ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>

            <div class="row form-group">
                <label for="cinema" class="col-sm-4 col-md-2 control-label">Cinema</label>
                <div class="col-sm-8 col-md-10">
                    <select class="form-control" id="cinema" name="cinema">
                        <option value="">Sélectionnez un cinema</option>

                        <?php
                        foreach ($cinemas as $cinema) { ?>
                            <option value="<?php echo $cinema->id; ?>"
                                <?php
                                if ($seance->cinema_id == $cinema->id) { ?>
                                    selected
                                <?php } ?>

                                ><?php echo $cinema->title; ?></option>
                        <?php } ?>

                    </select>
                </div>
            </div>



        </div>
        <div class="panel-footer text-right">
            <button type="submit" class="btn btn-primary">Modifier cette séance</button>
        </div>
    </form>


</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>