<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo view('common/head');
        echo view('common/foot');
    }
}
?>