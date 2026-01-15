<?php

class Reservation {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = 'SELECT r.*,
                    u.nom as sportif_nom , u.prenom as sportif_prenom,
                    s.titre as sance_titre , s.date_seance , s.heure_debut
                FROM reservations r
                JOIN sportifs sp ON r.sportif_id = sp.id 
                JOIN users u ON sp.user_id = u.id
                JOIN seances s ON r.seance_id = s.id
                ORDER BY r.date_reservation DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM reservations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getBySportif($sportifId) {
        $sql = "SELECT r.*, s.titre, s.date_seance, s.heure_debut, s.heure_fin,
                        u.nom as coach_nom, u.prenom as coach_prenom
                FROM reservations r
                JOIN seances s ON r.seance_id = s.id
                JOIN coaches c ON s.coach_id = c.id
                JOIN users u ON c.user_id = u.id
                WHERE r.sportif_id = ?
                ORDER BY s.date_seance DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sportifId]);
        return $stmt->fetchAll();
    }

    public function getByCoach($coachId) {
        $sql = "SELECT r.*, s.titre, s.date_seance, s.heure_debut,
                        u.nom as sportif_nom, u.prenom as sportif_prenom
                FROM reservations r
                JOIN seances s ON r.seance_id = s.id
                JOIN sportifs sp ON r.sportif_id = sp.id
                JOIN users u ON sp.user_id = u.id
                WHERE s.coach_id = ?
                ORDER BY s.date_seance DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$coachId]);
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO reservations (sportif_id, seance_id, statut) 
                VALUES (?, ?, ?) RETURNING id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['sportif_id'],
            $data['seance_id'],
            $data['statut'] ?? 'confirmee'
        ]);
        return $stmt->fetchColumn();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM reservations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}