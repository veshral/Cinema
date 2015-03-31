<?php
/*
* Controleur Cinema
*/
class Cinema extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        if(empty($user)) {
            redirect('welcome/login');
        }
    }


    /* Fonction lister: Page qui va lister mes films */
    public function lister(){
        $data['allcinenbmov'] = $this->cinema_model->allCinemasNbMov();

        $this->load->view('Cinema/lister', $data);
    }

    public function voir($id){
        $data['cine'] = $this->cinema_model->getOneCineById($id);
        $data['filmsparcine'] = $this->movie_model->getMoviesByCine($id);

        $this->load->view('Cinema/voir', $data);
    }


    public function creer(){


        // validation des champs
        $this->form_validation->set_rules('title','Nom','required|min_length[3]');
        $this->form_validation->set_rules('ville','Ville','required|min_length[3]');
        $this->form_validation->set_rules('position','Position','integer');


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Cinema/creer');
        }
        else { // quand mon formulaire est valide

            // j'envoi à mon modèle le détail de ce fichier
            $this->cinema_model->inserer(); //m'enregistre un nouveau cinema

            redirect('cinema/lister');


        }
    }


    public function supprimer($id){

        $cine = $this->cinema_model->getOneCineById($id);
        // Ecriture du message flash en session
        // Success est ma clé de message, et le message est ma valeur d'affichage
        $this->session->set_flashdata('success', 'Le cinema ' . $cine->title . ' a bien été supprimé');


        $this->cinema_model->supprimer($id);
        redirect('cinema/lister');
    }

    public function editer($id){


        // validation des champs
        $this->form_validation->set_rules('title','Nom','required|min_length[3]');
        $this->form_validation->set_rules('ville','Ville','required|min_length[3]');
        $this->form_validation->set_rules('position','Position','integer');

        //charger les cinemas pour les afficher dans les champs de la page d'édition
        $data['cine'] = $this->cinema_model->getOneCineById($id);

        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Cinema/editer', $data);
        }
        else { // quand mon formulaire est valide


            $this->cinema_model->editer($id); //Modifie le cinema

            redirect('cinema/lister', 'refresh');


        }
    }



}