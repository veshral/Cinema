<!-- Vue header incluse -->
<?php $this->load->view('partials/header'); ?>

<!-- Vue sidebar incluse -->
<?php $this->load->view('partials/sidebar'); ?>


<div id="content-wrapper">

<div class="page-header">
    <h1><i class="fa fa-search page-header-icon"></i>&nbsp;&nbsp;Résultats de recherche</h1>
</div> <!-- / .page-header -->

<div class="search-text alert alert-warning">
    <strong><?php echo COUNT($movies); ?></strong> résultats trouvés pour : <span class="text-primary"><?php echo $mot; ?></span>
</div> <!-- / .search-text -->

<!-- Tabs -->
<div class="search-tabs">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#search-tabs-all" data-toggle="tab">Films <span class="label label-primary"><?php echo COUNT($movies); ?></span></a>
        </li>
    </ul> <!-- / .nav -->
</div>
<!-- / Tabs -->

<!-- Panel -->
<div class="panel search-panel">

    <!-- Search form -->
    <form method="post" action="<?php echo site_url('Movie/rechercher'); ?>" class="search-form bg-primary">
        <div class="input-group input-group-lg">
            <span class="input-group-addon no-background"><i class="fa fa-search"></i></span>
            <input type="text"  class="form-control searchfilms" placeholder="Rechercher" required name="mot" value="<?php echo set_value('mot'); ?>">
					<span class="input-group-btn">
						<button class="btn" type="submit">Rechercher</button>
					</span>
        </div> <!-- / .input-group -->
    </form>
    <!-- / Search form -->

<!-- Search results -->
<div class="panel-body tab-content">

<!-- Classic search -->
<div class="search-classic tab-pane fade in active" id="search-tabs-all">

    <?php

    if(!empty($movies)){
        foreach ($movies as $movie) { ?>
            <div>
                <h3>
                    <a class="search-title" href="<?php echo site_url('movie/voir/'.$movie->id) ?>"><?php echo $movie->mtitle ;?>
                    </a>
                </h3>
                <hr />
                
                <div class="search-content">
                    <div class="row">
                        <div class="col-md-2">
                            <a class="thumbnail">
                                <img class="" src="<?php echo $movie->mimage ;?>" />
                            </a>
                        </div>
                        <div class="col-md-10">
                            <?php echo strip_tags($movie->synopsis) ;?>
                            <div class="row">
                                <div class="pull-right">
                                    <a href="<?php echo site_url('movie/voir/'.$movie->id) ?>" class="btn btn-danger"><span class="fa fa-plus"></span> Voir plus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }else{
        echo "<div class='alert alert-danger'>Remplissez le moteur de recherche</div";
    }?>



</div>
<!-- / Classic search -->

</div>




<!-- Vue footer incluse -->
<?php $this->load->view('partials/footer'); ?>