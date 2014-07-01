<?php

class SettingsController extends Controller {

    public function index() {
        $settings = $this->get_settings();
        
        if($this->get_session() === NULL) {
            $this->redirect('login');
        }
        
        $this->meta->title = 'Settings';
        $model = array('error' => NULL);
        $this->view($model);
    }

    public function password() {
        if($this->get_session() == NULL) {
            $this->redirect('login');
        }

        $model = array(
            'password' => $this->post('password'),
            'confirm' => $this->post('confirm'),
            'error' => NULL
        );

        if(array_key_exists('submit', $_POST)) {
            if(empty($model['password']) || empty($model['confirm'])) {
                $model['error'] = 'Please enter both a password and confirm password.';
                return $this->view($model);
            }

            if(strcmp($model['password'], $model['confirm']) !== 0) {
                $model['error'] = 'The passwords do not match.';
                return $this->view($model);
            }
            $settings = $this->get_settings();
            if($settings === NULL) {
                $model['error'] = 'Failed to load settings: ' . last_error();
                return $this->view($model);
            }

            $hash = hash('sha512', $model['password'] . $settings->password_salt);
            if(strcmp(strtolower($model['email']), $settings->email) !== 0 ||
                strcmp($hash, $settings->password_hash) !== 0) {
                $model['error'] = 'That email/password combination was not valid.';
                return $this->view($model);
            }

            $session = new session();
            $session->code = uniqid();
            if(!$session->insert()) {
                $model['error'] = 'Failed to create new session: ' . last_error();
                return $this->view($model);
            }

            $session = session::select_by_id($session->id);
            if($session === NULL) {
                $model['error'] = 'Failed to load new session: ' . last_error();
                return $this->view($model);
            }
            $this->set_session($session);
            $this->redirect(NULL);
        }

        $this->view($model);
    }

    public function login() {
        $model = array(
            'email' => $this->post('email'), 
            'password' => $this->post('password'),
            'error' => NULL);

        if(array_key_exists('submit', $_POST)) {
            if(empty($model['email']) || empty($model['password'])) {
                $model['error'] = 'Please enter a email and password';
                return $this->view($model);
            }

            $settings = $this->get_settings();
            if($settings === NULL) {
                $model['error'] = 'Failed to load settings: ' . last_error();
                return $this->view($model);
            }

            $hash = hash('sha512', $model['password'] . $settings->password_salt);
            if(strcmp($model['email'], $settings->email) !== 0 ||
                strcmp($hash, $settings->password_hash) !== 0) {
                $model['error'] = 'That email/password combination was not valid.';
                return $this->view($model);
            }

            $session = new session();
            $session->code = uniqid();
            if(!$session->insert()) {
                $model['error'] = 'Failed to create new session: ' . last_error();
                return $this->view($model);
            }

            $session = session::select_by_id($session->id);
            if($session === NULL) {
                $model['error'] = 'Failed to load new session: ' . last_error();
                return $this->view($model);
            }
            $this->set_session($session);
            $this->redirect(NULL);
        }
        
        return $this->view($model);
    }
}

?>