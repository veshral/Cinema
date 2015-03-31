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

<!-- 5. $JQUERY_VALIDATION =========================================================================

				jQuery Validation
-->
<!-- Javascript -->
<script>
    init.push(function () {

        $('#jq-validation-select2').select2({ allowClear: true, placeholder: 'Select a country...' }).change(function(){
            $(this).valid();
        });
        $('#jq-validation-select2-multi').select2({ placeholder: 'Select gear...' }).change(function(){
            $(this).valid();
        });

        // Add phone validator
        $.validator.addMethod(
            "phone_format",
            function(value, element) {
                var check = false;
                return this.optional(element) || /^\(\d{3}\)[ ]\d{3}\-\d{4}$/.test(value);
            },
            "Invalid phone number."
        );

        // Setup validation
        $("#jq-validation-form").validate({
            messages: {
                'title': 'Titre invalide !',
                'annee': 'Année invalide !',
                'image' : "Fichier invalide",
                'date_release' : "Date invalide",
                'budget' : "Budget invalide"
            }
        });
    });
</script>
<!-- / Javascript -->

<div class="panel">

    <div class="panel-heading">
        <span class="panel-title">Modification de film</span> <span class="pull-right text-sm text-danger"><sup>*</sup>champs obligatoires</span>
    </div>

    <div class="panel-body">

        <form class="form-horizontal" id="jq-validation-form" method="post" action="<?php echo site_url('movie/creer'); ?>" enctype="multipart/form-data">

            <div class="form-group">
                <label for="title" class="col-sm-3 control-label">Titre<sup class="text-danger">*</sup></label>
                <div class="col-sm-9">
                    <input type="text" value="<?php echo $film->title; ?>" required="required" pattern="^[a-zA-Z0-9 ']{3,}$" class="form-control" id="title" name="title" placeholder="min. 3 caractères">
                    <?php echo form_error('title', '<div class="alert alert-dark alert-danger">
                <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    <label for="date_release" class="col-sm-3 control-label">Date de sortie<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" value="<?php echo $film->date_release; ?>" id="date_release" name="date_release" required="required">
                        <?php echo form_error('date_release', '<div class="alert alert-dark alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>

                <div class="col-sm-5">
                    <label class="col-sm-2 control-label">Image</label>
                    <div class="col-sm-10">
                        <input accept="image/*" class="form-control" capture="capture" type="file" name="image" id="image" />
                        <img class="col-md-3 thumbnail" src="<?php echo $film->image; ?>" />

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


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    <label for="annee" class="col-sm-3 control-label">Année<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $film->annee; ?>" pattern="^[0-9]{4}$" class="form-control" id="annee" name="annee" placeholder="XXXX" required="required">
                        <?php echo form_error('annee', '<div class="alert alert-dark alert-danger">
                        <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>


                <div class="col-sm-5">
                    <label for="budget" class="col-sm-3 control-label">Budget (euros)<sup class="text-danger">*</sup></label>
                    <div class="col-sm-9">
                        <input type="text" value="<?php echo $film->budget; ?>" pattern="^[0-9]+$" class="form-control" id="budget" name="budget" required="required">
                        <?php echo form_error('budget', '<div class="alert alert-dark alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                    </div>
                </div>
            </div>



            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-5">
                    <label for="bo" class="col-sm-3 control-label">BO</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="bo" name="bo">
                            <option value="">Sélectionnez une BO</option>
                            <option value="vo"
                                <?php
                                if ($film->bo == "vo") { ?>
                                    selected
                                <?php } ?>
                                >VO</option>
                            <option value="vost"
                                <?php
                                if ($film->bo == "vost") { ?>
                                    selected
                                <?php } ?>
                                >VOST</option>
                            <option value="vf"
                                <?php
                                if ($film->bo == "vf") { ?>
                                    selected
                                <?php } ?>

                                >VF</option>
                        </select>
                    </div>
                </div>


                <div class="col-sm-5">
                    <label for="categorie" class="col-sm-3 control-label">Catégorie</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="categorie" name="categorie">
                            <option value="">Sélectionnez une catégorie</option>
                            <?php
                            foreach($categoriesform as $cat) { ?>

                                <option value="<?php echo $cat->id; ?>"
                                    <?php
                                        if ($film->categories_id == $cat->id) { ?>
                                           selected
                                    <?php } ?>

                                    >
                                <?php echo $cat->cat; ?></option>
                            <?php } ?>

                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="synopsis" class="col-sm-3 control-label">Synopsis<sup class="text-danger">*</sup></label>
                <div class="col-sm-9">
                    <textarea pattern="^.{20,}$" class="form-control" name="synopsis" id="synopsis" required><?php echo $film->synopsis; ?></textarea>
                    <?php echo form_error('synopsis', '<div class="alert alert-dark alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>

                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-3 control-label">Description<sup class="text-danger">*</sup></label>
                <div class="col-sm-9">
                    <textarea pattern=".{20,}" class="form-control" name="description" id="description" required><?php echo $film->description; ?></textarea>
                    <?php echo form_error('description', '<div class="alert alert-dark alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div>


            <div class="form-group">
                <label for="trailer" class="col-sm-3 control-label">Trailer<sup class="text-danger">*</sup></label>
                <div class="col-sm-9">
                    <textarea pattern=".{20,}" class="form-control" name="trailer" id="trailer" required><?php echo $film->trailer; ?></textarea>
                    <?php echo form_error('trailer', '<div class="alert alert-dark alert-danger">
                    <button type="button" class="close" data-dismiss="alert">x</button>', '</div>'); ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-3">
                    <label class=" control-label">Distributeur</label>
                    <div class="">
                        <div class="radio">
                            <label>
                                <input type="radio" name="distributeur" value="Warner_Bros" class="px"
                                    <?php if ($film->distributeur == "Warner_bros") { ?>
                                        checked
                                    <?php } ?>
                                    >
                                <span class="lbl">Warner bros</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="distributeur" value="HBO" class="px"
                                    <?php if ($film->distributeur == "HBO") { ?>
                                        checked
                                    <?php } ?>
                                    >
                                <span class="lbl">HBO</span>
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="distributeur" value="Century_Fox" class="px"
                                    <?php if ($film->distributeur == "Century_Fox") { ?>
                                        checked
                                    <?php } ?>
                                    >
                                <span class="lbl">Century Fox</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="visible" class="px"
                                    <?php if ($film->visible == 1) { ?>
                                        checked
                                    <?php } ?>

                                    > <span class="lbl">Visible</span>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="cover" class="px"
                                    <?php if ($film->cover == 1) { ?>
                                        checked
                                    <?php } ?>

                                    > <span class="lbl">En couverture</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <hr class="panel-wide">


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /5. $JQUERY_VALIDATION -->



</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>