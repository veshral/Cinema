<?php
/*
* Controleur Movie
*/
	class Movie extends CI_Controller {

        public function __construct() {
            parent::__construct();

            $user = $this->session->userdata('user');

            //Activer le profiler : suivre la santé de mon application
            // $this->output->enable_profiler(TRUE);

            if(empty($user)) {
                redirect('welcome/login');
            }
        }


		/* Fonction lister: Page qui va lister mes films */
		public function lister(){

            // $data est mon transporteur de données (tableau )
            $data['movies'] = $this->movie_model->allMovies();



            //PAGINATION
            $config['base_url'] = base_url(). 'index.php/movie/lister/'; //Url que va prendre ma pagination
            $config['first_url'] = '1'; // ma premier pagination qui commencera à 1
            $config['total_rows'] = $this->movie_model->count_items(); // nombre total de films que l'on aura
            $config['per_page'] = 4; //nombre de résultat par page
            $config['num_links'] = 1; // numérotation des liens
            $config['use_page_numbers'] = TRUE; //utiliser la syntaxe des pages 1,2,3,4...

            $config['next_link'] = 'Page suivante';
            $config['prev_link'] = 'Page précédente';
            $config['last_link'] = 'Page fin';
            $config['first_link'] = 'Début';
            $config['full_tag_open'] = "<ul class='pagination pagination-sm'>";
            $config['full_tag_close'] = "</ul>";
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
            $config['cur_tag_close'] = "<span class='sr-only'></span></a></li></li>";
            $config['next_tag_open'] = "<li>";
            $config['next_tagl_close'] = "</li>";
            $config['prev_tag_open'] = "<li>";
            $config['prev_tagl_close'] = "</li>";
            $config['first_tag_open'] = "<li>";
            $config['first_tagl_close'] = "</li>";
            $config['last_tag_open'] = "<li>";
            $config['last_tagl_close'] = "</li>";

            $this->pagination->initialize($config);

            $page = $this->uri->segment(3); //récupère le numéro de ma page
            // movie/lister/2

            if(empty($page)) {
                $current = 1 ;
            }else{
                $current = $page;
            }

            //j'appelle mon modèle et sa fonction filmpaginer puis je fixe la limite et le début
            $data['filmscat'] = $this->movie_model->filmpaginer($config['per_page'],($current - 1) * $config['per_page']);

            // FIN PAGINATION


			// j'appelle ma vue lister et je lui transmets mon transporteur $data
			$this->load->view('Movie/lister', $data);

		}


        public function regex_check_image($str)
        {
            if (preg_match("/^https?\:\/\/(www)?\.?[a-z0-9-]+\.[a-z]{2,3}\/[a-zA-Z0-9-._\/]+\.((jpe?g)|(png))$/", $str))
            {
                return TRUE;
            }
            else
            {
                $this->form_validation->set_message('regex_check_image', "Le format de l'url de l'image est incorrect.");
                return FALSE;
            }
        }

		public function creer(){


            //initialisation de la configuration de l'upload
            $config['upload_path'] = './uploads/movies/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';
            $config['max_height'] = '1960';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            $data['categoriesform'] = $this->categorie_model->allCategories();

            // validation des champs
            $this->form_validation->set_rules('title','Titre','required|min_length[3]');
            $this->form_validation->set_rules('annee','Année','required|integer|exact_length[4]');
            $this->form_validation->set_rules('budget','Budget','required|integer|min_length[1]');
            $this->form_validation->set_rules('date_release','Date de sortie','required');
            //$this->form_validation->set_rules('image','Image','callback_regex_check_image');
            $this->form_validation->set_rules('synopsis','Synopsis','required|min_length[20]');
            $this->form_validation->set_rules('description','Description','required|min_length[20]');
            $this->form_validation->set_rules('trailer','Trailer','required|min_length[20]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le champ "%s" doit être rempli');
            $this->form_validation->set_message('min_length', 'Le champ "%s" doit avoir un minimum de %s caractères.');
            $this->form_validation->set_message('regex_match', 'Format incorrect.');
            $this->form_validation->set_message('exact_length', 'Le champ "%s" doit comporter "%s" caractères.');
            $this->form_validation->set_message('integer', 'Le champ "%s" doit comporter uniquement des chiffres entiers.');



            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Movie/creer', $data);
            }

            else { // quand mon formulaire est valide

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
                {

                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();

                    $this->load->view('Movie/creer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct


                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();

                      /*
                      * Créer une miniature avec la librairie  image_library et la configuration
                      */
                      $config['image_library'] = 'gd2';
                      $config['source_image'] = './uploads/movies/'.$data['file_name'];
                      $config['create_thumb'] = TRUE;
                      $config['maintain_ratio'] = TRUE;
                      $config['width']    = 300;
                      $config['height']   = 100;

                      // je charge la librairie image_lib avec sa configuration juste en dessus
                      $this->load->library('image_lib', $config);

                      $this->image_lib->resize();


                    // j'envoi à mon modèle le détail de ce fichier
                    $this->movie_model->inserer($data); //m'enregistre un nouveau film

                    redirect('movie/lister');


                }
            }
		}

		public function editer($id){

            //initialisation de la configuration de l'upload
            $config['upload_path'] = './uploads/movies/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';
            $config['max_height'] = '1960';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);


            $data['categoriesform'] = $this->categorie_model->allCategories();

            // validation des champs
            $this->form_validation->set_rules('title','Titre','required|min_length[3]');
            $this->form_validation->set_rules('annee','Année','required|integer|exact_length[4]');
            $this->form_validation->set_rules('budget','Budget','required|integer|min_length[1]');
            $this->form_validation->set_rules('date_release','Date de sortie','required');
            //$this->form_validation->set_rules('image','Image','callback_regex_check_image');
            $this->form_validation->set_rules('synopsis','Synopsis','required|min_length[20]');
            $this->form_validation->set_rules('description','Description','required|min_length[20]');
            $this->form_validation->set_rules('trailer','Trailer','required|min_length[20]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le champ "%s" doit être rempli');
            $this->form_validation->set_message('min_length', 'Le champ "%s" doit avoir un minimum de %s caractères.');
            $this->form_validation->set_message('regex_match', 'Format incorrect.');
            $this->form_validation->set_message('exact_length', 'Le champ "%s" doit comporter "%s" caractères.');
            $this->form_validation->set_message('integer', 'Le champ "%s" doit comporter uniquement des chiffres entiers.');


            //charger le film
            $data['film'] = $this->movie_model->getOneMovieById($id);


            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Movie/editer', $data);
            }

            else { // quand mon formulaire est valide

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
                {

                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();

                    $this->load->view('Movie/editer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct

                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();

                     /*
                      * Créer une miniature avec la librairie  image_library et la configuration
                      */
                      $config['image_library'] = 'gd2';
                      $config['source_image'] = './uploads/movies/'.$data['file_name'];
                      $config['create_thumb'] = TRUE;
                      $config['maintain_ratio'] = TRUE;
                      $config['width']    = 300;
                      $config['height']   = 100;

                      // je charge la librairie image_lib avec sa configuration juste en dessus
                      $this->load->library('image_lib', $config);

                      $this->image_lib->resize();

                    // j'envoi à mon modèle le détail de ce fichier
                    $this->movie_model->editer($id, $data); //m'enregistre un nouveau film

                    redirect('movie/lister', 'refresh');


                }
            }


		}


        public function recapitulatif(){
            $data['panier'] = $this->panier->getPanier();
            $this->load->view('Movie/recapitulatif', $data);

        }

		public function voir($id){

            //Je transmets au modèle mon argument $id récupéré depuis l'URL
            $data['film'] = $this->movie_model->getOneMovieById($id);

            $data['comsfrommovie'] = $this->comment_model->getComsFromMovie($id);

            $data['actorsfrommovie'] = $this->acteur_model->getActorsFromMovie($id);

            $data['directorsfrommovie'] = $this->realisateur_model->getDirectorsFromMovie($id);

            $this->load->view('Movie/voir', $data);
		}

        // Active la visibilité d'un film
        public function visibilityOn($id){

            $this->movie_model->visibilityOn($id);

            redirect('movie/lister');
        }


        // Désactive la visibilité d'un film
        public function visibilityOff($id){

            $this->movie_model->visibilityOff($id);

            redirect('movie/lister');
        }

        // Active la mise en avant d'un film
        public function coverOn($id){

            $this->movie_model->coverOn($id);

            redirect('movie/lister');
        }

        // désactive la mise en avant d'un film
        public function coverOff($id){

            $this->movie_model->coverOff($id);

            redirect('movie/lister');
        }

        public function supprimer($id){

            $film = $this->movie_model->getOneMovieById($id);

            // Ecriture du message flash en session
            // Success est ma clé de message, et le message est ma valeur d'affichage
            $this->session->set_flashdata('success', 'Votre film ' . $film->title . ' a bien été supprimé');

            $this->movie_model->supprimer($id);

            redirect('movie/lister');
        }



        /* Moteur de recherche */

        public function rechercher() {

            $this->form_validation->set_rules('mot','mot','required|min_length[3]');

            $this->form_validation->set_message('required','le champ de recherche doit être rempli');
            $this->form_validation->set_message('min_length','le champ de recherche doit avoir un minimum de 3 caractères.');
            $data['mot'] = $this->input->post('mot');

            //si mon formulaire comporte des erreurs
            if ($this->form_validation->run() == FALSE) {
                $data['movies'] = array();
                $this->load->view('Movie/rechercher', $data);

            } else { // si mon formulaire est correct
                $movies = $this->movie_model->rechercher();
                $data['movies']= $movies;
                $this->load->view('Movie/rechercher', $data);

            }

        }

        public function ajaxMovies(){
            $movies = $this->movie_model->rechercheAjax(); // je vais recherche mes films

            echo json_encode($movies);
            return true;
        }


        /**
         * Augmenter la quantité du panier
         * @param $id
         */
        public function augmenter($id){
            $this->panier->augmenter($id);
            $this->session->set_flashdata('success', 'La quantité a bien été augmentée');
            redirect('movie/recapitulatif');
        }

        /**
         * Diminuer la quantité du panier
         * @param $id
         */
        public function diminuer($id){
            $this->panier->diminuer($id);
            $this->session->set_flashdata('success', 'La quantité a bien été diminuée');
            redirect('movie/recapitulatif');
        }

        /**
         * Supprimer un film de mon panier
         * @param $id
         */
        public function removecart($id){
            $this->panier->deletePanier($id);
            $this->session->set_flashdata('success', 'Votre film a bien été suprimmer du panier');
            redirect('movie/recapitulatif');
        }

        /**
         * Ajouter un film à mon panier
         * @param $id
         */
        public function addCart($id){
            $this->panier->insertPanier($id);
            $this->session->set_flashdata('success', 'Votre film a bien été ajouter au panier');
            redirect('movie/lister');
        }
	}



?>