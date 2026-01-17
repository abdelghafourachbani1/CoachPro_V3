<?php

require_once __DIR__ . '/../../core/ession.php';
require_once 'Controller.php';

class HomeController extends Controller {
    
    public function index() {
        Session::start();
        
        if (Session::isAuthenticated()) {
            $role = Session::get('user_role');
            if ($role === 'coach') {
                $this->redirect('/coachproV3/public/index.php?url=coach/profile');
            } else {
                $this->redirect('/coachproV3/public/index.php?url=sportif/coaches');
            }
        }
        
        $this->view('home/index');
    }
}
