<?php

namespace App\Controllers;


class Test extends BaseController
{
    public function index()
    {
        return service('SmartyEngine')->view('index');
    }

    public function view($page = 'index')
    {
        echo (ucfirst($page));
        echo '->'.APPPATH . 'Views/test/' . $page . '.php<br/>';
        if (!is_file(APPPATH . 'Views/test/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page); // Capitalize the first letter

       echo view('test/' . $page, $data);
    }
}
