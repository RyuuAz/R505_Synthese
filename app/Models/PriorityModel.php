<?php

namespace App\Models;

use CodeIgniter\Model;

class PriorityModel extends Model
{
    protected $table = 'priority';
    protected $primaryKey = 'prio_id';
    protected $allowedFields = [
        'ordre',
        'name',
        'color',
        'tsk_id'
    ];

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute une priorité
     * @param array $data Données de la priorité à ajouter
     * @return int|false ID de la priorité ajoutée ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID de la priorité insérée
    }

    /**
     * Modifie un ou plusieurs champs de la priorité
     * @param int $id ID de la priorité
     * @param array $data Champs à mettre à jour
     * @return bool Succès ou échec de l'opération
     */
    public function upd(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprime une priorité
     * @param int $id ID de la priorité
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }

    /**
     * Récupère toutes les priorités d'un utilisateur
     * @param int $userId ID de l'utilisateur
     * @return array Liste des priorités
     */
    public function getPrioritiesByUser(int $userId)
    {
        return $this->where('usr_id', $userId)->orderBy('ordre', 'ASC')->findAll();
    }
}
