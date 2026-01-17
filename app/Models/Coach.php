<?php

require_once 'User.php';

class Coach extends User {
    public function getAll(){
        $sql = 'SELECT u.* , c.specialites , c.experience , c.description , c.tarif_horaire
                FROM users u
                JOIN coaches c ON u.id = c.users_id
                WHERE u.role = "coach" 
                ORDER BY u.id DSSC';
        $stmt = $this->db->prepare($sql);
        return $stmt->fetchAll();
    }

    public function getById($id){
        $sql = "SELECT u.*, c.specialites, c.experience, c.description, c.tarif_horaire 
                FROM users u 
                JOIN coaches c ON u.id = c.user_id 
                WHERE c.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $userId = parent::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'coach'
        ]);

        $sql = 'INSERT INTO coaches (user_id , specialites , experience , description , tarif_horaire)
        VALUES (?,?,?,?,?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $userId,
            $data['specialites'],
            $data['experience'],
            $data['description'],
            $data['tarif_horaire']
        ]);

        return $userId;
    }
}