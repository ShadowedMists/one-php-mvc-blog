<?php

class EntryController extends Controller {

    public function index($id = NULL) {
        if(empty($id)) {
            $this->redirect(NULL, "home");
        }
        
        $settings = $this->get_settings();

        $entry = entry::select_by_id($id);
        if($entry === NULL) {
            $this->not_found();
        }
        if($entry->published === 0) {
            $this->gone();
        }
        
        $this->meta->title = $entry->title . ' - ' . $settings->blog_name;
        $this->meta->description = $entry->snippet;
        if(!empty($entry->image_url)) {
            $this->meta->image = $entry->image_url;
        }
        $this->view($entry);
    }

    public function edit($id = NULL) {
        if($this->get_session() === NULL) {
            $this->redirect(NULL, 'home');
        }

        $model = array(
            'id' => $this->post('id'),
            'title' => $this->post('title'),
            'image_url' => $this->post('image_url'),
            'published' => array_key_exists('published', $_POST) ? 1 : 0,
            'snippet' => $this->post('snippet'),
            'body' => $this->post('body'),
            'error' => NULL
        );

        if(array_key_exists('submit', $_POST)) {
            $req = array();
            if(empty($model['title'])) {
                $req[] = 'Title';
            }
            if(empty($model['snippet'])) {
                $req[] = 'Snippet';
            }
            if(empty($model['body'])) {
                $req[] = 'Entry';
            }
            if(!empty($req)) {
                $model['error'] = 'Please enter the required fields: ' . implode(', ', $req);
                return $this->view($model);
            }

            $entry = NULL;
            if(empty($model['id'])) {
                $entry = new entry();
            }
            else {
                $entry = entry::select_by_id($model['id']);
                if($entry === NULL) {
                    $this->not_found();
                }
                if($entry === FALSE) {
                    $model['error'] = 'Failed to load entry: ' . last_error();
                    return $this->view($model);
                }
            }

            $entry = new entry();
            $entry->title = $model['title'];
            $entry->image_url = $model['image_url'];
            $entry->published = $model['published'];
            $entry->snippet = $model['snippet'];
            $entry->body = $model['body'];
            
            $res = empty($entry->id) ? $entry->insert() : $entry->update();
            $model['error'] = $res ? 'Saved successfully.' : 'Failed to save entry: ' . last_error(); 
        }
        else {
            if(!empty($id)) {
                $entry = entry::select_by_id($id);
                if($entry === NULL) {
                    $this->not_found();
                }
                if($entry === FALSE) {
                    $model['error'] = 'Unable to load entry: ' . last_error();
                }
                else {
                    $model['id'] = $entry->id;
                    $model['title'] = $entry->title;
                    $model['inage_url'] = $entry->image_url;
                    $model['published'] = $entry->published;
                    $model['snippet'] = $entry->snippet;
                    $model['body'] = $entry->body;
                }
            } 
        }

        $this->view($model);
    }

    public function preview($id) {
        if($this->get_session() === NULL) {
            $this->redirect(NULL, 'home');
        }

        if(empty($id)) {
            $this->not_found();
        }
        
        $entry = entry::select_by_id($id);
        if($entry === NULL) {
            $this->not_found();
        }

        $this->meta->title = $entry->title . ' - Preview';
        $this->view($entry, 'index');
    }

    public function delete($id) {
        if($this->get_session() === NULL) {
            $this->redirect(NULL, 'home');
        }

        if(empty($id)) {
            $this->not_found();
        }
        
        $entry = entry::select_by_id($id);
        if($entry === NULL) {
            $this->not_found();
        }
        
        $model = array(
            'entry' => $entry, 
            'error' => NULL
        );

        if(array_key_exists('submit', $_POST)) {
            if(!$entry->delete()) {
                $model['error'] = 'Failed to delete entry: ' . last_error();
            }
            else {
                $this->redirect('blog', 'admin');
            }
        }

        $this->meta->title = 'Delete Blog Entry';
        $this->view($model);
    }
}

?>