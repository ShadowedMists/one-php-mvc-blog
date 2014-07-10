<?php

class AdminController extends Controller {

    public function index() {
        if($this->get_session() == NULL) {
            $this->redirect('login');
        }

        $settings = $this->get_settings();
        
        $this->meta->title = 'Blog Administration';
        $entries = entry::select_list();
        $this->view($entries);
    }

    public function password() {
        if($this->get_session() == NULL) {
            $this->redirect('login');
        }
        
        $settings = $this->get_settings();

        $this->meta->title = 'Update Password';

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

            if(strlen($model['password']) < 6) {
                $model['error'] = 'Please enter a password that is at least 6 characters.';
                return $this->view($model);
            }

            if(strcmp($model['password'], $model['confirm']) !== 0) {
                $model['error'] = 'The passwords do not match.';
                return $this->view($model);
            }
            
            $settings->password_hash = hash('sha512', $model['password'] . $settings->password_salt);
            
            if(!$settings->update()) {
                $model['error'] = 'Failed to update password: ' . last_error();
                return $this->view($model);
            }
            $this->redirect(NULL);
        }

        $this->view($model);
    }

    public function login() {
        $settings = $this->get_settings();
        
        $this->meta->title = 'one-php-mvc-blog Login';
        
        $model = array(
            'email' => $this->post('email'), 
            'password' => $this->post('password'),
            'error' => NULL);

        if(array_key_exists('submit', $_POST)) {
            if(empty($model['email']) || empty($model['password'])) {
                $model['error'] = 'Please enter a email and password';
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
        
        $this->view($model);
    }

    public function settings() {
        if($this->get_session() == NULL) {
            $this->redirect('login');
        }

        $model = array(
            'blog_name' => $this->post('blog_name'),
            'display_name' => $this->post('display_name'),
            'email' => $this->post('email'),
            'error' => NULL
        );

        if(array_key_exists('submit', $_POST)) {
            $req = array();
            if(empty($model['blog_name'])) {
                $req[] = 'Blog Name';
            }
            if(empty($model['display_name'])) {
                $req[] = 'Your Name';
            }
            if(empty($model['email'])) {
                $req[] = 'Email';
            }
            if(!empty($req)) {
                $model['error'] = 'The following fields are required: ' . implode(', ', $req);
                return $this->view($model);
            }

            if(!filter_var($model['email'], FILTER_VALIDATE_EMAIL)) {
                $model['error'] = 'Please enter a valid email address.';
                return $this->view($model);
            }
            
            $settings = $this->get_settings();
            $settings->blog_name = $model['blog_name'];
            $settings->display_name = $model['display_name'];
            $settings->email = $model['email'];
            
            if(!$settings->update()) {
                $model['error'] = 'Failed to update settings: ' . last_error();
                return $this->view($model);
            }
            return $this->redirect(NULL);
        }
        else {
            $settings = $this->get_settings();
            $model['blog_name'] = $settings->blog_name;
            $model['display_name'] = $settings->display_name;
            $model['email'] = $settings->email;
        }
        $this->view($model);
    }

    public function logoff() {
        $this->set_session(NULL);
        $this->redirect(NULL, "home");
    }
}

?>