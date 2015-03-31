<?php

/*
* Librairie Panier
*/
class Panier{


    /*
    *   Attribut CodeIgniter
    */
    protected $ci;


    /**
     * Constructeur
     */
    public function __construct(){
        
        // noyau de codeigniter
        $this->ci =& get_instance();
    }


    /**
     * Retourne le contenu de mon panier
     */
    public function getPanier(){
        //récupère le panier en session
        $panier  = $this->ci->session->userdata('panier');
        return $panier;
    }



    /**
     * Recupere la liste des ids de mes films en panier
     */
    public function getListIdsPanier(){
        //récupère le panier en session
        $panier  = $this->ci->session->userdata('panier');

        $tabids =array();

        if(!empty($panier)){
            foreach($panier as $movie){

                //je stocke dans un tableau les ids des films en panier
                $tabids[] = $movie['id'];
            }
        }

        return $tabids;
    }




    /**
     * Insérer un film dans mon panier
     */
    public function insertPanier($id){
        //je recupère mon film à partir de son id
        $movie = $this->ci->movie_model->getOneMovieById($id); // je lui transmet au model l'argument $id

        //Je recupere mon panier existant
        $tab_movies = $this->getPanier(); //recupêre le panier
        $tabids = $this->getListIdsPanier(); //je recupere la liste


        // Si l'id de mon film n'est pas compris dans le tableaux des ids de mes film en panier
        if(! in_array($id, $tabids)){
            $tab_movies[$id] = array(
                'id' => $movie->id,
                'price' => $movie->price,
                'title' => $movie->title,
                'image' => $movie->image,
                'quantity' => 1
            );
        }
        //mon film est deja en panier
        else{
            $tab_movies[$id]['quantity'] = $tab_movies[$id]['quantity'] + 1;
        }

        //je modifie mon panier en session
        $this->ci->session->set_userdata('panier',$tab_movies);
    }


    /**
     */
    public function countItem(){
        $panier = $this->getPanier(); //recuêre le panier

        //je crée un compteur de film
        $nb = 0;

        if(!empty($panier)){
            //je parcours tous mes films en panier
            foreach($panier as $movie){
                //j'augmente le nb par la quantité du film dans ma boucle
                $nb = $nb + $movie['quantity'];
            }
        }

        return $nb;

    }

    /**
     * Me retourne le prix total de mon panier
     */
    public function getTotal(){
        //je récupere mon panier
        $panier  = $this->getPanier();
        $sum = 0;


        if(!empty($panier)) {
            foreach ($panier as $movie) {
                // prix * quantité de chaque film
                $sum = $sum + ($movie['price'] * $movie['quantity']);
            }
        }

        //je retourne la somme total du panier formatée
        return number_format($sum, 2, ',', ' ');
    }

    /**
    * Prix TTC avec tax 20%
     */
    public function getTotalTTC(){
        $total  = $this->getTotal();
        return $total  * 1.20;

    }


    /*
    * Je vide mon panier en session
    */
    public function viderpanier(){

        $this->ci->session->set_userdata('panier', array());
    }


    /**
     * supprimer
     */
    public function remove($id){
        $tab_movies = $this->getPanier(); //recupêre le panier
        unset($tab_movies[$id]); //je supprimer le film en panier par son id en clef
        $this->ci->session->set_userdata('panier',$tab_movies); //je met a jour mon panier

    }

    /**
    * Augmenter la quantité d'un film en panier
     */
    public function augmenter($id){
        $tab_movies = $this->getPanier(); //recupêre le panier
        $tab_movies[$id]['quantity'] = $tab_movies[$id]['quantity'] + 1;
        $this->ci->session->set_userdata('panier',$tab_movies);

    }


    /**
     * Augmenter la quantité d'un film en panier
     */
    public function diminuer($id){
        $tab_movies = $this->getPanier(); //recupêre le panier
        $tab_movies[$id]['quantity'] = $tab_movies[$id]['quantity'] - 1;
        $this->ci->session->set_userdata('panier',$tab_movies);

    }



    /**
     */
    public function deletePanier($id){
        $tab_movies = $this->getPanier(); //recupêre le panier
        $tabids = $this->getListIdsPanier(); //je recupere la liste

        if(in_array($id, $tabids)){
            unset($tab_movies[$id]);
        }

        $this->ci->session->set_userdata('panier',$tab_movies);

    }

}