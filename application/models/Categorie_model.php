<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 05/03/15
 * Time: 10:17
 */

class Categorie_model extends CI_Model{

    /* Retourne les catégories avec le nombre de films par catégorie */
    public function categories(){
        $query = $this->db->query('
        SELECT categories.title AS cat, COUNT(movies.id) AS nbmov, categories.id AS id
        FROM categories
        INNER JOIN movies
        ON movies.categories_id = categories.id
        GROUP BY categories.title
        ');

        return $query->result();
    }

    /* Retourne les catégories avec le nombre de films par catégorie,
    y compris les catégories sans films (LEFT JOIN) */
    public function allCategories(){
        $query = $this->db->query('
        SELECT categories.title AS cat, COUNT(movies.id) AS nbmov,
         categories.description AS "desc", categories.id AS id
        FROM categories
        LEFT JOIN movies
        ON movies.categories_id = categories.id
        GROUP BY categories.title');

        return $query->result();
    }

    /* Retourne le nombre de catégories */
    public function nbCategories(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM categories');

        return $query->row();
    }

    /* Retourne le nombre de films/catégorie */
    public function nbFilmByCat(){
        $query = $this->db->query('
        SELECT categories.title AS titre, COUNT( movies.id ) AS nb
        FROM categories
        INNER JOIN movies
        ON movies.categories_id = categories.id
        GROUP BY categories.title');

        return $query->result();
    }

    /* Retourne les infos d'une categorie depuis le bouton voir */
    public function getOneCatById($id){
        $query = $this->db->query('
        SELECT *
        FROM categories
        WHERE id = ' . $id
        );

        return $query->row();
    }

    /* Retourne les infos des films pour une catégorie */
    public function getMoviesForCat($id){
        $query = $this->db->query('
        SELECT *
        FROM movies
        WHERE categories_id =  ' . $id
        );

        return $query->result();
    }


    function inserer($image) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post mde permet de récupérer mes valeurs en post
            'description' => $this->input->post('description'),
            'date_created' => date('Y-m-d H:i:s'),
            'image' => base_url().'uploads/categories/'.$image['file_name']
        );


        if(empty($image['file_name'])){
            unset($data['image']);
        }

        $this->db->insert('categories', $data);

    }

    function editer($id, $image) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post mde permet de récupérer mes valeurs en post
            'description' => $this->input->post('description'),
            'image' => base_url().'uploads/categories/'.$image['file_name']
        );

        if(empty($image['file_name'])){ //si mon fichier est vide
            unset($data['image']); // je retire l'image de mon transporteur $data
        }

        $this->db->where('id', $id);
        $this->db->update('categories', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('categories');
        /*
        $report = array();
        $report['error'] = $this->db->_error_number();
        $report['message'] = $this->db->_error_message();
        return $report;
        */

    }

    //retourne les 4 catégories ayant le plus de films
    public function categoriesFront(){

        $this->db->select('categories.title AS cat, COUNT(movies.id) AS nbmov, categories.id AS id');
        $this->db->from('categories');
        $this->db->join('movies', 'movies.categories_id = categories.id');
        $this->db->group_by('categories.title');
        $this->db->order_by("COUNT(movies.id)", "desc");
        $this->db->limit(4);

        $query = $this->db->get();
        return $query->result();
    }



}
