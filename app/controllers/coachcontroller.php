<?php

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/Coach.php';
require_once __DIR__ . '/../Models/Seance.php';
require_once __DIR__ . '/../Models/Reservation.php';
require_once 'Controller.php';

class CoachController extends Controller
{

    private function checkAuth()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'coach') {
            $this->redirect('/sport-mvc/public/index.php?url=auth/login');
        }
    }

    public function profile()
    {
        $this->checkAuth();

        $coachModel = new Coach();
        $coaches = $coachModel->getAll();

        $currentCoach = null;
        foreach ($coaches as $coach) {
            if ($coach['id'] == $_SESSION['user_id']) {
                $currentCoach = $coach;
                break;
            }
        }

        $this->view('coach/profile', ['coach' => $currentCoach]);
    }

    public function seances()
    {
        $this->checkAuth();

        $coachModel = new Coach();
        $coaches = $coachModel->getAll();
        $coachId = null;

        foreach ($coaches as $coach) {
            if ($coach['id'] == $_SESSION['user_id']) {
                $db = Database::getInstance()->getConnection();
                $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
                $stmt->execute([$coach['id']]);
                $result = $stmt->fetch();
                $coachId = $result['id'];
                break;
            }
        }

        $seanceModel = new Seance();
        $seances = $seanceModel->getByCoach($coachId);

        $this->view('coach/seances', ['seances' => $seances]);
    }

    public function addSeance()
    {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            $result = $stmt->fetch();
            $coachId = $result['id'];

            $data = [
                'coach_id' => $coachId,
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'date_seance' => $_POST['date_seance'],
                'heure_debut' => $_POST['heure_debut'],
                'heure_fin' => $_POST['heure_fin'],
                'places_disponibles' => $_POST['places_disponibles']
            ];

            $seanceModel = new Seance();
            $seanceModel->create($data);

            $this->redirect('/sport-mvc/public/index.php?url=coach/seances');
        } else {
            $this->view('coach/add_seance');
        }
    }

    public function editSeance()
    {
        $this->checkAuth();

        $id = $_GET['id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'titre' => $_POST['titre'],
                'description' => $_POST['description'],
                'date_seance' => $_POST['date_seance'],
                'heure_debut' => $_POST['heure_debut'],
                'heure_fin' => $_POST['heure_fin'],
                'places_disponibles' => $_POST['places_disponibles']
            ];

            $seanceModel = new Seance();
            $seanceModel->update($id, $data);

            $this->redirect('/sport-mvc/public/index.php?url=coach/seances');
        } else {
            $seanceModel = new Seance();
            $seance = $seanceModel->getById($id);
            $this->view('coach/edit_seance', ['seance' => $seance]);
        }
    }

    public function deleteSeance()
    {
        $this->checkAuth();

        $id = $_GET['id'] ?? null;

        $seanceModel = new Seance();
        $seanceModel->delete($id);

        $this->redirect('/sport-mvc/public/index.php?url=coach/seances');
    }

    public function reservations()
    {
        $this->checkAuth();

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch();
        $coachId = $result['id'];

        $reservationModel = new Reservation();
        $reservations = $reservationModel->getByCoach($coachId);

        $this->view('coach/reservations', ['reservations' => $reservations]);
    }
}
