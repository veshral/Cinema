<?php
/*
* Controleur Realisateur
*/
	class Realisateur extends CI_Controller {

        public function __construct() {
            parent::__construct();

            $user = $this->session->userdata('user');

            if(empty($user)) {
                redirect('welcome/login');
            }
        }


		public function lister(){
            $data['realisateurs'] = $this->realisateur_model->allRealisateurs();
			$this->load->view('Realisateur/lister', $data);
		}

        public function creer(){

            $config['upload_path'] = './uploads/directors/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';
            $config['max_height'] = '1000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // validation des champs
            $this->form_validation->set_rules('firstname','Prénom','required|min_length[3]');
            $this->form_validation->set_rules('lastname','Nom','required|min_length[3]');
            $this->form_validation->set_rules('dob','date de naissance','required');
            $this->form_validation->set_rules('biography','Biographie','required|min_length[10]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');


            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Realisateur/creer');
            }

            else { // quand mon formulaire est valide

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
                {

                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();

                    $this->load->view('Realisateur/creer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct

                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();


                $this->realisateur_model->inserer($data); //m'enregistre un nouveau réalisateur

                redirect('realisateur/lister');
                }
            }
        }

		public function editer($id){
            $config['upload_path'] = './uploads/directors/';
            if(!is_dir($config['upload_path']))
            {
                mkdir($config['upload_path'],0777);
            }
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '4048';
            $config['max_height'] = '1000';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            // validation des champs
            $this->form_validation->set_rules('firstname','Prénom','required|min_length[3]');
            $this->form_validation->set_rules('lastname','Nom','required|min_length[3]');
            $this->form_validation->set_rules('dob','date de naissance','required');
            $this->form_validation->set_rules('biography','Biographie','required|min_length[10]');

            //Personnalisation des erreurs
            $this->form_validation->set_message('required', 'Le %s doit être rempli');
            $this->form_validation->set_message('min_length', 'Le %s doit avoir un minimum de %s caractères.');

            //charger le realisateur
            $data['realisateur'] = $this->realisateur_model->getOneDirectorById($id);

            //Si mon formulaire contient des erreurs
            if ($this->form_validation->run() == FALSE) {
                $this->load->view('Realisateur/editer', $data);
            }

            else { // quand mon formulaire est valide

                //Action pour faire l'upload de mon fichier "image" et vérifier si
                // mon fichier est incorrect
                if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
                {

                    // je récupère les messages d'erreur de mon fichier
                    $data['error'] = $this->upload->display_errors();

                    $this->load->view('Realisateur/editer', $data);

                } else { // mon upload s'est bien effectué et mon fichier est correct

                    //récupérer le détail de mon fichier (nom, extension...)
                    $data = $this->upload->data();


                    $this->realisateur_model->editer($id, $data); //m'enregistre un nouveau réalisateur

                    redirect('realisateur/lister', 'refresh');
                }
            }
		}

		public function voir($id){
            $data['realisateur'] = $this->realisateur_model->getOneDirectorById($id);
            $data['moviesfromdirector'] = $this->movie_model->getMoviesFromDirector($id);

            $this->load->view('Realisateur/voir', $data);
		}

        public function supprimer($id){

            $real = $this->realisateur_model->getOneDirectorById($id);

            // Ecriture du message flash en session
            // Success est ma clé de message, et le message est ma valeur d'affichage
            $this->session->set_flashdata('success', 'Le réalisateur ' . $real->firstname . ' ' . $real->lastname . ' a bien été supprimé');


            $this->realisateur_model->supprimer($id);

            redirect('realisateur/lister');
        }

	}



?>