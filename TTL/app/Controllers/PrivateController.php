<?php

namespace App\Controllers;


class PrivateController extends BaseController
{
    public function index()
    {
        echo view('private_index');
    }

    public function view($page = 'private_index')
    {
        echo (ucfirst($page));
        echo '->'.APPPATH . 'Views/privates/' . $page . '.php<br/>';
        if (!is_file(APPPATH . 'Views/privates/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
        }
        
        $data['title'] = ucfirst($page); // Capitalize the first letter

       echo view('privates/' . $page, $data);
    }
}
