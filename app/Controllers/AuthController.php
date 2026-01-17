<?php

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Coach.php';
require_once __DIR__ . '/../Models/Sportif.php';
require_once __DIR__ . '/../../core/Security.php';
require_once __DIR__ . '/../../core/Session.php';
require_once __DIR__ . '/../../core/Validator.php';
require_once 'Controller.php';

class AuthController extends Controller {

    public function __construct() {
        Session::start();
    }

    public function login() {
        if (Security::isAuthenticated()) {
            $this->redirectByRole();
        }

        $token = Security::generateToken();
        $this->view('auth/login', ['csrf_token' => $token]);
    }

    public function doLogin() {
        Session::start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/login');
        }

        if (!Security::validateToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Token CSRF invalide');
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/login');
        }

        $email = Security::sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $validator = new Validator();
        $validator->required('email', $email)
            ->email('email', $email)
            ->required('password', $password);

        if ($validator->fails()) {
            Session::set('errors', $validator->errors());
            Session::set('old', ['email' => $email]);
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/login');
        }

        $userModel = new User();
        $user = $userModel->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            Session::set('user_id', $user['id']);
            Session::set('user_nom', $user['nom']);
            Session::set('user_prenom', $user['prenom']);
            Session::set('user_role', $user['role']);

            Session::setFlash('success', 'Connexion réussie !');
            $this->redirectByRole();
        } else {
            Session::setFlash('error', 'Email ou mot de passe incorrect');
            Session::set('old', ['email' => $email]);
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/login');
        }
    }

    public function register()
    {
        if (Security::isAuthenticated()) {
            $this->redirectByRole();
        }

        $token = Security::generateToken();
        $this->view('auth/register', ['csrf_token' => $token]);
    }

    public function doRegister()
    {
        Session::start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/register');
        }

        if (!Security::validateToken($_POST['csrf_token'] ?? '')) {
            Session::setFlash('error', 'Token CSRF invalide');
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/register');
        }

        $data = Security::sanitize($_POST);
        $role = $data['role'] ?? 'sportif';

        $validator = new Validator();
        $validator->required('nom', $data['nom'])
            ->minLength('nom', $data['nom'], 2)
            ->required('prenom', $data['prenom'])
            ->minLength('prenom', $data['prenom'], 2)
            ->required('email', $data['email'])
            ->email('email', $data['email'])
            ->required('password', $data['password'])
            ->minLength('password', $data['password'], 6);

        if ($role === 'coach') {
            $validator->required('specialites', $data['specialites'])
                ->required('description', $data['description'])
                ->minLength('description', $data['description'], 20)
                ->required('tarif_horaire', $data['tarif_horaire'])
                ->numeric('tarif_horaire', $data['tarif_horaire']);
        }

        if ($validator->fails()) {
            Session::set('errors', $validator->errors());
            Session::set('old', $data);
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/register');
        }

        $userModel = new User();
        if ($userModel->getByEmail($data['email'])) {
            Session::setFlash('error', 'Cet email est déjà utilisé');
            Session::set('old', $data);
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/register');
        }

        try {
            if ($role === 'coach') {
                $coachModel = new Coach();
                $userId = $coachModel->create($data);
            } else {
                $sportifModel = new Sportif();
                $userId = $sportifModel->create($data);
            }

            if ($userId) {
                session_regenerate_id(true);
                Session::set('user_id', $userId);
                Session::set('user_nom', $data['nom']);
                Session::set('user_prenom', $data['prenom']);
                Session::set('user_role', $role);

                Session::setFlash('success', 'Inscription réussie ! Bienvenue !');
                $this->redirectByRole();
            }
        } catch (Exception $e) {
            Session::setFlash('error', 'Une erreur est survenue lors de l\'inscription');
            Session::set('old', $data);
            $this->redirect('/CoachPro_V3/public/index.php?url=auth/register');
        }
    }

    public function logout()
    {
        Session::start();
        Session::destroy();
        session_start();
        Session::setFlash('success', 'Déconnexion réussie');
        $this->redirect('/CoachPro_V3/public/index.php?url=auth/login');
    }

    private function redirectByRole()
    {
        $role = Session::get('user_role');
        if ($role === 'coach') {
            $this->redirect('/CoachPro_V3/public/index.php?url=coach/profile');
        } else {
            $this->redirect('/CoachPro_V3/public/index.php?url=sportif/coaches');
        }
    }
}
