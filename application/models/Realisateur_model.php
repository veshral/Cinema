<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 05/03/15
 * Time: 10:21
 */

class Realisateur_model extends CI_Model{

    /* Retourne les 4 meilleurs réalisateurs
    (en fonction du nombre de films réalisés */
    public function bestRealisateurs(){
        $query = $this->db->query('
        SELECT d.firstname, d.lastname, d.dob, d.biography, d.image, COUNT(dm.movies_id), d.id AS id,
        TIMESTAMPDIFF(YEAR,d.dob,NOW()) AS age
        FROM directors AS d
        INNER JOIN directors_movies AS dm
        ON d.id = dm.directors_id
        GROUP BY dm.directors_id
        ORDER BY COUNT(dm.movies_id) DESC
        LIMIT 4');

        return $query->result();
    }

    /* Retourne la liste des réalisateurs */
    public function allRealisateurs(){
        $query = $this->db->query('
        SELECT firstname, lastname,
        TIMESTAMPDIFF(YEAR,dob,NOW()) AS age, biography, id
        FROM directors');

        return $query->result();
    }


    /* Retourne le nombre de réalisateurs */
    public function nbRealisateurs(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM directors');

        return $query->row();
    }

    /* Retourne un réalisateur à partir de son id*/
    public function getOneDirectorById($id){
        $query = $this->db->query('
        SELECT *, TIMESTAMPDIFF(YEAR,dob,NOW()) AS age
        FROM directors
        WHERE id = ' . $id
        );

        return $query->row();
    }


    /* Retourne les réalisateurs qui ont réalisé un film donné */
    public function getDirectorsFromMovie($id){
        $query = $this->db->query('
        SELECT directors.firstname AS firstname, directors.lastname AS lastname,
        TIMESTAMPDIFF(YEAR,directors.dob,NOW()) AS age, directors.biography AS biography,
        directors.id AS id, directors.image AS image
        FROM directors
        INNER JOIN directors_movies
        ON directors_movies.directors_id = directors.id
        INNER JOIN movies
        ON movies.id = directors_movies.movies_id
        WHERE movies.id = ' . $id
        );

        return $query->result();

    }


    function inserer($data) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'firstname' => $this->input->post('firstname'), // $this->input->post mde permet de récupérer mes valeurs en post
            'lastname' => $this->input->post('lastname'),
            'dob' => $this->input->post('dob'),
            'biography' => $this->input->post('biography'),
            'image' => base_url().'uploads/directors/'.$data['file_name'],
            'date_created' => date('Y-m-d H:i:s')
        );

        $this->db->insert('directors',$data);

    }

    function editer($id, $data) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'firstname' => $this->input->post('firstname'), // $this->input->post mde permet de récupérer mes valeurs en post
            'lastname' => $this->input->post('lastname'),
            'dob' => $this->input->post('dob'),
            'biography' => $this->input->post('biography'),
            'image' => base_url().'uploads/directors/'.$data['file_name'],
        );

        $this->db->where('id', $id);
        $this->db->update('directors', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('directors');

    }

    /* Retourne les 3 meilleurs réalisateurs
        (en fonction du nombre de films réalisés */
    public function bestRealisateursFront(){

        $this->db->select('d.firstname AS prenom, d.lastname AS nom, d.dob AS dob,
         d.biography AS biography, d.image AS image, COUNT(dm.movies_id) AS nb, d.id AS id,
        TIMESTAMPDIFF(YEAR,d.dob,NOW()) AS age');
        $this->db->from('directors AS d');
        $this->db->join('directors_movies AS dm', 'd.id = dm.directors_id');
        $this->db->group_by('dm.directors_id');
        $this->db->order_by('COUNT(dm.movies_id)', 'DESC');
        $this->db->limit(3);

        $query= $this->db->get();
        return $query->result();
    }



}
