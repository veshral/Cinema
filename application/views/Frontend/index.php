
<?php $this->load->view('partials/header_frontend'); ?>


		<!-- Section: Services -->
		<section id="features">
			<div class="container">
				<!-- Header -->
				<header>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Acteurs</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>Ayant joués dans le plus de films</h2>
							<!-- <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>


                <?php
                $i=1;
                foreach($actors as $actor) { ?>

				<!-- Content -->
				<?php if($i==1 || $i==3) { ?><div class="row"><?php } ?>


					<div class="col-xs-6 col-sm-6 i wow <?php if($i==1 || $i==3) { ?>fadeInLeft<?php }else{ ?> fadeInRight <?php } ?> animated" data-wow-duration="0.5s" data-wow-delay="0.<?php echo $i; ?>s">
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-5 col-md-offset-0 col-lg-4 icon">
								<div class="c">

                                        <div class="text-center">
										    <img style="max-height: 130px" src="<?php echo $actor->image; ?>" alt="<?php echo $actor->firstname; ?> <?php echo $actor->lastname; ?>">
                                        </div>

								</div>
							</div>
							<div class="col-xs-12 col-md-7 col-lg-8">
								<h3><?php echo $actor->firstname; ?> <?php echo $actor->lastname; ?></h3>
								<p> <?php echo readmoremodal($actor->biography, "200"); ?> <a href="#" data-toggle="modal" data-target="#modalText<?php echo $actor->id; ?>">lire la suite...</a></p>
							</div>
						</div>
					</div>

                <?php if($i==2 || $i==4) { ?></div><?php } ?>

                    <!-- Modals -->
                    <div class="modal fade" id="modalText<?php echo $actor->id; ?>" tabindex="-1" role="dialog" aria-labelledby="modalText" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times"></span></button>
                                    <h4 class="modal-title" id="myModalLabel"><?php echo $actor->firstname; ?> <?php echo $actor->lastname; ?></h4>
                                    <div class="info subtitle"><span class="fa fa-birthday-cake"></span> <?php echo $actor->age; ?> ans  |  <span class="fa fa-building"></span>Ville : <?php echo $actor->city; ?></div>
                                </div>
                                <!-- <p class="intro">Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu. Vestibu lum sit amet imperdiet tellus.</p> -->
                                <div class="modal-body">
                                    <img src="<?php echo $actor->image; ?>" alt="<?php echo $actor->firstname; ?> <?php echo $actor->lastname; ?>" width="200" height="255" class="pull-right">
                                    <p><?php echo strip_tags($actor->biography); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>



                <?php
                $i++;
                } ?>



			</div>
		</section>

		<!-- Testimonials -->
		<section id="testimonials">
			<div class="container">
				<div class="row">
					<!-- Carousel -->
					<div class="j-carousel">

                        <?php foreach($coms as $com) { ?>

                            <!-- Carousel item -->
                            <div class="item col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                                <blockquote>
                                    <i class="fa quotes fa-quote-left"></i>
                                    <p>"<?php echo $com->ccontent; ?>"</p>

                                    <cite>- <?php echo $com->username; ?> - à propos du film "<?php echo $com->film; ?>"</cite>
                                </blockquote>
                            </div>

                        <?php } ?>

					</div>
				</div>
			</div>
		</section>

		<!-- Portfolio -->
		<section id="portfolio">
			<div class="container">
				<!-- Header -->
				<header>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Séances</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>Par catégories</h2>
							<!-- <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>

				<!-- Filter -->
				<ul class="filter clearfix">
					<li class="active"><a href="#" title="#" data-filter="all">Tous</a></li>
					<li><a href="#" title="#" data-filter="Fantastique">Fantastique</a></li>
					<li><a href="#" title="#" data-filter="Action">Action</a></li>
					<li><a href="#" title="#" data-filter="Policier">Policier</a></li>
                    <li><a href="#" title="#" data-filter="Sciences-fictions">Sciences-fiction</a></li>
				</ul>


				<!-- Content -->
				<ul id="og-grid" class="row og-grid">

                    <?php
                    $i=1;
                    foreach($seances as $seance) { ?>

                        <li class="i all <?php echo $seance->title; ?>">
                            <a class="c borderedHover wow fadeInUp" data-wow-delay="<?php echo $i/10*3; ?>s"
                               href="www.projectname1.com" data-largesrc="<?php echo $seance->image; ?>"
                               data-title="<?php echo $seance->filmtitre; ?>"
                               data-description="<p>Séance : Le <?php echo $seance->date_session; ?> à <?php echo $seance->heure_session; ?></p><p>Cinema : <?php echo $seance->cinetitre; ?></p><p>Description du film : <?php echo strip_tags($seance->description); ?>">
                               <div class="wrap">
                                    <div class="info">
                                        <div class="info-wrap">
                                            <i class="icon fa fa-expand"></i>
                                            <h4><?php echo $seance->filmtitre; ?></h4>
                                            <h3><?php echo $seance->cinetitre; ?></h3>
                                            <h3>Le <?php echo $seance->date_session; ?> à <?php echo $seance->heure_session; ?></h3>
                                        </div>
                                    </div>
                                    <img src="<?php echo $seance->image; ?>" alt="#" width="310" height="310">
                               </div>
                            </a>

                            <!-- More detail info: social -->
                            <ul class="social">
                                <li><a href="#" title="#" class="icon"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" title="#" class="icon"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#" title="#" class="icon"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#" title="#" class="icon"><i class="fa fa-linkedin"></i></a></li>
                            </ul>
                        </li>

                    <?php
                    $i++; } ?>

				</ul>
			</div>
		</section>


		<!-- Video -->

        <style type="text/css">
            .video .parallax {
                background-image: url(<?php echo $video->image; ?>);
            }

        </style>

		<section class="video">
			<div class="parallax js-video" data-mfp-src="<?php echo $video->trailer; ?>">
				<div class="container content">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
							<span class="icon">
								<i class="fa fa-play"></i>
							</span>
							<h2>Film sorti cette année et le mieux noté par la presse : <?php echo $video->title; ?></h2>
						</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Charts -->
		<section class="charts">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-4 i">
						<div class="chart" data-percent="<?php echo $nbfilmsdiff/$nbfilms->nb*100; ?>"><span><?php echo round($nbfilmsdiff/$nbfilms->nb*100); ?>%</span></div>
						<h3>Films</h3>
						<h4>en salle</h4>
					</div>
					<div class="col-xs-12 col-sm-4 i">
						<div class="chart" data-percent="<?php echo $nbfilmscomac/$nbfilms->nb*100; ?>"><span><?php echo round($nbfilmscomac/$nbfilms->nb*100); ?>%</span></div>
						<h3>Films</h3>
						<h4>commentés</h4>
					</div>
					<div class="col-xs-12 col-sm-4 i">
						<div class="chart" data-percent="<?php echo $nbfilmsfav->nb/$nbfilms->nb*100; ?>"><span><?php echo round($nbfilmsfav->nb/$nbfilms->nb*100); ?>%</span></div>
						<h3>Films</h3>
						<h4>likés</h4>
					</div>
				</div>
			</div>
		</section>
		
		<!-- About -->
		<section id="about" >
			<div class="container">
				<!-- Header -->
				<header class="font-white">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Catégories</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>les plus réputées</h2>
							<!-- <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>

				<!-- Content -->
				<div class="row">
					<div class="col-xs-12 col-sm-6">
						<img src="<?php echo base_url('assets/frontend/img/phone.png'); ?>" alt="" width="514" height="336" class="img-responsive wow bounceInLeft">
					</div>
					<div class="col-xs-12 col-sm-6">
						<ul class="skills">

                            <?php
                            $i=1;
                            foreach($cats as $cat) { ?>

                                <li><div class="wow animated fadeInLeft" data-wow-duration="1s" data-delay="0.<?php echo $i*2; ?>s" style="width: <?php echo $cat->nbmov/$nbfilms->nb*100; ?>%"><?php echo $cat->cat; ?> / <?php echo round($cat->nbmov/$nbfilms->nb*100); ?>%</div></li>

                            <?php
                            $i++;
                             } ?>

						</ul>
					</div>
				</div>
			</div>
		</section>

		<!-- Blog -->
		<section id="blog">
			<div class="container">
				<!-- Header -->
				<header>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Les 2 films</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>ayant le plus de commentaires</h2>
							<!-- <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>

				<!-- Content -->
				<div class="row articles">


                    <?php
                    $i=1;
                    foreach($filmscom as $filmcom) { ?>

                        <!-- Article -->
                        <article class="col-xs-4 article wow animated <?php if($i==1) { ?>col-xs-offset-2 fadeInLeft<?php }else{ ?>fadeInRight<?php } ?>">
                            <a href="#" title="#" class="c borderedHover">
                                <div class="wrap">
                                    <div class="info">
                                        <div class="info-wrap">
                                            <!-- <i class="fa fa-plus"></i> -->
                                            <div class="more"><?php echo $filmcom->title; ?></div>
                                        </div>
                                    </div>
                                    <img src="<?php echo $filmcom->image; ?>" alt="<?php echo $filmcom->title; ?>" width="300" height="350">
                                </div>
                            </a>
                            <div class="row">
                                <div class="col-lg-2 visible-lg asideArticleInfo">

                                    <div class="comments">
                                        <i class="fa fa-comments"></i> <?php echo $filmcom->nb; ?>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <h3><a href="blog-detail.html" title="#"><?php echo $filmcom->title; ?></a></h3>
                                    <div class="articleInfo clearfix">
                                       <!--  <div class="i">Post by: <strong>John Doe</strong></div> -->
                                        <div class="i">Catégorie: <a href="blog-listing.html"><strong><?php echo $filmcom->ctitle; ?></strong></a></div>
                                    </div>
                                    <p><?php echo readmoremodal($filmcom->description, 200); ?><a href="blog-detail.html" title="#"> lire plus...</a></p>
                                </div>
                            </div>
                        </article>



                    <?php $i++; } ?>



				<!-- More posts
				<div class="text-center">
					<a href="blog-listing.html" title="#" class="btn btn-default btn-lg morePosts"><i class="fa fa-plus"></i> More posts</a>
				</div>	 -->
			</div>
		</section>

		<!-- Counter -->
		<section class="counter striped-image">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-3 i">
						<i class="fa fa-film icon"></i>
						<h3 class="timer" data-to="<?php echo $filmsout; ?>" data-speed="3000"><?php echo $filmsout; ?></h3>
						<h4>Films déjà sortis</h4>
					</div>
					<div class="col-xs-12 col-sm-3 i">
						<i class="fa fa-user icon"></i>
						<h3 class="timer" data-to="<?php echo $admins; ?>" data-speed="3000"><?php echo $admins; ?></h3>
						<h4>Administrateurs actifs</h4>
					</div>
					<div class="col-xs-12 col-sm-3 i">
						<i class="fa fa-clock-o icon"></i>
						<h3 class="timer" data-to="<?php echo $filmsduree->duree; ?>" data-speed="3000"><?php echo $filmsduree->duree; ?></h3>
						<h4>Heures de films</h4>
					</div>
					<div class="col-xs-12 col-sm-3 i">
						<i class="fa fa-heart icon"></i>
						<h3 class="timer" data-to="<?php echo $nbfav; ?>" data-speed="3000"><?php echo $nbfav; ?></h3>
						<h4>Favoris</h4>
					</div>
				</div>
			</div>
		</section>	

		<!-- Team -->
		<section id="team">
			<div class="container">
				<!-- Header -->
				<header>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Les 3 meilleurs réalisateurs</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<!-- <h2>Creative brains</h2>
							<p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>

				<!-- Content -->
				<div class="row">

                    <?php
                    $i=1;
                    foreach($realisateurs as $realisateur) { ?>


                        <div class="col-xs-12 col-sm-4 i wow fadeInUp animated" data-wow-duration="0.5s" data-wow-delay="0.<?php echo $i*2; ?>s">
                            <div class="c">
                                <div class="wrap">
                                    <div class="info">
                                        <div class="info-wrap">
                                            <div class="share"><?php echo $realisateur->nb; ?> films réalisés</div>
                                            <!-- <div class="social">
                                                <a href="#" title="#"><i class="fa fa-facebook"></i></a>
                                                <a href="#" title="#"><i class="fa fa-twitter"></i></a>
                                                <a href="#" title="#"><i class="fa fa-linkedin"></i></a>
                                                <a href="#" title="#"><i class="fa fa-google-plus"></i></a>
                                            </div> -->
                                        </div>
                                    </div>
                                    <img src="<?php echo $realisateur->image; ?>" alt="#" width="600" height="350" class="img-responsive">
                                </div>
                            </div>
                            <h3><?php echo $realisateur->prenom; ?> <?php echo $realisateur->nom; ?></h3>
                            <h4><?php echo $realisateur->age; ?> ans</h4>

                            <p><?php echo $realisateur->biography; ?></p>
                        </div>


                    <?php
                    $i++; }
                    ?>
				</div>
			</div>
		</section>

		<!-- Social -->
		<section id="social">
			<div class="container">
				<div class="row">
					<!-- Carousel -->
					<div class="j-carousel">

                        <?php
                        foreach($tweets as $tweet) { ?>

                            <!-- Carousel item -->
                            <div class="item col-xs-10 col-xs-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                                <span class="fa fa-twitter icon"></span>
                                <p><?php echo $tweet['text']; ?></p>
                                <div class="author">- @allocine -</div>
                            </div>

                        <?php } ?>

					</div>
				</div>
			</div>
		</section>

		<!-- Pricing -->
		<section id="pricing">
			<div class="container">
				<!-- Header -->
				<header>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Prix</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>des 3 derniers films</h2>
							<!-- <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu.</p> -->
						</div>
					</div>
				</header>

				<!-- Content -->
				<div class="row">

                    <?php
                    $i=1;
                    foreach ($filmsshop as $filmshop) { ?>
                        <div class="col-xs-12 col-sm-4 i wow <?php if ($i == 1) { ?>fadeInLeft <?php }elseif ($i == 2) { ?>active fadeInUp<?php } else { ?>fadeInRight <?php } ?> animated" data-wow-duration="0.5s" data-wow-delay="0.2s">
                            <div class="wrap borderedHover">
                                <div class="c">
                                    <h3><?php echo $filmshop->title; ?></h3>
                                    <div class="price price-lg"><?php echo $filmshop->price; ?><sup>€</sup></div>
                                    <div class="info">
                                        Budget : <?php echo $filmshop->budget; ?><sup>€</sup><br />
                                        <?php echo $filmshop->duree; ?> heures<br />
                                        Distributeur : <?php echo $filmshop->distributeur; ?><br />
                                        Note: <?php echo generatestar($filmshop->note_presse); ?><br />
                                        Catégorie : <?php echo $filmshop->cat; ?>
                                    </div>
                                    <!-- <a href="#" title="#" class="btn btn-default btn-lg">Sign up</a> -->
                                </div>
                            </div>
                        </div>

                    <?php
                    $i++; } ?>

				</div>
			</div>
		</section>

		<!-- Contact -->
		<section id="contact" >
			<div class="container">
				<!-- Header -->
				<header class="font-white">
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2 wow fadeInDown">
							<h1>Contactez-moi</h1>
							<div class="dotted-break">
								<span></span><span></span><span></span><span></span><span></span>
							</div>
							<h2>Boyer Julien</h2>
						</div>
					</div>
				</header>

				<!-- Content -->		
				<div class="row">
					<div class="col-xs-12 info">
						<span class="wow fadeInRight" data-wow-delay="0.2s"><i class="fa fa-location-arrow icon"></i> 26 Rue Emile Decorps </span>
						<span class="wow fadeInRight" data-wow-delay="0.4s"><i class="fa fa-envelope-o icon"></i> julien@meetserius.com</span>
						<span class="wow fadeInRight" data-wow-delay="0.6s"><i class="fa fa-phone icon"></i>+33(0) 6 74 58 56 48</span>
					</div>
					<div class="col-xs-12 col-sm-8 col-sm-offset-2">
						<form action="<?php echo site_url('frontend/index') ?>" method="post" role="form" data-parsley-validate>
							<input name="nom" type="text" class="form-control wow fadeInLeft" data-wow-delay="0.2s" placeholder="Nom" required data-parsley-error-message="Entrez votre nom">
							<input name="email" type="email" class="form-control wow fadeInLeft" data-wow-delay="0.4s" placeholder="Email" required data-parsley-error-message="Entrez votre email">
							<textarea name="message" class="form-control wow fadeInLeft" data-wow-delay="0.6s" rows="6" placeholder="Message" required data-parsley-error-message="Entrez votre message"></textarea>
							<button type="submit" class="btn btn-lg wow fadeInUp" data-wow-delay="1s">Envoyer</button>
						</form>
					</div>
				</div>
			</div>
		</section>

		<!-- Google map -->
		<div class="googleMapWrap">
			<div id="googleMap" class="wow flipInX" data-lat="45.757222" data-lng="4.898881"></div>
		</div>


