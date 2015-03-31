<?php
/**
 * Created by PhpStorm.
 * User: wal04
 * Date: 06/03/15
 * Time: 09:36
 */


class Comment_model extends CI_Model{

    /* Affiche le nombre total de commentaires */
    public function comTotal(){
        $query = $this->db->query("
        SELECT COUNT(id) AS nb
        FROM comments");

        return $query->row();
    }

    /* Affiche le nb de commentaires actifs (state = 2) */
    public function nbComAc(){
        $query = $this->db->query("
        SELECT COUNT(id) AS nb
        FROM comments
        WHERE state = 2
        ");

        return $query->row();
    }

    /* Affiche le nb de commentaires inactifs (state = 0) */
    public function nbComInac(){
        $query = $this->db->query("
        SELECT COUNT(id) AS nb
        FROM comments
        WHERE state = 0
        ");

        return $query->row();
    }

    /* Affiche le nb de commentaires en cours de validation (state = 1) */
    public function nbComVal(){
        $query = $this->db->query("
        SELECT COUNT(id) AS nb
        FROM comments
        WHERE state = 1
        ");

        return $query->row();
    }


    /* Affiche les 5 derniers commentaires inactifs (state = 0) */
    public function lastComInac(){
        $query = $this->db->query("
        SELECT u.username AS username, c.content AS ccontent, c.state AS cstate,
        m.title AS film, DATE_FORMAT(c.date_created, '%d/%m/%Y') AS cdate,
        DATE_FORMAT(c.date_created, '%hh%i') AS cheure, c.note AS cnote, u.avatar AS uavatar,
        m.id AS filmid
        FROM comments AS c
        INNER JOIN user AS u
        ON c.user_id = u.id
        INNER JOIN movies AS m
        ON m.id = c.movies_id
        WHERE c.state = 0
        ORDER BY c.date_created DESC
        LIMIT 5");

        return $query->result();
    }

    /* Affiche les 5 derniers commentaires en cours de validation (state = 1) */
    public function lastComVal(){
        $query = $this->db->query("
        SELECT u.username AS username, c.content AS ccontent, c.state AS cstate,
        m.title AS film, DATE_FORMAT(c.date_created, '%d/%m/%Y') AS cdate,
        DATE_FORMAT(c.date_created, '%hh%i') AS cheure, c.note AS cnote, u.avatar AS uavatar,
        m.id AS filmid
        FROM comments AS c
        INNER JOIN user AS u
        ON c.user_id = u.id
        INNER JOIN movies AS m
        ON m.id = c.movies_id
        WHERE c.state = 1
        ORDER BY c.date_created DESC
        LIMIT 5");

        return $query->result();
    }

    /* Affiche les 5 derniers commentaires en actifs (state = 2) */
    public function lastComAc(){
        $query = $this->db->query("
        SELECT u.username AS username, c.content AS ccontent, c.state AS cstate,
        m.title AS film, DATE_FORMAT(c.date_created, '%d/%m/%Y') AS cdate,
        DATE_FORMAT(c.date_created, '%hh%i') AS cheure, c.note AS cnote, u.avatar AS uavatar,
        m.id AS filmid
        FROM comments AS c
        INNER JOIN user AS u
        ON c.user_id = u.id
        INNER JOIN movies AS m
        ON m.id = c.movies_id
        WHERE c.state = 2
        ORDER BY c.date_created DESC
        LIMIT 5");

        return $query->result();
    }

    /* Affiche les commentaires pour 1 film défini depuis son ID */
    public function getComsFromMovie($id){
        $query = $this->db->query("
        SELECT user.avatar AS avatar, user.username AS username,
        comments.content AS content, comments.note AS note,
        comments.date_created AS date_created, comments.state AS state, comments.id AS id
        FROM comments
        INNER JOIN user
        ON user.id = comments.user_id
        WHERE comments.movies_id = " . $id);

        return $query->result();
    }

    /* Affiche les commentaires avec toutes les infos */
    public function allComments(){

        $this->db->select('m.title AS mtitle, m.id AS mid, u.username AS username,
                           c.note AS note, c.content AS content, c.state AS state,
                           c.date_created AS date, c.state AS state, c.id AS cid');
        $this->db->from('comments AS c');
        $this->db->join('user AS u','u.id = c.user_id','left');
        $this->db->join('movies AS m','m.id = c.movies_id','left');

        $query=$this->db->get();
        return $query->result();
    }

    public function supprimer($id){

        $this->db->where('id',$id);
        $this->db->delete('comments');
    }

    public function activer($id){

        $data = array(
            'state' => 2,
        );

        $this->db->where('id',$id);
        $this->db->update('comments',$data);
    }

    public function desactiver($id){

        $data = array(
            'state' => 0,
        );

        $this->db->where('id',$id);
        $this->db->update('comments',$data);
    }

    public function validation($id){

        $data = array(
            'state' => 1,
        );

        $this->db->where('id',$id);
        $this->db->update('comments',$data);
    }


    /* Affiche les 4 commentaires actifs les mieux notés */
    public function combestnotes(){
        $query = $this->db->query("
        SELECT u.username AS username, c.content AS ccontent, c.state AS cstate,
        m.title AS film, DATE_FORMAT(c.date_created, '%d/%m/%Y') AS cdate,
        DATE_FORMAT(c.date_created, '%hh%i') AS cheure, c.note AS cnote, u.avatar AS uavatar,
        m.id AS filmid
        FROM comments AS c
        INNER JOIN user AS u
        ON c.user_id = u.id
        INNER JOIN movies AS m
        ON m.id = c.movies_id
        WHERE c.state = 2
        ORDER BY cnote DESC
        LIMIT 4");

        return $query->result();
    }


}

?>
