<?php

class Tag_model extends CI_Model{

    /* Retourne tous les tags ajoutés aux films */
    public function nuageTags(){
        $query = $this->db->query('
        SELECT tags.word AS tagname, COUNT(tags_movies.movies_id) AS nbtag, tags.id AS tid
        FROM tags
        INNER JOIN tags_movies
        ON tags.id = tags_movies.tags_id
        GROUP BY tags_movies.tags_id
        ORDER BY RAND()');

        return $query->result();
    }

    /* Retourne tous les tags, avec leur nombre de film */
    public function allTags(){
        $query = $this->db->query('
        SELECT tags.word AS tagname, tags.id AS tid, COUNT(tags_movies.tags_id) AS nbfilm
        FROM tags
        LEFT JOIN tags_movies
        ON tags.id = tags_movies.tags_id
        GROUP BY tid');

        return $query->result();
    }

    /* Retourne les infos d'un tag en fonction de son id */
    public function getOneTagById($id){
        $query = $this->db->query('
            SELECT *
            FROM tags
            WHERE id = ' . $id
        );

        return $query->row();
    }

    function inserer() {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'word' => $this->input->post('word'), // $this->input->post mde permet de récupérer mes valeurs en post
        );

        $this->db->insert('tags', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('tags');
    }

    function editer($id) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'word' => $this->input->post('word') // $this->input->post me permet de récupérer mes valeurs en post
        );

        $this->db->where('id', $id);
        $this->db->update('tags', $data);

    }




}