<!-- Modals -->
<div class="modal fade" id="modalText1" tabindex="-1" role="dialog" aria-labelledby="modalText" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times"></span></button>
                <h4 class="modal-title" id="myModalLabel">This might be a detail of simple article</h4>
                <div class="info subtitle"><span class="fa fa-calendar"></span> 26th march 2014  |  <span class="fa fa-user"></span> John Doe</div>
            </div>
            <p class="intro">Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu. Vestibu lum sit amet imperdiet tellus.</p>
            <div class="modal-body">
                <img src="<?php echo base_url('assets/frontend/tmp/340x255-1.jpg'); ?>" alt="#" width="340" height="255" class="img-responsive pull-right">
                <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod.</p>
                <p>Morbi id nisi vitae felis consequat consequat ut non arcu. Vestibu lum sit amet imperdiet tellus. eget, posuere eros. Etiam ultricies vel leo at euismod. Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros.</p>
                <p>Nulla diam ex, aliquet vel iaculis vitae, consectetur et lectus. Mauris eu scelerisque ligula. Fusce in purus accumsan, faucibus lorem eget, posuere eros. Etiam ultricies vel leo at euismod. Morbi id nisi vitae felis consequat consequat ut non arcu. Vestibu lum sit amet imperdiet tellus. eget, posuere eros. Etiam ultricies vel leo at euismod.</p>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('partials/footer_frontend'); ?>
