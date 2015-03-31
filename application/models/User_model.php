<?php

class User_model extends CI_Model{

    /**
     * Récupérer les dernier utlisateurs connecté
     * @return mixed
     */
    public function lastUser(){

        //recupérer l'utilisateur en session
        $user = $this->session->userdata("user");

        $query = $this->db->query("
                SELECT *
                FROM user
                WHERE id != ".$user->id."
                ORDER BY last_login DESC
                LIMIT 10
            ");

        return $query->result();
    }


    /**
     * Retournr la discussion entre utilisateur
     * @return mixed
     */
    function getDiscussion($id){
        $user = $this->session->userdata("user");

        $query = $this->db->query("
                SELECT *, uf.username as userfrom, ut.username as userto
                FROM discussions AS d

                INNER JOIN user AS uf
                ON d.users_from = uf.id

                INNER JOIN user AS ut
                ON d.users_to = ut.id

                WHERE
                (users_from = ".$user->id." AND users_to = ".$id.")
                OR
                (users_to = ".$user->id." AND users_from = ".$id.")


                ORDER BY d.date_created DESC
            ");

        return $query->result(); //retourne le nom de ligne affecté
    }


    public function recupererUser(){

        $username = $this->input->post('login');
        $password = $this->input->post('password');

        $this->db->select('*');
        $this->db->from('user');

        $this->db->where('enabled', 1);
        $this->db->where("username='".$username."' OR email='" .$username. "'");


        $query = $this->db->get();

        $user = $query->row();

        if(!empty($user)){
            if($this->encrypt->decode($user->password) != $password){
                return null;
            }
        }
        else{
            return null;
        }

        return $user;

    }

    public function allUsers(){

        $query = $this->db->get('user');

        return $query->result();
    }


    function inserer($image) {

        // je prépare un tableau de données avec les clés qui sont mes champs de tables

        $passwd = $this->input->post('password1');
        $enc_passwd = $this->encrypt->encode($passwd);

        $data = array(
            'username' => $this->input->post('username'), // $this->input->post mde permet de récupérer mes valeurs en post
            'password' => $enc_passwd,
            'email' => $this->input->post('email'),
            'is_admin' => $this->input->post('role'),
            'avatar' => base_url().'uploads/users/'.$image['file_name'],
            'enabled' => '1',
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('user', $data);

    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('user');

    }

    public function getOneUserById($id) {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row();
    }

    public function sendDiscussion($id){
        $user = $this->session->userdata('user');

        $data = array(
            'content' => $this->input->post('content') ,
            'users_from' => $user->id,
            'users_to' => $id ,
            'date_created' => date('Y-m-d H:i:s'),
        );

        $this->db->insert('discussions', $data);
    }


    function editer($id, $image) {

        $passwd = $this->input->post('password1');
        $enc_passwd = $this->encrypt->encode($passwd);

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'password' => $passwd,
            'email' => $this->input->post('email'),
            'is_admin' => $this->input->post('role'),
            'avatar' => base_url().'uploads/users/'.$image['file_name']
        );
        $this->db->where('id', $id);
        $this->db->update('user', $data);

    }

    // vérifie si une adresse mail est bien inexistante en bdd en cas de changement de mail à l'édition d'un user
    function compareEmailDb($email, $usr) {

        $this->db->select('username');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('username !=', $usr);

        $query = $this->db->get();
        return $query->num_rows();

    }
    // met à jour la date du champ last_login
    function updateLastLogin($id) {

        $data = array(
            'last_login' => date('Y-m-d H:i:s'),
        );

        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    function adminActifs() {

        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('is_admin=', 2);
        $this->db->where('enabled=', 1);

        $query = $this->db->get();
        return $query->num_rows();
    }

    function nbFav() {

        $query = $this->db->get('user_favoris');
        return $query->num_rows();

    }

}