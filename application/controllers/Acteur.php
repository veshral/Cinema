<?php
/*
* Controleur Acteur
*/
	class Acteur extends CI_Controller {


        /**
         * Constructeur de ma classe
         */
        public function __construct() {
            parent::__construct();

        $user = $this->session->userdata('user');

            if(empty($user)) {
                redirect('welcome/login');
            }
        }



		/* Fonction lister: Page qui va lister mes films */
		public function lister(){
            $data['acteurs'] = $this->acteur_model->allActors();
			$this->load->view('Acteur/lister', $data);
		}

        /**
         * Page créer un acteur
         */
		public function creer(){

            $config['upload_path'] = './uploads/actors/';
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
            $this->form_validation->set_rules('firstname','Prénom','required|min_length[3]');
            $this->form_validation->set_rules('lastname','Nom','required|min_length[3]');
            $this->form_validation->set_rules('roles','Rôles','required');
            $this->form_validation->set_rules('dob','date de naissance','required');
            $this->form_validation->set_rules('biography','Biographie','required|min_length[10]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');


            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Acteur/creer');
            }

            else { // quand mon formulaire est valide

                //récupérer le détail de mon fichier (nom, extension...)
                $data = $this->upload->data();

                    //Action pour faire l'upload de mon fichier "image" et vérifier si
                    // mon fichier est incorrect
                    if ( !$this->upload->do_upload('image') && !empty($data["file_name"]) ) // erreur sur l'upload
                    {

                        // je récupère les messages d'erreur de mon fichier
                        $data['error'] = $this->upload->display_errors();

                        $this->load->view('Acteur/creer', $data);

                    } else { // mon upload s'est bien effectué et mon fichier est correct

                        $data = $this->upload->data();

                        $this->acteur_model->inserer($data); //m'enregistre un nouvel acteur

                        redirect('acteur/lister');
                    }

            }
        }

        /**
         * Page editer
         * @param $id
         */
		public function editer($id){

            $config['upload_path'] = './uploads/actors/';
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
            $this->form_validation->set_rules('firstname','Prénom','required|min_length[3]');
            $this->form_validation->set_rules('lastname','Nom','required|min_length[3]');
            $this->form_validation->set_rules('roles','Rôles','required');
            $this->form_validation->set_rules('dob','date de naissance','required');
            $this->form_validation->set_rules('biography','Biographie','required|min_length[10]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');


            //charger l'acteur
            $data['acteur'] = $this->acteur_model->getOneActorById($id);

            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Acteur/editer', $data);
            }

            else { // quand mon formulaire est valide

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
                {

                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();

                    $this->load->view('Acteur/editer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct

                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();

                    $this->acteur_model->editer($id, $data); //m'enregistre un nouvel acteur

                    redirect('acteur/lister', 'refresh');
                }
            }
		}

        /**
         * Page voir
         * @param $id
         */
		public function voir($id){
            $data['acteur'] = $this->acteur_model->getOneActorById($id);
            $data['moviesfromactor'] = $this->movie_model->getMoviesFromActor($id);

			$this->load->view('Acteur/voir', $data);
		}

        /**
         * Page supprimer
         * @param $id
         */
        public function supprimer($id){

            $acteur = $this->acteur_model->getOneActorById($id);

            // Ecriture du message flash en session
            // Success est ma clé de message, et le message est ma valeur d'affichage
            $this->session->set_flashdata('success'," L'acteur " . $acteur->firstname . " " . $acteur->lastname . " a bien été supprimé");


            $this->acteur_model->supprimer($id);

            redirect('acteur/lister');
        }

	}



?>