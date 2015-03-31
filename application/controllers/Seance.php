<?php
/*
* Controleur Seance
*/
class Seance extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        if(empty($user)) {
            redirect('welcome/login');
        }
    }

    /* Fonction lister: Page qui va lister mes films */
    public function lister(){
        $data['allseances'] = $this->seance_model->allSeances();

        $this->load->view('Seance/lister', $data);
    }

    public function creer(){

        // on récupère les films et cinema pour le select
        $data['films'] = $this->movie_model->allMovies();
        $data['cinemas'] = $this->cinema_model->allCinemas();


        $this->form_validation->set_rules('date_session','date','required');
        $this->form_validation->set_rules('heure_session','heure','required');
        $this->form_validation->set_rules('film','film','required');
        $this->form_validation->set_rules('cinema','cinema','required');


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Seance/creer', $data);
        }

        else { // quand mon formulaire est valide

            $this->seance_model->inserer(); //m'enregistre un nouveau tag
            redirect('seance/lister');
        }

    }

    public function editer($id){

        // on récupère les films et cinema pour le select
        $data['films'] = $this->movie_model->allMovies();
        $data['cinemas'] = $this->cinema_model->allCinemas();


        $this->form_validation->set_rules('date_session','date','required');
        $this->form_validation->set_rules('heure_session','heure','required');
        $this->form_validation->set_rules('film','film','required');
        $this->form_validation->set_rules('cinema','cinema','required');

        //charger la pour l'afficher dans les champs de la page d'édition
        $data['seance'] = $this->seance_model->getOneSeanceById($id);

        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Seance/editer', $data);
        }

        else { // quand mon formulaire est valide

            $this->seance_model->editer($id); //m'enregistre un nouveau tag
            redirect('seance/lister', 'refresh');
        }

    }

    public function supprimer($id){

        $seance = $this->seance_model->getOneSeanceById($id);

        // Ecriture du message flash en session
        // Success est ma clé de message, et le message est ma valeur d'affichage
        $this->session->set_flashdata('success', 'La session du ' . $seance->adate_session . ' à ' . $seance->heure_session . ' a bien été supprimée');


        $this->seance_model->supprimer($id);

        redirect('seance/lister');
    }


    public function voir($id){

        $data['seance'] = $this->seance_model->getOneSeanceById($id);
        $data['film'] = $this->movie_model->getMoviesBySeance($id);
        $data['cine'] = $this->cinema_model->getCineBySeance($id);

        $this->load->view('Seance/voir', $data);
    }


}