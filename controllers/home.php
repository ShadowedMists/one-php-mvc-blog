<?php

class HomeController extends Controller {
    protected $page;

    public function index($page = 0) {
        if($page < 0) {
            $page = 0;
        }
        $this->page = $page;
        $offset = $page * 25;

        $entries = entry::select($offset);
        return $this->view($entries);
    }
}

?>