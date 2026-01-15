<?php 

require_once 'User.php';

class Sportif extends User {
    public function getAll() {
        $sql = 'SELECT u.* , s.niveau , s.objectifs 
        FROM users u 
        JOIN sportifs s ON u.id = s.user_id
        WHERE u.role = "Sportif"';
        $stmt = $this->db->prepare($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT u.*, s.niveau, s.objectifs 
                FROM users u 
                JOIN sportifs s ON u.id = s.user_id 
                WHERE s.id = ?";
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
            'role' => 'sportif'
        ]);

        $sql = "INSERT INTO sportifs (user_id, niveau, objectifs) 
                VALUES (?, ?, ?)";
        $stmt = $this->db->query($sql);
        $stmt->execute([
            $userId,
            $data['niveau'] ,
            $data['objectifs']
        ]);

        return $userId;
}
}