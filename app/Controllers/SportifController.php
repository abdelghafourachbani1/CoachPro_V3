<?php

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/Coach.php';
require_once __DIR__ . '/../Models/Seance.php';
require_once __DIR__ . '/../Models/Reservation.php';
require_once 'Controller.php';

class SportifController extends Controller {

    private function checkAuth() {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'sportif') {
            $this->redirect('/coachpro_V3/public/index.php?url=auth/login');
        }
    }

    public function coaches()
    {
        $this->checkAuth();

        $coachModel = new Coach();
        $coaches = $coachModel->getAll();

        $this->view('sportif/coaches', ['coaches' => $coaches]);
    }

    public function seances()
    {
        $this->checkAuth();

        $seanceModel = new Seance();
        $seances = $seanceModel->getAll();

        $this->view('sportif/seances', ['seances' => $seances]);
    }

    public function reserver()
    {
        $this->checkAuth();

        $seanceId = $_GET['seance_id'] ?? null;

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM sportifs WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch();
        $sportifId = $result['id'];

        $data = [
            'sportif_id' => $sportifId,
            'seance_id' => $seanceId,
            'statut' => 'confirmee'
        ];

        $reservationModel = new Reservation();
        $reservationModel->create($data);

        $this->redirect('/CoachPro_V3/public/index.php?url=sportif/history');
    }

    public function history()
    {
        $this->checkAuth();

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM sportifs WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch();
        $sportifId = $result['id'];

        $reservationModel = new Reservation();
        $reservations = $reservationModel->getBySportif($sportifId);

        $this->view('sportif/history', ['reservations' => $reservations]);
    }
}
