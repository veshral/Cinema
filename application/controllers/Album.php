<?php
/*
* Controleur Album
*/
class Album extends CI_Controller {


    public function __construct() {
        parent::__construct();

        $user = $this->session->userdata('user');

        if(empty($user)) {
            redirect('welcome/login');
        }
    }

    public function lister(){

        $user = $this->session->userdata('user');

        $data['useralbum'] = $this->album_model->userAlbum($user->id);
        $data['user'] = $this->user_model->getOneUserById($user->id);

        $this->load->view('Album/lister', $data);
    }

    public function supprimer($id){

        // Ecriture du message flash en session
        // Success est ma clé de message, et le message est ma valeur d'affichage
        $this->session->set_flashdata('success', 'Image supprimée');

        //on sélectionne les infos pour supprimmer le fichier sur le serveur
        $album = $this->album_model->getOneAlbumById($id);

        //Suppression du fichier sur le serveur
        unlink('./uploads/album/'.$album->user_id.'/'.$album->file_name);

        //suppression dans la BDD
        $this->album_model->supprimer($id);

        redirect('album/lister');
    }


    public function creer(){

        $user = $this->session->userdata('user');

        //initialisation de la configuration de l'upload
        $config['upload_path'] = './uploads/album/'.$user->id;
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
        $this->form_validation->set_rules('title','Titre','required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('description','Description','min_length[5]');


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Album/creer');
        }

        else { // quand mon formulaire est valide

            //Action pour faire l'upload de mon fichier "image" et vérifier si
            // mon fichier est incorrect
            if ( !$this->upload->do_upload('image') ) // erreur sur l'upload
            {
                // je récupère les messages d'erreur de mon fichier
                $data['error'] = $this->upload->display_errors();
                $this->load->view('Album/creer', $data);

            } else { // mon upload s'est bien effectué et mon fichier est correct

                $data = $this->upload->data();

                // j'envoi à mon modèle le détail de ce fichier
                $this->album_model->inserer($data); //m'enregistre une nouvelle image

                redirect('album/lister');

            }
        }
    }

    public function editer($id){

        $user = $this->session->userdata('user');

        //initialisation de la configuration de l'upload
        $config['upload_path'] = './uploads/album/'.$user->id;
        if(!is_dir($config['upload_path']))
        {
            mkdir($config['upload_path'],0777);
        }
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '4048';
        $config['max_height'] = '1960';

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $data['album'] = $this->album_model->getOneAlbumById($id);

        // validation des champs
        $this->form_validation->set_rules('title','Titre','required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('description','Description','min_length[5]');


        //Si mon formulaire contient des erreurs
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('Album/editer', $data);
        }

        else { // quand mon formulaire est valide

            $data = $this->upload->data();

            //Action pour faire l'upload de mon fichier "image" et vérifier si
            // mon fichier est incorrect
            if ( !$this->upload->do_upload('image') && !empty($data['file_name']) ) // erreur sur l'upload
            {
                // je récupère les messages d'erreur de mon fichier
                $data['error'] = $this->upload->display_errors();
                $this->load->view('Album/editer', $data);

            } else { // mon upload s'est bien effectué et mon fichier est correct

                $data = $this->upload->data();

                // j'envoi à mon modèle le détail de ce fichier
                $this->album_model->editer($id, $data);

                redirect('album/lister');

            }
        }
    }



}