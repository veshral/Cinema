<?php
/*
* Controleur Categorie
*/
	class Categorie extends CI_Controller {


        public function __construct() {
            parent::__construct();

            $user = $this->session->userdata('user');

            if(empty($user)) {
                redirect('welcome/login');
            }
        }


		/* Fonction lister: Page qui va lister mes films */
		public function lister(){
            $data['allcat'] = $this->categorie_model->allCategories();

			$this->load->view('Categorie/lister', $data);
		}

		public function creer(){

            //initialisation de la configuration de l'upload
            $config['upload_path'] = './uploads/categories/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';
            $config['max_height'] = '1960';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);



            // validation des champs
			$this->form_validation->set_rules('title','Titre','required|min_length[5]|max_length[50]|is_unique[categories.title]');
            $this->form_validation->set_rules('description','Description','required|min_length[20]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');
            $this->form_validation->set_message('max_length', 'Le %s doit avoir un maximum de %s caractères.');
            $this->form_validation->set_message('is_unique', 'Le %s doit être unique.');

            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Categorie/creer');
            }

            else { // quand mon formulaire est valide

                $data = $this->upload->data();

                   //Action pour faire l'upload de mon fichier "image" et vérifier si
                   // mon fichier est incorrect
                    if ( !$this->upload->do_upload('image') && !empty($data["file_name"]) ) // erreur sur l'upload
                    {
                        // je récupère les messages d'erreur de mon fichier
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('Categorie/creer', $data);

                    } else { // mon upload s'est bien effectué et mon fichier est correct

                        $data = $this->upload->data();

                        // j'envoi à mon modèle le détail de ce fichier
                        $this->categorie_model->inserer($data); //m'enregistre une nouvelle catégorie

                        redirect('categorie/lister');

                    }
            }
		}

		public function editer($id){

            //initialisation de la configuration de l'upload
            $config['upload_path'] = './uploads/categories/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);



            // validation des champs
            $this->form_validation->set_rules('title','Titre','required|min_length[5]|max_length[50]');
            $this->form_validation->set_rules('description','Description','required|min_length[20]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');
            $this->form_validation->set_message('max_length', 'Le %s doit avoir un maximum de %s caractères.');


            //charger la catégorie
            $data['categorie'] = $this->categorie_model->getOneCatById($id);

            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Categorie/editer', $data);
            }

            else { // quand mon formulaire est valide

                //récupérer le détail de mon fichier (nom, extension...)
                $data = $this->upload->data();

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') && !empty($data['file_name']) ) // erreur sur l'upload
                {
                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();
                    $this->load->view('Categorie/editer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct

                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();

                    // j'envoi à mon modèle le détail de ce fichier
                    $this->categorie_model->editer($id, $data); //m'enregistre une nouvelle catégorie

                    redirect('categorie/lister', 'refresh');

                }


            }


		}

		public function voir($id){


            $data['categorie'] = $this->categorie_model->getOneCatById($id);
            $data['moviesforcat'] = $this->categorie_model->getMoviesForCat($id);

            $this->load->view('Categorie/voir', $data);
		}

        /*
        public function supprimer($id){
            $this->categorie_model->supprimer($id);

            $this->load->model('categorie_model');
            $report = $this->categorie_model->func();
            if (!$report['error']) {
                $this->session->set_flashdata('msg', 'Categorie supprimée !');
                redirect('categorie/lister');
            } else {
                $this->session->set_flashdata('msg', 'Erreur suppression catégorie');
                redirect('categorie/lister');
            }

        }
        */

        public function supprimer($id){

            $cat = $this->categorie_model->getOneCatById($id);
            // Ecriture du message flash en session
            // Success est ma clé de message, et le message est ma valeur d'affichage
            $this->session->set_flashdata('success', 'La catégorie ' . $cat->title . ' a bien été supprimée');


            $this->categorie_model->supprimer($id);
            redirect('categorie/lister');
        }

	}



?>