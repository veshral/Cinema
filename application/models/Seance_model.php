<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 05/03/15
 * Time: 11:46
 */

class Seance_model extends CI_Model{

    /* Retourne la prochaine séance à Lyon */
    public function nextSession(){
        $query = $this->db->query("
        SELECT movies.title AS mtitre, movies.image AS mimage,
        DATE_FORMAT(sessions.date_session, '%d/%m/%Y') AS mdate,
        DATE_FORMAT(sessions.date_session, '%hh%i') AS mheure, movies.id AS mid,
        movies.synopsis AS msyno
        FROM sessions
        INNER JOIN cinema
        ON cinema.id = sessions.cinema_id
        INNER JOIN movies
        ON movies.id = sessions.movies_id
        WHERE cinema.ville LIKE '%Lyon%' AND sessions.date_session > NOW()
        ORDER BY sessions.date_session DESC
        LIMIT 1");

        return $query->row();
    }

    /* Retourne les 5 prochaines séances */
    public function nextSessions(){
        $query = $this->db->query("
        SELECT m.title AS film, c.title AS cinema, c.ville AS ville,
        DATE_FORMAT(s.date_session, '%d/%m/%Y') AS sdate,
        DATE_FORMAT(s.date_session, '%hh%i') AS sheure, m.id AS mid
        FROM sessions AS s
        INNER JOIN cinema AS c
        ON s.cinema_id = c.id
        INNER JOIN movies AS m
        ON m.id = s.movies_id
        ORDER BY s.date_session DESC
        LIMIT 5
        ");

        return $query->result();
    }

    public function allSeances(){
        $this->db->select('s.id AS sid, DATE_FORMAT(s.date_session, "%d/%m/%Y") AS date_session,
                            DATE_FORMAT(s.date_session, "%hh%i") AS heure_session,
                           m.title AS filmtitre, m.id AS filmid, c.id AS cineid,
                           c.title AS cinetitre');
        $this->db->from('sessions AS s');
        $this->db->join('movies AS m','s.movies_id = m.id','left');
        $this->db->join('cinema AS c','s.cinema_id = c.id','left');

        $query = $this->db->get();
        return $query->result();
    }

    function inserer() {


        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'movies_id' => $this->input->post('film'), // $this->input->post mde permet de récupérer mes valeurs en post
            'cinema_id' => $this->input->post('cinema'),
            'date_session' => $this->input->post('date_session') . ' ' . $this->input->post('heure_session')
        );

        //exit(print_r($data));

        $this->db->insert('sessions', $data);

    }

    function editer($id) {


        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'movies_id' => $this->input->post('film'), // $this->input->post mde permet de récupérer mes valeurs en post
            'cinema_id' => $this->input->post('cinema'),
            'date_session' => $this->input->post('date_session') . ' ' . $this->input->post('heure_session')
        );

        //exit(print_r($data));

        $this->db->where('id', $id);
        $this->db->update('sessions', $data);


    }

    // retourne les infos d'une séance à partir de son ID
    function getOneSeanceById($id) {

        $this->db->select('*, DATE_FORMAT(date_session, "%h:%i:%s") AS heure_session,
                              DATE_FORMAT(date_session, "%Y-%m-%d") AS adate_session');
        $this->db->from('sessions');
        $this->db->where('id',$id);

        $query = $this->db->get();
        return $query->row();

    }

    function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('sessions');

    }

    public function frontSeances(){
        $nomcats = array('Fantastique', 'Sciences-fictions', 'Policier', 'Action');

        $this->db->select('s.id AS sid, DATE_FORMAT(s.date_session, "%d/%m/%Y") AS date_session,
                            DATE_FORMAT(s.date_session, "%hh%i") AS heure_session,
                           m.title AS filmtitre, m.description AS description, m.id AS filmid, c.id AS cineid,
                           c.title AS cinetitre, m.image AS image, cat.title AS title');
        $this->db->from('sessions AS s');
        $this->db->join('movies AS m','s.movies_id = m.id','left');
        $this->db->join('categories AS cat','m.categories_id = cat.id','left');
        $this->db->join('cinema AS c','s.cinema_id = c.id','left');
        $this->db->where_in('cat.title',$nomcats);
        $this->db->limit(12);

        $query = $this->db->get();
        return $query->result();
    }



}
