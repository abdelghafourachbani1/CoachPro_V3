<?php

require_once __DIR__ . '/../models/database.php';
require_once __DIR__ . '/../models/coach.php';
require_once __DIR__ . '/../models/seance.php';
require_once __DIR__ . '/../models/reservation.php';
require_once __DIR__ . '/../../core/security.php';
require_once __DIR__ . '/../../core/session.php';
require_once __DIR__ . '/../../core/validator.php';
require_once 'Controller.php';

class CoachController extends Controller {

    public function __construct() {
        Session::start();
    }

    private function checkAuth() {
        if (!Security::isAuthenticated() || !Security::hasRole('coach')) {
            Session::setFlash('error', 'Accès interdit');
            $this->redirect('/coachproV3/public/index.php?url=auth/login');
        }
    }

    public function profile() {
        $this->checkAuth();

        $coachModel = new Coach();
        $coaches = $coachModel->getAll();

        $currentCoach = null;
        foreach ($coaches as $coach) {
            if ($coach['id'] == Session::get('user_id')) {
                $currentCoach = $coach;
                break;
            }
        }

        $this->view('coach/profile', ['coach' => $currentCoach]);
    }

    public function seances() {
        $this->checkAuth();

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
        $stmt->execute([Session::get('user_id')]);
        $result = $stmt->fetch();
        $coachId = $result['id'];

        $seanceModel = new Seance();
        $seances = $seanceModel->getByCoach($coachId);

        $this->view('coach/seances', ['seances' => $seances]);
    }

    public function addSeance() {
        $this->checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::validateToken($_POST['csrf_token'] ?? '')) {
                Session::setFlash('error', 'Token CSRF invalide');
                $this->redirect('/coachproV3/public/index.php?url=coach/addSeance');
            }

            $data = Security::sanitize($_POST);

            $validator = new Validator();
            $validator->required('titre', $data['titre'])
                ->minLength('titre', $data['titre'], 3)
                ->required('description', $data['description'])
                ->minLength('description', $data['description'], 10)
                ->required('date_seance', $data['date_seance'])
                ->date('date_seance', $data['date_seance'])
                ->required('heure_debut', $data['heure_debut'])
                ->required('heure_fin', $data['heure_fin'])
                ->required('places_disponibles', $data['places_disponibles'])
                ->numeric('places_disponibles', $data['places_disponibles']);

            if ($validator->fails()) {
                Session::set('errors', $validator->errors());
                Session::set('old', $data);
                $this->redirect('/coachproV3/public/index.php?url=coach/addSeance');
            }

            $today = date('Y-m-d');
            if ($data['date_seance'] < $today) {
                Session::setFlash('error', 'La date doit être dans le futur');
                Session::set('old', $data);
                $this->redirect('/coachproV3/public/index.php?url=coach/addSeance');
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
            $stmt->execute([Session::get('user_id')]);
            $result = $stmt->fetch();
            $coachId = $result['id'];

            $data['coach_id'] = $coachId;

            $seanceModel = new Seance();
            if ($seanceModel->create($data)) {
                Session::setFlash('success', 'Séance créée avec succès');
                $this->redirect('/coachproV3/public/index.php?url=coach/seances');
            }
        } else {
            $token = Security::generateToken();
            $this->view('coach/add_seance', ['csrf_token' => $token]);
        }
    }

    public function editSeance() {
        $this->checkAuth();

        $id = $_GET['id'] ?? null;

        if (!$id) {
            Session::setFlash('error', 'Séance introuvable');
            $this->redirect('/coachproV3/public/index.php?url=coach/seances');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::validateToken($_POST['csrf_token'] ?? '')) {
                Session::setFlash('error', 'Token CSRF invalide');
                $this->redirect('/coachproV3/public/index.php?url=coach/editSeance&id=' . $id);
            }

            $data = Security::sanitize($_POST);

            $validator = new Validator();
            $validator->required('titre', $data['titre'])
                ->minLength('titre', $data['titre'], 3)
                ->required('description', $data['description'])
                ->required('date_seance', $data['date_seance'])
                ->date('date_seance', $data['date_seance'])
                ->required('heure_debut', $data['heure_debut'])
                ->required('heure_fin', $data['heure_fin'])
                ->required('places_disponibles', $data['places_disponibles'])
                ->numeric('places_disponibles', $data['places_disponibles']);

            if ($validator->fails()) {
                Session::set('errors', $validator->errors());
                Session::set('old', $data);
                $this->redirect('/coachproV3/public/index.php?url=coach/editSeance&id=' . $id);
            }

            $seanceModel = new Seance();
            if ($seanceModel->update($id, $data)) {
                Session::setFlash('success', 'Séance modifiée avec succès');
                $this->redirect('/coachproV3/public/index.php?url=coach/seances');
            }
        } else {
            $seanceModel = new Seance();
            $seance = $seanceModel->getById($id);
            $token = Security::generateToken();
            $this->view('coach/edit_seance', [
                'seance' => $seance,
                'csrf_token' => $token
            ]);
        }
    }

    public function deleteSeance() {
        $this->checkAuth();

        $id = $_GET['id'] ?? null;
        $token = $_GET['token'] ?? null;

        if (!Security::validateToken($token)) {
            Session::setFlash('error', 'Token CSRF invalide');
            $this->redirect('/coachproV3/public/index.php?url=coach/seances');
        }

        if ($id) {
            $seanceModel = new Seance();
            if ($seanceModel->delete($id)) {
                Session::setFlash('success', 'Séance supprimée avec succès');
            } else {
                Session::setFlash('error', 'Erreur lors de la suppression');
            }
        }

        $this->redirect('/coachproV3/public/index.php?url=coach/seances');
    }

    public function reservations() {
        $this->checkAuth();

        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT id FROM coaches WHERE user_id = ?");
        $stmt->execute([Session::get('user_id')]);
        $result = $stmt->fetch();
        $coachId = $result['id'];

        $reservationModel = new Reservation();
        $reservations = $reservationModel->getByCoach($coachId);

        $this->view('coach/reservations', ['reservations' => $reservations]);
    }
}
