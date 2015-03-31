<?php
/*
* Controleur User
*/
class User extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        //si il est connecté et super admin à la fois
        if(empty($user) || $user->is_admin != 2) {
            redirect('welcome/login');
        }
    }

    /* Fonction lister: Page qui va lister mes films */
    public function lister(){

        // $data est mon transporteur de données (tableau )
        $data['allusers'] = $this->user_model->allUsers();

        // j'appelle ma vue lister et je lui transmets mon transporteur $data
        $this->load->view('User/lister', $data);
    }



    public function creer(){


        //initialisation de la configuration de l'upload
        $config['upload_path'] = './uploads/users/';
        if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'],0777);
        }
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '4048';
        $config['max_height'] = '1960';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        //Validation des champs
        $this->form_validation->set_rules('username',"nom d'utilisateur",'required|min_length[3]|is_unique[user.username]');
        $this->form_validation->set_rules('email',"adresse email",'required|valid_email|is_unique[user.email]|callback_compareEmailUsername');
        $this->form_validation->set_rules('password1',"mot de passe",'required|callback_password_check|callback_comparePasswdEmail');
        $this->form_validation->set_rules('password2',"mot de passe",'required|callback_password_check|matches[password1]');
        $this->form_validation->set_rules('role',"rôle",'required');


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('User/creer');
        }

        else { // quand mon formulaire est valide

            //Action pour faire l'upload de mon fichier "image" et vérifier si
            // mon fichier est incorrect
            if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
            {

                // je récupère les messages d'erreur de mon fichier
                $data['error'] = $this->upload->display_errors();

                $this->load->view('User/creer', $data);

            } else { // mon upload s'est bien effectué et mon fichier est correct

                //récupérer le détail de mon fichier (nom, extension...)
                $data = $this->upload->data();

                // j'envoi à mon modèle le détail de ce fichier
                $this->user_model->inserer($data); //m'enregistre un nouvel utilisateur

                redirect('user/lister');


            }
        }
    }

    //Fonction callback pour vérifier le format du mot de passe
    public function password_check($str) {

        if (!preg_match("#(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-._]).{6,}#", $str) ) {
            $this->form_validation->set_message('password_check', 'Mot de passe incorrect. Il doit comporter : 6 caractères minimum, comprenant majuscule, minuscule, chiffre, un caractère de type ".-_"');
                return FALSE;
            } else {
                return TRUE;
        }
    }

    //Fonction callback pour vérifier que les noms d'utilisateur et adresse email sont bien différents
    public function compareEmailUsername($str) {

        $username = $this->input->post('username');
        if ($str == $username) {
            $this->form_validation->set_message('compareEmailUsername', "Nom d'utilisateur et adresse e-mail ne peuvent pas être identiques.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Fonction callback pour vérifier que l'adresse email et le mot de passe sont bien différents
    public function comparePasswdEmail($str) {

        $email = $this->input->post('email');
        if ($str == $email) {
            $this->form_validation->set_message('comparePasswdEmail', "Le mot de passe ne peut pas être identique à l'adresse e-mail.");
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //Fonction callback pour vérifier si l'adresse email n'est pas existante en BDD en cas de modification user
    public function compareEmailDb($email) {

        $usr = $this->input->post('username');
        $nb = $this->user_model->compareEmailDb($email, $usr);
        if ($nb > 0) {
            $this->form_validation->set_message('compareEmailDb', "L'adresse e-mail est existante.");
            return FALSE;
        } else {
            return TRUE;
        }

    }

    public function supprimer($id){

        $user = $this->user_model->getOneUserById($id);
        // Ecriture du message flash en session
        // Success est ma clé de message, et le message est ma valeur d'affichage
        $this->session->set_flashdata('success', "L'utilisateur ' . $user->username . ' a bien été supprimé");



        $this->user_model->supprimer($id);
        redirect('user/lister');
    }

    public function editer($id){

        //initialisation de la configuration de l'upload
        $config['upload_path'] = './uploads/users/';
        if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'],0777);
        }
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '4048';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);



        //Validation des champs
        $this->form_validation->set_rules('email',"adresse email",'required|valid_email|callback_compareEmailUsername|callback_compareEmailDb');
        $this->form_validation->set_rules('password1',"mot de passe",'required|callback_password_check|callback_comparePasswdEmail');
        $this->form_validation->set_rules('password2',"mot de passe",'required|callback_password_check|matches[password1]');
        $this->form_validation->set_rules('role',"rôle",'required');


        //charger le user
        $data['user'] = $this->user_model->getOneUserById($id);


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('User/editer', $data);
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
                $this->load->view('User/editer', $data);

            } else { // mon upload s'est bien effectué et mon fichier est correct

                $data = $this->upload->data();

                // j'envoi à mon modèle le détail de ce fichier
                $this->user_model->editer($id, $data); //modifie mon user

                redirect('user/lister', 'refresh');

            }


        }


    }


    public function voir($id){

        $data['user'] = $this->user_model->getOneUserById($id);

        $this->load->view('User/voir', $data);
    }



}