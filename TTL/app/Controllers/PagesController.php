<?php

namespace App\Controllers;


class PagesController extends BaseController
{
    public function index()
    {
        return service('SmartyEngine')->view('index');
    }

    public function view($page = 'index')
    {
        echo (ucfirst($page));
        echo '->'.APPPATH . 'Views/pages/' . $page . '.php<br/>';
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page); // Capitalize the first letter

       echo view('pages/' . $page, $data);
    }
}
