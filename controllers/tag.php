<?php

class TagController extends Controller {
    protected $page;
    protected $tag;

    public function index($tag = NULL, $page = 0) {
        if($tag === NULL) {
            $this->redirect(NULL, 'home');
        }

        $page = intval($page);
        if($page < 0) {
            $page = 0;
        }
        
        $this->page = $page;
        $this->tag = $tag;
        $offset = $page * 25;

        $entries = entry::select_by_tag($tag, $offset);
        return $this->view(array('entries' => $entries, 'tags' => array($tag)), 'index', 'home');
    }
}

?>