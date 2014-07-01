<?php
date_default_timezone_set('UTC');
class Application {public static $DB_CONNECTION = NULL; }
function escape($sequence) {return mysqli_real_escape_string(Application::$DB_CONNECTION, $sequence);}
function last_error() {return mysqli_error(Application::$DB_CONNECTION);}

class entry {
    public $id;
    public $title;
    public $image_url;
    public $published;
    public $snippet;
    public $body;
    public $created;
    public $updated;

    public function load($row) {
        $this->id = intval($row['id']);
        $this->title = $row['title'];
        $this->image_url = $row['image_url'];
        $this->published = intval($row['published']);
        $this->snippet = $row['snippet'];
        $this->body = $row['body'];
        $this->created = $row['created'];
        $this->updated = $row['updated'];
    }

    public function insert() {
        $sql = 'insert into entry (title, image_url, published, snippet, body, created) values ("%s", "%s", %d, "%s", "%s", UTC_TIMESTAMP())';
        $sql = sprintf($sql, escape($this->title), escape($this->image_url), $this->published, escape($this->snippet), escape($this->body));
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        $this->id = mysqli_insert_id(Application::$DB_CONNECTION);
        return $res;
    }

    public function update() {
        $sql = 'update entry set title = "%s", image_url = "%s", published = %d, snippet = "%s", body = "%s", updated = UTC_TIMESTAMP() where id = %d';
        $sql = sprintf($sql, escape($this->title), escape($this->image_url), $this->published, escape($this->snippet), escape($this->body), $this->id);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        $this->id = mysqli_insert_id(Application::$DB_CONNECTION);
        return $res;
    }

    public function delete() {
        $sql = 'delete from entry where id = %d';
        $sql = sprintf($sql, $this->id);
        return mysqli_query(Application::$DB_CONNECTION, $sql);
    }

    public static function select_by_id($id) { 
        $sql = 'select id, title, image_url, published, snippet, body, created, updated from entry where id=%d';
        $sql = sprintf($sql, $id);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        if($res === FALSE || mysqli_num_rows($res) === 0) { 
            return NULL;
        }
        $entry = new entry();
        $entry->load(mysqli_fetch_array($res));
        return $entry;
    }

    public static function select($offset = 0) { 
        $sql = 'select id, title, image_url, published, snippet, null as body, created, updated from entry where published = 1 order by id desc limit %d, 25';
        $sql = sprintf($sql, $offset);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        if($res === FALSE || mysqli_num_rows($res) === 0) { 
            return array();
        }
        $array = array();
        while($row = mysqli_fetch_array($res)) {
            $entry = new entry();
            $entry->load($row);
            $array[] = $entry;
        }
        return $array;
    }
}

class session {
    public $id;
    public $code;
    public $created;

    public function load($row) {
        $this->id = intval($row['id']);
        $this->code = $row['code'];
        $this->created = $row['created'];
    }

    public function insert() {
        $sql = 'insert into session (code, created) values ("%s", UTC_TIMESTAMP())';
        $sql = sprintf($sql, escape($this->code), $this->id);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        $this->id = mysqli_insert_id(Application::$DB_CONNECTION);
        return $res;
    }

    public static function select_by_id($id) { 
        $sql = 'select id, code, created from session where id=%d';
        $sql = sprintf($sql, $id);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        if($res === FALSE || mysqli_num_rows($res) === 0) { 
            return NULL;
        }
        $session = new session();
        $session->load(mysqli_fetch_array($res));
        return $session;
    }

    public static function select_by_code($code) { 
        $sql = 'select id, code, created from session where code="%s"';
        $sql = sprintf($sql, escape($code));
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        if($res === FALSE || mysqli_num_rows($res) === 0) { 
            return NULL;
        }
        $session = new session();
        $session->load(mysqli_fetch_array($res));
        return $session;
    }
}

class setting {
    public $id;
    public $blog_name;
    public $email;
    public $display_name;
    public $password_hash;
    public $password_salt;

    public function load($row) {
        $this->id = intval($row['id']);
        $this->blog_name = $row['blog_name'];
        $this->email = $row['email'];
        $this->display_name = $row['display_name'];
        $this->password_hash = $row['password_hash'];
        $this->password_salt = $row['password_salt'];
    }

    public function insert() {
        $sql = 'insert into setting (blog_name, email, display_name, password_hash, password_salt) values ("%s", "%s", "%s", "%s", "%s")';
        $sql = sprintf($sql, escape($this->blog_name), escape($this->email), escape($this->display_name), escape($this->password_hash), escape($this->password_salt));
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        $this->id = mysqli_insert_id(Application::$DB_CONNECTION);
        return $res;
    }

    public function update() {
        $sql = 'update setting set blog_name = "%s", email = "%s", display_name = "%s", password_hash = "%s", password_salt = "%s" where id = %d';
        $sql = sprintf($sql, escape($this->blog_name), escape($this->email), escape($this->display_name), escape($this->password_hash), escape($this->password_salt), $this->id);
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        $this->id = mysqli_insert_id(Application::$DB_CONNECTION);
        return $res;
    }

    public function delete() {
        $sql = 'delete from setting where id = %d';
        $sql = sprintf($sql, $this->id);
        return mysqli_query(Application::$DB_CONNECTION, $sql);
    }

    public static function select_first() { 
        $sql = 'select id, blog_name, email, display_name, password_hash, password_salt from setting limit 0, 1';
        $res = mysqli_query(Application::$DB_CONNECTION, $sql);
        if($res === FALSE || mysqli_num_rows($res) === 0) { 
            return NULL;
        }
        $setting = new setting();
        $setting->load(mysqli_fetch_array($res));
        return $setting;
    }
}

Application::$DB_CONNECTION = mysqli_connect(
    Configuration::get_instance()->db->host,
    Configuration::get_instance()->db->username,
    Configuration::get_instance()->db->password,
    Configuration::get_instance()->db->database
);

?>