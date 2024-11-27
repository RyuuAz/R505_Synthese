<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectUserModel extends Model
{
    protected $table = 'project_user';
    protected $primaryKey = false; // Pas de clé primaire auto-générée (clé primaire composite)
    protected $allowedFields = [
        'prj_id',
        'usr_id'
    ];
    public $timestamps = false; // Pas de gestion automatique des timestamps

    /**
     * Associe un utilisateur à un projet
     * @param int $userId ID de l'utilisateur
     * @param int $projectId ID du projet
     * @return bool Succès ou échec
     */
    public function addUserToProject(int $userId, int $projectId)
    {
        return $this->insert([
            'usr_id' => $userId,
            'prj_id' => $projectId
        ]);
    }

    /**
     * Supprime l'association entre un utilisateur et un projet
     * @param int $userId ID de l'utilisateur
     * @param int $projectId ID du projet
     * @return bool Succès ou échec
     */
    public function removeUserFromProject(int $userId, int $projectId)
    {
        return $this->where('usr_id', $userId)
                    ->where('prj_id', $projectId)
                    ->delete();
    }

    /**
     * Vérifie si un utilisateur est associé à un projet
     * @param int $userId ID de l'utilisateur
     * @param int $projectId ID du projet
     * @return bool Vrai si l'association existe
     */
    public function isUserInProject(int $userId, int $projectId)
    {
        return $this->where('usr_id', $userId)
                    ->where('prj_id', $projectId)
                    ->countAllResults() > 0;
    }
}
