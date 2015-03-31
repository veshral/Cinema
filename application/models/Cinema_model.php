<?php

class Cinema_model extends CI_Model{

    /* Retourne la liste des cinemas */
    public function allCinemas(){
        $query = $this->db->get('cinema');
        return $query->result();
    }

    /* Retourne la liste des cinemas avec le nb de film par cinema */
    public function allCinemasNbMov(){

        $this->db->select('c.id AS id, c.title AS title, c.ville AS ville,
        c.position AS "position", c.date_created AS date_created,
        COUNT(cm.movies_id) AS nbfilms');
        $this->db->from('cinema AS c');
        $this->db->join('cinema_movies AS cm','cm.cinemas_id = c.id','left');
        $this->db->group_by('c.id');

        $query = $this->db->get();
        return $query->result();
    }


    /* Retourne les infos d'un cine depuis le bouton voir */
    public function getOneCineById($id){
        $this->db->select('*');
        $this->db->from('cinema');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function inserer() {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post mde permet de récupérer mes valeurs en post
            'ville' => $this->input->post('ville'),
            'position' => $this->input->post('position'),
            'date_created' => date('Y-m-d H:i:s')
        );

        $this->db->insert('cinema', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('cinema');

    }

    function editer($id) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post me permet de récupérer mes valeurs en post
            'ville' => $this->input->post('ville'),
            'position' => $this->input->post('position')
        );

        $this->db->where('id', $id);
        $this->db->update('cinema', $data);

    }

    public function getCineBySeance($id){
        $this->db->select('c.title AS title, c.ville AS ville, c.id AS id');
        $this->db->from('cinema AS c');
        $this->db->join('sessions AS s','s.cinema_id=c.id');
        $this->db->where('s.id', $id);

        $query = $this->db->get();
        return $query->row();
    }


}