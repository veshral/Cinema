<?php


class Album_model extends CI_Model{

    public function userAlbum($id) {

        $this->db->select('*');
        $this->db->from('album');
        $this->db->where('user_id',$id);

        $query = $this->db->get();
        return $query->result();
    }

    public function supprimer($id) {

        $this->db->where('id',$id);
        $this->db->delete('album');

    }

    function inserer($image) {

        $user = $this->session->userdata('user');

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post mde permet de récupérer mes valeurs en post
            'description' => $this->input->post('description'),
            'date_created' => date('Y-m-d H:i:s'),
            'user_id' => $user->id,
            'file_name' => $image['file_name'],
            'photo' => base_url().'uploads/album/'. $user->id .'/'.$image['file_name']
        );

        $this->db->insert('album', $data);

    }

    function getOneAlbumById($id) {
        $this->db->select('*');
        $this->db->from('album');
        $this->db->where('id',$id);

        $query = $this->db->get();
        return $query->row();
    }

    function editer($id, $image) {

        $user = $this->session->userdata('user');

        // je prépare un tableau de données avec les clés qui sont mes champs de tables
        $data = array(
            'title' => $this->input->post('title'), // $this->input->post mde permet de récupérer mes valeurs en post
            'description' => $this->input->post('description'),
            'user_id' => $user->id,
            'photo' => base_url().'uploads/album/'. $user->id .'/'.$image['file_name']
        );

        if(empty($image['file_name'])){ //si mon fichier est vide
            unset($data['photo']); // je retire l'image de mon transporteur $data
        }

        $this->db->where('id', $id);
        $this->db->update('album', $data);

    }


}
