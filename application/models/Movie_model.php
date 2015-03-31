<?php

/*
* Ma classe model dans lequels j'aurai mes requetes de Movie
*/
class Movie_model extends CI_Model{

    /* Fonction qui me retourne tout mes films */

    public function allMovies(){
        $query = $this->db->get('movies');

        return $query->result();
    }

    /* Fonction qui retourne tout les films,
    avec les catégories (pour la page vue des movies */
    public function allMoviesCat(){
        $query = $this->db->query('
        SELECT movies.title AS title, movies.annee AS annee, categories.title AS cat,
        movies.synopsis AS syno, movies.id AS id, movies.note_presse AS stars,
        movies.visible AS visible, movies.cover AS cover,
        DATE_FORMAT(movies.date_created, "%d/%m/%Y") AS datedecreation, movies.price AS prix,
        movies.date_created AS date
        FROM movies
        LEFT JOIN categories
        ON movies.categories_id = categories.id
        ');
        return $query->result();
    }



    // Retourne les 5 films à l'affiche

    public function afficheMovies(){
        $query = $this->db->query('
        SELECT *
	    FROM movies
	    WHERE visible=1 AND cover=1 AND date_release <= NOW()
	    LIMIT 5');

        return $query->result();
    }

    // retourne les 5 films les plus attendus
    public function attenduMovies(){
        $query = $this->db->query('
          SELECT title, synopsis, image, annee, budget, note_presse, id
	      FROM movies
	      ORDER BY note_presse
	      LIMIT 5');

        return $query->result();
    }

    // retourne un film au hasard
    public function randMovie(){
        $query = $this->db->query('
            SELECT id, title, synopsis, image, date_release
            FROM movies
            ORDER BY RAND()
            LIMIT 1');

        return $query->row();
    }

    /* Retourne le nombre de films */
    public function nbFilms(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb
        FROM movies');

        return $query->row();
    }

    /* Retourne le nombre de films mis en favoris */
    public function nbFilmsFav(){
        $query = $this->db->query('
        SELECT COUNT(groupe.movfav) AS nb
        FROM
        (SELECT uf.movies_id AS movfav
        FROM movies
        INNER JOIN user_favoris AS uf
        ON uf.movies_id = movies.id
        GROUP BY uf.movies_id
        ) AS groupe
        ');

        return $query->row();
    }

    /* Retourne le nombre de films diffusés */
    public function nbFilmsDif(){
        $query = $this->db->query('
        SELECT COUNT(groupe.movdif) AS nb
        FROM (
        SELECT cm.movies_id AS movdif
        FROM movies AS m
        INNER JOIN cinema_movies AS cm
        ON cm.movies_id = m.id
        GROUP BY cm.movies_id) AS groupe
        ');

        return $query->row();
    }

    /* Retourne le budget total des films */
    public function budgetTotal(){
        $query = $this->db->query('
        SELECT SUM(budget) AS nb
        FROM movies');

        return $query->row();
    }

    /* Retourne la répartition des films/mois */
    public function filmsByMois(){
        $query = $this->db->query('
        SELECT COUNT(id) AS nb, DATE_FORMAT(date_release, "%m/%Y") AS mois
        FROM movies
        WHERE DATE_FORMAT(date_release, "%m/%Y") IS NOT NULL
        AND DATE_FORMAT(date_release, "%m/%Y") <> "00/0000"
        GROUP BY DATE_FORMAT(date_release, "%m/%Y")
        ORDER BY date_release ASC
        ');

        return $query->result();
    }

    /* Retourne les infos d'un film depuis le bouton voir */
    public function getOneMovieById($id){
        $query = $this->db->query('
        SELECT *
        FROM movies
        WHERE id = ' . $id
        );

        return $query->row();
    }

    /* Activation de la visibilité d'un film */
    public function visibilityOn($id){

        $data = array(
            'visible' => 1,
        );

        $this->db->where('id', $id);
        $this->db->update('movies', $data);
    }

    /* Désactivation de la visibilité d'un film */
    public function visibilityOff($id){

        $data = array(
            'visible' => 0,
        );

        $this->db->where('id', $id);
        $this->db->update('movies', $data);
    }

    /* Activation de la visibilité d'un film */
    public function coverOn($id){

        $data = array(
            'cover' => 1,
        );

        $this->db->where('id', $id);
        $this->db->update('movies', $data);
    }

    /* Désactivation de la visibilité d'un film */
    public function coverOff($id){

        $data = array(
            'cover' => 0,
        );

        $this->db->where('id', $id);
        $this->db->update('movies', $data);
    }

    /* Retourne les films joués par un acteur */
    public function getMoviesFromActor($id){
        $query = $this->db->query('
        SELECT movies.title AS title, movies.image AS image, movies.id AS id
        FROM movies
        INNER JOIN actors_movies
        ON movies.id = actors_movies.movies_id
        INNER JOIN actors
        ON actors.id = actors_movies.actors_id
        WHERE actors.id = ' . $id
        );

        return $query->result();
    }

    /* Retourne les films réalisés par un réalisateur */
    public function getMoviesFromDirector($id){
        $query = $this->db->query('
        SELECT movies.title AS title, movies.image AS image, movies.id AS id
        FROM movies
        INNER JOIN directors_movies
        ON movies.id = directors_movies.movies_id
        INNER JOIN directors
        ON directors.id = directors_movies.directors_id
        WHERE directors.id = ' . $id
        );

        return $query->result();
    }

    public function inserer($data) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'),
            'annee' => $this->input->post('annee'),
            'budget' => $this->input->post('budget'),
            'date_release' => $this->input->post('date_release'),
            'synopsis' => $this->input->post('synopsis'),
            'description' => $this->input->post('description'),
            'trailer' => $this->input->post('trailer'),
            'distributeur' => $this->input->post('distributeur'),
            'bo' => $this->input->post('bo'),
            'categories_id' => $this->input->post('categorie'),
            'visible' => $this->input->post('visible'),
            'cover' => $this->input->post('cover'),
            'date_created' => date('Y-m-d H:i:s'),
            'image' => base_url().'uploads/movies/'.$data['file_name']
        );

        $this->db->insert('movies',$data);

    }


    public function editer($id, $data) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'),
            'annee' => $this->input->post('annee'),
            'budget' => $this->input->post('budget'),
            'date_release' => $this->input->post('date_release'),
            'synopsis' => $this->input->post('synopsis'),
            'description' => $this->input->post('description'),
            'trailer' => $this->input->post('trailer'),
            'distributeur' => $this->input->post('distributeur'),
            'bo' => $this->input->post('bo'),
            'categories_id' => $this->input->post('categorie'),
            'visible' => $this->input->post('visible'),
            'cover' => $this->input->post('cover'),
            'image' => base_url().'uploads/movies/'.$data['file_name']
        );

        $this->db->where('id',$id);
        $this->db->update('movies',$data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('movies');

    }

    //Récupère les films appartenant à un tag ($id)
    public function getMoviesByTag($id){
        $query = $this->db->query('
            SELECT m.image AS image, m.title AS title, m.id AS id
            FROM movies AS m
            INNER JOIN tags_movies AS tm
            ON m.id = tm.movies_id
            WHERE tm.tags_id = ' . $id
        );

        return $query->result();
    }

    /* Retourne les films pour un cinema donné */
    public function getMoviesByCine($id){
        $this->db->select('m.title AS title, m.image AS image,m.id AS id');
        $this->db->from('movies AS m');
        $this->db->join('cinema_movies AS cm','cm.movies_id=m.id');
        $this->db->where('cm.cinemas_id', $id);

        $query = $this->db->get();
        return $query->result();
    }

    public function getMoviesBySeance($id){
        $this->db->select('m.title AS title, m.image AS image,m.id AS id');
        $this->db->from('movies AS m');
        $this->db->join('sessions AS s','s.movies_id=m.id');
        $this->db->where('s.id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    function rechercher() {
        $mot = $this->input->post('mot');

        $query = $this->db->query("SELECT m.image AS mimage ,m.title AS mtitle, m.id, c.title AS ctitle, m.description, m.synopsis
                                  FROM movies AS m

                                  LEFT JOIN actors_movies AS am
                                  ON m.id = am.actors_id

                                  LEFT JOIN actors AS a
                                  ON a.id = am.actors_id

                                  LEFT JOIN directors_movies AS dm
                                  ON m.id = dm.movies_id

                                  LEFT JOIN directors AS d
                                  ON d.id = dm.directors_id

                                  LEFT JOIN tags_movies AS tm
                                  ON m.id = tm.movies_id

                                  LEFT JOIN tags AS t
                                  ON t.id = tm.tags_id

                                  LEFT JOIN categories AS c
                                  ON c.id = m.categories_id

                                  WHERE m.title LIKE '%".$mot."%'
                                  OR m.description LIKE '%".$mot."%'
                                  OR m.synopsis LIKE '%".$mot."%'

                                  OR c.title LIKE '%".$mot."%'

                                  OR CONCAT(a.firstname, ' ',a.lastname) LIKE '%".$mot."%'

                                  OR CONCAT(d.firstname, ' ',d.lastname) LIKE '%".$mot."%'

                                  OR t.word LIKE '%".$mot."%'

                                  GROUP BY m.id

                                  ");

        return $query->result();
    }

    function rechercheAjax() {
        $mot = $this->input->post('mot');

        $query = $this->db->query("SELECT m.title AS mtitle
                                  FROM movies AS m

                                  LEFT JOIN actors_movies AS am
                                  ON m.id = am.actors_id

                                  LEFT JOIN actors AS a
                                  ON a.id = am.actors_id

                                  LEFT JOIN directors_movies AS dm
                                  ON m.id = dm.movies_id

                                  LEFT JOIN directors AS d
                                  ON d.id = dm.directors_id

                                  LEFT JOIN tags_movies AS tm
                                  ON m.id = tm.movies_id

                                  LEFT JOIN tags AS t
                                  ON t.id = tm.tags_id

                                  LEFT JOIN categories AS c
                                  ON c.id = m.categories_id

                                  WHERE m.title LIKE '%".$mot."%'
                                  OR m.description LIKE '%".$mot."%'
                                  OR m.synopsis LIKE '%".$mot."%'

                                  OR c.title LIKE '%".$mot."%'

                                  OR CONCAT(a.firstname, ' ',a.lastname) LIKE '%".$mot."%'

                                  OR CONCAT(d.firstname, ' ',d.lastname) LIKE '%".$mot."%'

                                  OR t.word LIKE '%".$mot."%'

                                  GROUP BY m.id

                                  ");

        return $query->result();
    }

    public function filmpaginer($limit, $offset) {
        $query = $this->db->query('
        SELECT movies.title AS title, movies.annee AS annee, categories.title AS cat,
        movies.synopsis AS syno, movies.id AS id, movies.note_presse AS stars,
        movies.visible AS visible, movies.cover AS cover,
        DATE_FORMAT(movies.date_created, "%d/%m/%Y") AS datedecreation, movies.price AS prix,
        movies.date_created AS date
        FROM movies
        LEFT JOIN categories
        ON movies.categories_id = categories.id
        LIMIT '.$offset.','.$limit.'');
        return $query->result();
    }

    function count_items(){
        $query = $this->db->get('movies');
        return $query->num_rows();
    }

    // affiche les images des films pour le slider du frontoffice
    public function getMoviesForSlider(){
        $this->db->select('m.image AS image, m.title AS title, c.title AS categorie');
        $this->db->from('movies AS m');
        $this->db->join('categories AS c','c.id = m.categories_id');
        $this->db->order_by("title", "random");
        $this->db->limit(3);

        $query = $this->db->get();
        return $query->result();
    }

    // Affiche la Vidéo du film déjà sortis cette année là et le mieux noté par la presse
    public function getvideo(){
        $query = $this->db->query('
        SELECT *
        FROM movies
        WHERE YEAR( date_release ) = YEAR( NOW( ) )
        AND date_release < NOW( )
        ORDER BY note_presse DESC
        ');

        return $query->row();
    }

    // retourne le nombre de films diffusés depuis moins de 3 mois
    function nbFilmsDiff(){
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->join('sessions','sessions.movies_id = movies.id');
        $this->db->where("sessions.date_session <", "now()");
        $this->db->where("TIMESTAMPDIFF(MONTH,sessions.date_session,NOW()) <", "3");

        $query = $this->db->get();
        return $query->num_rows();
    }

    // retourne le nombre de films ayant des commentaires actifs
    function nbFilmsComAc(){
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->join('comments','movies.id = comments.movies_id');
        $this->db->where("comments.state =", "2");

        $query = $this->db->get();
        return $query->num_rows();
    }

    //retourne les 2 films ayant le plus de commentaires, et mis en avant
    function filmsComFront(){
        $this->db->select('movies.title AS title, movies.image AS image, COUNT(comments.id) AS nb,
        movies.description AS description, categories.title AS ctitle');
        $this->db->from('movies');
        $this->db->join('comments','movies.id = comments.movies_id');
        $this->db->join('categories','movies.categories_id = categories.id');
        $this->db->where("movies.cover =", "1");
        $this->db->group_by("movies.id");
        $this->db->order_by("COUNT(comments.id)", "desc");
        $this->db->limit(2);

        $query = $this->db->get();
        return $query->result();
    }

    // retourne le nombre de films déjà sortis
    function filmsOut(){
        $this->db->select('*');
        $this->db->from('movies');
        $this->db->where("date_release <", "NOW()");

        $query = $this->db->get();
        return $query->num_rows();
    }

    // retourne la durée de tous les films
    function filmsDuree(){
        $this->db->select_sum('duree');
        $query = $this->db->get('movies');

        return $query->row();
    }

    // retourne les 3 derniers films mis en vente
    function filmsShop(){
        $this->db->select('movies.title AS title, movies.budget AS budget, movies.duree AS duree,
                           movies.distributeur AS distributeur, movies.note_presse AS note_presse,
                           movies.price AS price, categories.title AS cat');
        $this->db->from('movies');
        $this->db->join('categories','categories.id = movies.categories_id');
        $this->db->where('shop',1);
        $this->db->order_by('date_release','desc');
        $this->db->limit(3);

        $query = $this->db->get();
        return $query->result();
    }


}








?>