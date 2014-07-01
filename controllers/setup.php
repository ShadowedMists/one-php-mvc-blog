<?php

class SetupController extends Controller {
    public function index() {
        $this->meta->title = 'one-php-mvc-blog Setup';
        
        $model = array(
            'blog_name' => 'one-php-mvc-blog',
            'display_name' => 'Journalist',
            'email' => 'blog@shadowedmists.com',
            'password' => null,
        );

        if(array_key_exists('submit', $_POST)) {
            if($settings === NULL) {
                $settings = new setting();
                $settings->blog_name = $model['blog_name'];
                $settings->display_name = $model['display_name'];
                $settings->email = $model['email'];
                $settings->password_salt = uniqid();
                $settings->password_hash = hash('sha512', $model['password'] . $settings->password_salt);
                if(!$settings->insert()) {
                    echo 'Failed to create initial settings: ' . last_error();
                    exit;
                }
            }
        }
    }
}

?>