<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo view('common/head');
        echo view('dashboard/onglet', [
            'title' => 'Dashboard',
            'userProfile' => [
                'name' => 'John Doe',
                'email' => 'john@example.com'
            ]
        ]);

        echo view('dashboard/component/case', [
            'nomTache' => 'Tâche 1',
            'dateTache' => '01/01/2022',
            'commentaires' => '<li>Commentaire 1</li><li>Commentaire 2</li>'
        ]);
                
        echo view('common/foot');
    }
}
?>