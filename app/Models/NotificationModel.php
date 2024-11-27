<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notif_id';
    protected $allowedFields = [
        'usr_id', 
        'type', 
        'status', 
        'notif_created_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'notif_created_at';

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute une notification
     * @param array $data Données de la notification à ajouter
     * @return int|false ID de la notification ajoutée ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID de la notification insérée
    }

    /**
     * Supprime une notification
     * @param int $id ID de la notification
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }
}
