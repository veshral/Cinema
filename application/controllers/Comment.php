<?php
/*
* Controleur Comment
*/
class Comment extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        if(empty($user)) {
            redirect('welcome/login');
        }
    }

    /* Fonction lister: Page qui va lister les commentaires */
    public function lister(){

        $data['comments'] = $this->comment_model->allComments();

        $this->load->view('Comment/lister', $data);
    }

    public function activer($id){

        $this->comment_model->activer($id);

        $this->session->set_flashdata('success', 'Commentaire activé');
        redirect('comment/lister');
    }

    public function desactiver($id){

        $this->comment_model->desactiver($id);

        $this->session->set_flashdata('success', 'Commentaire désactivé');
        redirect('comment/lister');
    }

    public function validation($id){

        $this->comment_model->validation($id);

        $this->session->set_flashdata('success', 'Commentaire validé');
        redirect('comment/lister');
    }

    public function supprimer($id){

        $this->comment_model->supprimer($id);

        // flash data ne fonctionne plus avec AJAX
        //$this->session->set_flashdata('success', 'Commentaire supprimé');

        //redirect('comment/lister');
        // return TRUE pour réafficher la page après la suppression du commentaire en AJAX
        // return true;

        // utiliser echo et exit pour afficher l'info dans le data d'AJAX
        echo 'Commentaire supprimé';
        exit();

    }


}