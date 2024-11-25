<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'usr_id';
    protected $allowedFields = [
        'email', 
        'password', 
        'is_active', 
        'usr_created_at', 
        'usr_updated_at', 
        'reset_token', 
        'reset_token_ecp'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'usr_created_at';
    protected $updatedField = 'usr_updated_at';

    /**
     * Constructeur
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ajoute un utilisateur
     * @param array $data Données de l'utilisateur à ajouter
     * @return int|false ID de l'utilisateur ajouté ou false en cas d'échec
     */
    public function add(array $data)
    {
        return $this->insert($data, true); // Retourne l'ID de l'utilisateur inséré
    }

    /**
     * Modifie un ou plusieurs champs d'un utilisateur
     * @param int $id ID de l'utilisateur
     * @param array $data Champs à mettre à jour
     * @return bool Succès ou échec de l'opération
     */
    public function upd(int $id, array $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Supprime un utilisateur
     * @param int $id ID de l'utilisateur
     * @return bool Succès ou échec de l'opération
     */
    public function del(int $id)
    {
        return $this->delete($id);
    }

    /**
     * Désactive un utilisateur
     * @param int $id ID de l'utilisateur
     * @return bool Succès ou échec de l'opération
     */
    public function unactive(int $id)
    {
        return $this->update($id, ['is_active' => false]);
    }

    /**
     * Active un utilisateur
     * @param int $id ID de l'utilisateur
     * @return bool Succès ou échec de l'opération
     */
    public function active(int $id)
    {
        return $this->update($id, ['is_active' => true]);
    }
}
