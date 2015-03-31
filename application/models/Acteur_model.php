<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 05/03/15
 * Time: 10:13
 */

class Acteur_model extends CI_Model{

       /* Retourne la liste des actors */
        public function allActors(){
        $query = $this->db->query('
        SELECT firstname, lastname, city,
        TIMESTAMPDIFF(YEAR,dob,NOW()) AS age, biography, id
        FROM actors');

        return $query->result();
    }

    /* retourne les 4 meilleurs acteurs */

    public function bestActors(){
        $query = $this->db->query('
        SELECT a.firstname AS firstname, a.lastname AS lastname, a.dob, a.city AS city, a.biography AS biography, a.image AS image, COUNT(am.movies_id), a.id AS id,
        TIMESTAMPDIFF(YEAR,a.dob,NOW()) AS age
        FROM actors AS a
        INNER JOIN actors_movies AS am
        ON am.actors_id = a.id
        GROUP BY am.actors_id
        ORDER BY COUNT(am.movies_id) DESC
        LIMIT 4');

        return $query->result();
    }

    /* Retourne le nombre d'acteurs */
    public function nbActeurs(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM actors');

        return $query->row();
    }

    /* Retourne la moyenne d'âge des acteurs */
    public function ageActors(){
        $query = $this->db->query('
        SELECT AVG(TIMESTAMPDIFF(YEAR,dob,NOW())) AS nb
        FROM actors');

        return $query->row();
    }

    /* Retourne le nombre d'acteurs à Paris */
    public function nbActeursParis(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM actors
        WHERE city LIKE "%Paris%"
        ');

        return $query->row();
    }

    /* Retourne le nombre d'acteurs à Lyon */
    public function nbActeursLyon(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM actors
        WHERE city LIKE "%Lyon%"
        ');

        return $query->row();
    }

    /* Retourne le nombre d'acteurs à Marseille */
    public function nbActeursMarseille(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM actors
        WHERE city LIKE "%Marseille%"
        ');

        return $query->row();
    }

    /* Retourne un acteur à partir de son id */
    public function getOneActorById($id){
        $query = $this->db->query('
        SELECT *, TIMESTAMPDIFF(YEAR,dob,NOW()) AS age
        FROM actors
        WHERE id = ' . $id
        );

        return $query->row();
    }


    /* Retourne les acteurs qui ont joué dans un film donné */
    public function getActorsFromMovie($id){
        $query = $this->db->query('
        SELECT actors.firstname AS firstname, actors.lastname AS lastname,
        actors.image AS image, actors.city AS city, TIMESTAMPDIFF(YEAR,actors.dob,NOW()) AS age,
        actors.biography AS biography, actors.id AS id
        FROM actors
        INNER JOIN actors_movies
        ON actors.id = actors_movies.actors_id
        INNER JOIN movies
        ON movies.id = actors_movies.movies_id
        WHERE movies.id = ' . $id
        );

        return $query->result();

    }

    public function inserer($image) {

            // je prépare un tableau de données avec les clés qui sont mes champs de tables
            $data = array(
                'firstname' => $this->input->post('firstname'), // $this->input->post mde permet de récupérer mes valeurs en post
                'lastname' => $this->input->post('lastname'),
                'dob' => $this->input->post('dob'),
                'nationality' => $this->input->post('nationality'),
                'roles' => $this->input->post('roles'),
                'biography' => $this->input->post('biography'),
                'image' => base_url().'uploads/actors/'.$image['file_name'],
                'date_created' => date('Y-m-d H:i:s')
            );

            $this->db->insert('actors',$data);

    }

    public function editer($id, $data) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'firstname' => $this->input->post('firstname'), // $this->input->post mde permet de récupérer mes valeurs en post
            'lastname' => $this->input->post('lastname'),
            'dob' => $this->input->post('dob'),
            'nationality' => $this->input->post('nationality'),
            'roles' => $this->input->post('roles'),
            'biography' => $this->input->post('biography'),
            'image' => base_url().'uploads/actors/'.$data['file_name']

        );

        $this->db->where('id', $id);
        $this->db->update('actors', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('actors');

    }


}
