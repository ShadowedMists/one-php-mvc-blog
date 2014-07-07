<?php

class HomeController extends Controller {
    protected $page;

    public function index($page = 0) {
        $settings = $this->get_settings();
        $this->meta->title = $settings->blog_name;

        $page = intval($page);
        if($page < 0) {
            $page = 0;
        }
        $this->page = $page;
        $offset = $page * 25;

        $entries = entry::select($offset);
        $tags = tags_in_use::select_all();
        return $this->view(array('entries' => $entries, 'tags' => $tags));
    }
}

?>