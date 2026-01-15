<?php

require_once __DIR__ . '/../Models/Database.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Coach.php';
require_once __DIR__ . '/../Models/Sportif.php';
require_once 'Controller.php';

class AuthController extends Controller {
    public function login() {
        $this->view('auth/login');
    }

    public function doLogin () {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->getByEmail($email);

            if ($user && password_verify($password , $user['password'])) {

                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_nom'] = $user['nom'];
                    $_SESSION['user_pronemo'] = $user['prenom'];
                    $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === 'coach') {
                    $this->redirect('/coachproV3/public/index.php?url=coach/profile');
                } else {
                    $this->redirect('/coachproV3/public/index.php?url=sportif/coaches');
                }
            } else {
                $error = "email or password incorrect";
                $this->view('auth/login', ['error' => $error]);
            }
            }
        }

    public function register() {
        $this->view('auth/register');
    }

    public function logout(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        $this->redirect('/coachproV3/public/index.php?url=auth/login');
    }

    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ;

            $data = [
                'nom' => $_POST['nom'],
                'prenom' => $_POST['prenom'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'role' => $role
            ];

            $userModel = new User();
            if ($userModel->getByEmail($_POST['email'])) {
                $error = 'cette email est deja utilise';
                $this->view('auth/register', ['error' => $error]);
                return;
            }

            if ($role === 'coach') {
                $data['specialites'] = $_POST['specialites'];
                $data['experience'] = $_POST['experience'];
                $data['description'] = $_POST['description'];
                $data['tarif_horaire'] = $_POST['tarif_horaire'];

                $coachModel = new Coach();
                $userId = $coachModel->create($data);
            } else {
                $data['niveau'] = $_POST['niveau'];
                $data['objectifs'] = $_POST['objectifs'];

                $sportifModel = new Sportif();
                $userId = $sportifModel->create($data);
            }

            if ($userId) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_nom'] = $data['nom'];
                $_SESSION['user_prenom'] = $data['prenom'];
                $_SESSION['user_role'] = $role;

                if ($role === 'coach') {
                    $this->redirect('/coachproV3/public/index.php?url=coach/profile');
                } else {
                    $this->redirect('/coachproV3/public/index.php?url=sportif/coaches');
                }
            }
        }
    }
}
