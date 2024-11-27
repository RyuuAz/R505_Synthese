<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'cmt_id';
    protected $allowedFields = [
        'tsk_id',
        'usr_id',
        'content',
        'cmt_created_at',
        'cmt_updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'cmt_created_at';
    protected $updatedField = 'cmt_updated_at';

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute un commentaire
     * @param array $data Données du commentaire à ajouter
     * @return int|false ID du commentaire ajouté ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID du commentaire inséré
    }

    /**
     * Supprime un commentaire
     * @param int $id ID du commentaire
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }

    /**
     * Récupère tous les commentaires d'une tâche
     * @param int $taskId ID de la tâche
     * @return array Liste des commentaires
     */
    public function getCommentsByTask(int $taskId)
    {
        return $this->where('tsk_id', $taskId)->findAll();
    }
}
