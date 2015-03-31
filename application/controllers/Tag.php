<?php
/*
* Controleur tag
*/
class Tag extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        if(empty($user)) {
            redirect('welcome/login');
        }
    }

    /* Fonction lister: Page qui va lister mes films */
    public function lister(){

        // $data est mon transporteur de données (tableau )
        $data['alltags'] = $this->tag_model->allTags();

        // j'appelle ma vue lister et je lui transmets mon transporteur $data
        $this->load->view('Tag/lister', $data);
    }

    public function voir($id){

        $data['tag'] = $this->tag_model->getOneTagById($id);
        $data['moviesbytag'] = $this->movie_model->getMoviesByTag($id);

        $this->load->view('Tag/voir', $data);
    }


    public function creer(){

        // validation des champs
        $this->form_validation->set_rules('word','Nom','required|is_unique[tags.word]|min_length[3]');

        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Tag/creer');
        }

        else { // quand mon formulaire est valide

            $this->tag_model->inserer(); //m'enregistre un nouveau tag
            redirect('tag/lister');
        }
    }

    public function supprimer($id){

        $tag = $this->tag_model->getOneTagById($id);

        // Ecriture du message flash en session
        // Success est ma clé de message, et le message est ma valeur d'affichage
        $this->session->set_flashdata('success', 'Le tag ' . $tag->word . ' a bien été supprimé');


        $this->tag_model->supprimer($id);

        redirect('tag/lister');
    }

    public function editer($id){

        // validation des champs
        $this->form_validation->set_rules('word','Nom','required|is_unique[tags.word]|min_length[3]');

        //charger les tags pour les afficher dans les champs de la page d'édition
        $data['tag'] = $this->tag_model->getOneTagById($id);

        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Tag/editer', $data);
        }

        else { // quand mon formulaire est valide


            $this->tag_model->editer($id); //modifie le tag
            redirect('tag/lister', 'refresh');
        }
    }

}