<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

        // je récupère l'utilisateur en session
        $user = $this->session->userdata('user');

        //si utilisateur pas en session
        if(empty($user)) {
            redirect('welcome/login');
        }

        // Twitter tweets
        $tweets = $this->twitter->getTweets('symfomany', 7);

        //Twitter infos
        $tweetsinfos = $this->twitter->getInfos("allocine");

        //exit(var_dump($tweets));
        $data['tweets'] = $tweets;

        //movie_model
        $data['filmsaffiches'] = $this->movie_model->afficheMovies();
        $data['filmsattendus'] = $this->movie_model->attenduMovies();
        $data['filmauhasard'] = $this->movie_model->randMovie();
        $data['nbfilms'] = $this->movie_model->nbFilms();
        $data['budgettotal'] = $this->movie_model->budgetTotal();
        $data['nbfilmsfav'] = $this->movie_model->nbFilmsFav();
        $data['nbfilmsdif'] = $this->movie_model->nbFilmsDif();
        $data['filmsbymois'] = $this->movie_model->filmsByMois();

        //acteur_model
        $data['nbacteurs'] = $this->acteur_model->nbActeurs();
        $data['nbacteursparis'] = $this->acteur_model->nbActeursParis();
        $data['nbacteurslyon'] = $this->acteur_model->nbActeursLyon();
        $data['nbacteursmarseille'] = $this->acteur_model->nbActeursMarseille();
        $data['meilleursacteurs'] = $this->acteur_model->bestActors();
        $data['ageacteurs'] = $this->acteur_model->ageActors();

        //categorie_model
        $data['categories'] = $this->categorie_model->categories();
        $data['nbcategories'] = $this->categorie_model->nbCategories();
        $data['nbfilmbycat'] = $this->categorie_model->nbFilmByCat();

        //realisateur_model
        $data['meilleursrealisateurs'] = $this->realisateur_model->bestRealisateurs();
        $data['nbrealisateurs'] = $this->realisateur_model->nbRealisateurs();

        //tag_model
        $data['nuagetags'] = $this->tag_model->nuageTags();

        //session_model
        $data['prochaineseance'] = $this->seance_model->nextSession();
        $data['prochainesseances'] = $this->seance_model->nextSessions();

        //comment_model
        $data['comminac'] = $this->comment_model->lastComInac();
        $data['commval'] = $this->comment_model->lastComVal();
        $data['commac'] = $this->comment_model->lastComAc(); // 5 derniers commentaires actifs
        $data['nbcomac'] = $this->comment_model->nbComAc(); // nb de commentaires actifs
        $data['nbcomval'] = $this->comment_model->nbComVal();
        $data['nbcominac'] = $this->comment_model->nbComInac();
        $data['nbcomtotal'] = $this->comment_model->comTotal();

        //user model
        $data['users'] = $this->user_model->lastUser(); //je stocke

        //twitter infos
        $data['tweetsinfos'] = $tweetsinfos;

        $this->load->view('index', $data);
	}

	public function homepage()
	{
		// charge la vue index
		$this->load->view('index');
	}


    public function login(){


        //lien vers fb auth
        $data['fburl'] = $this->facebookauth->connectUrl();


        $this->form_validation->set_rules('login','login','required|min_length[3]');
        $this->form_validation->set_rules('password','password','required|min_length[6]');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login', $data);
        }

        else { // quand mon formulaire est valide

            //je récupère l'utilisateur grace à ma requete stockée dans le model user_model
            $user = $this->user_model->recupererUser();

            //si il y a bien un utilisateur en base de données
            if(!empty($user)) {

                //mise à jour de la date du last login
                $this->user_model->updateLastLogin($user->id);

                //écris en session mon utlisateur
                $this->session->set_userdata(array('user' => $user));

                // j'écris un message flash pour dire bonjour à mon utilisateur
                $this->session->set_flashdata('success','Bonjour ' .$user->username.', vous êtes bien connecté.');

                redirect('welcome/index');
            }else{
                $data['error'] = "Mauvais login / Mauvais mot de passe. Veuillez recommencer.";
                $this->load->view('login',$data);
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
        redirect('welcome/login');
    }

    public function suppressiontweet($id) {

        $this->twitter->delete($id);
        // $this->session->set_flashdata('success','Votre tweet a bien été supprimé.');
        // redirect('welcome/index');

        // En AJAX :
        echo 'Votre tweet a bien été supprimé.';
        exit();

    }

    public function ajoutertweet() {

        $tweet = $this->input->post('tweet');

        $this->twitter->create($tweet);

        $this->session->set_flashdata('success','Votre tweet a bien été ajouté.');
        redirect('welcome/index');
    }

    //retourne les tweets dans la vue partielle ajaxtweet
    public function ajaxtweets() {


        $tweets = $this->twitter->gettweets('refreshinfo69', 10);
        $data['tweets'] = $tweets;
        $this->load->view('partials/ajaxtweet', $data);
    }


    /**
     * Page de discussion
     * @param $id
     */
    public function discussion($id){
        $discussions = $this->user_model->getDiscussion($id); //je stocke
        $user = $this->user_model->getOneUserById($id); //je stocke

        $data['discussions'] = $discussions;
        $data['user'] = $user;

        $this->load->view('User/discussion', $data);
    }

    /**
     * Contenu des messages en temps réel
     * Page Timeline
     */
    public function getAjaxContentDiscussions($id){
        $discussions = $this->user_model->getDiscussion($id); //je stocke
        $user = $this->user_model->getOneUserById($id); //je stocke

        $data['discussions'] = $discussions;
        $data['user'] = $user;

        $this->load->view("partials/ajaxdiscussions", $data);
    }

    /**
     * Page Timeline
     */
    public function sendDiscussion($id){
        $messages = $this->user_model->sendDiscussion($id); //je stocke
        return true;
    }


}