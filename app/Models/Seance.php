<?php

require_once 'User.php';

class Seance {
    private $db;

    public function __construct(){
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT s.*, u.nom as coach_nom, u.prenom as coach_prenom 
                FROM seances s 
                JOIN coaches c ON s.coach_id = c.id 
                JOIN users u ON c.user_id = u.id 
                ORDER BY s.date_seance DESC, s.heure_debut DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT s.*, u.nom as coach_nom, u.prenom as coach_prenom 
                FROM seances s 
                JOIN coaches c ON s.coach_id = c.id 
                JOIN users u ON c.user_id = u.id 
                WHERE s.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getByCoach($coachId) {
        $sql = "SELECT * FROM seances WHERE coach_id = ? ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coachId]);
        return $stmt->fetchAll();
    }

    public function create ($data) {
        $sql = 'INSERT INTO seances (coach_id , titre , description , date_seances , heure_debut , heure_fin , place_disponibles )
        VALUES (?,?,?,?,?,?,?) RETURNINING id ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['coach_id'],
            $data['titre'],
            $data['description'],
            $data['date_seance'],
            $data['heure_debut'],
            $data['heure_fin'],
            $data['places_disponibles']
        ]);
        return $stmt->fetchColumn();
    }

    public function update($id, $data){
        $sql = "UPDATE seances 
                SET titre = ?, description = ?, date_seance = ?, heure_debut = ?, heure_fin = ?, places_disponibles = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['titre'],
            $data['description'],
            $data['date_seance'],
            $data['heure_debut'],
            $data['heure_fin'],
            $data['places_disponibles'],
            $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM seances WHERE id = ?");
        return $stmt->execute([$id]);
    }
}