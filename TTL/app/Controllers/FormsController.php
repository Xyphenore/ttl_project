<?php

namespace App\Controllers;


class FormsControllers extends BaseController
{
    public function index()
    {
        return service('SmartyEngine')->view('index');
    }

    public function view($page = 'index')
    {
        echo (ucfirst($page));
        echo '->'.APPPATH . 'Views/forms/' . $page . '.php<br/>';
        if (!is_file(APPPATH . 'Views/forms/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page); // Capitalize the first letter

       echo view('forms/' . $page, $data);
    }
}