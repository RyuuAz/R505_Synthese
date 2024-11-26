<?php

use CodeIgniter\Router\RouteCollection;
/*
// Charge les paramètres système par défaut
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // Désactive l'autoroute pour plus de sécurité
*/

// Routes par défaut
$routes->get('/', 'Home::index');

// Routes pour UserController
$routes->get('users/register', 'UserController::register'); // Formulaire d'inscription
$routes->post('users/store', 'UserController::store'); // Traitement de l'inscription
$routes->get('users/delete/(:num)', 'UserController::delete/$1'); // Suppression d'un utilisateur
$routes->get('users/activate/(:num)', 'UserController::activate/$1'); // Activation d'un utilisateur
$routes->get('users/deactivate/(:num)', 'UserController::deactivate/$1'); // Désactivation d'un utilisateur

// Routes pour ProjectController
$routes->get('projects/create', 'ProjectController::create'); // Formulaire de création de projet
$routes->post('projects/store', 'ProjectController::store'); // Traitement de la création
$routes->get('projects/delete/(:num)', 'ProjectController::delete/$1'); // Suppression d'un projet
$routes->get('projects/user/(:num)', 'ProjectController::listByUser/$1'); // Liste des projets d'un utilisateur

// Routes pour TaskController
$routes->get('tasks/create', 'TaskController::create'); // Formulaire de création de tâche
$routes->post('tasks/store', 'TaskController::store'); // Traitement de la création
$routes->get('tasks/delete/(:num)', 'TaskController::delete/$1'); // Suppression d'une tâche
$routes->get('tasks/user/(:num)', 'TaskController::listByUser/$1'); // Tâches d'un utilisateur
$routes->get('tasks/project/(:num)', 'TaskController::listByProject/$1'); // Tâches d'un projet
$routes->get('tasks/user-without-project/(:num)', 'TaskController::listByUserWithoutProject/$1'); // Tâches d'un utilisateur sans projet
$routes->get('tasks/show/(:num)', 'TaskController::show/$1'); // Affiche les commentaires d'une tâche

// Routes pour PriorityController
$routes->get('priorities/create', 'PriorityController::create'); // Formulaire de création de priorité
$routes->post('priorities/store', 'PriorityController::store'); // Traitement de la création
$routes->get('priorities/delete/(:num)', 'PriorityController::delete/$1'); // Suppression d'une priorité

// Routes pour CommentController
$routes->get('comments/create', 'CommentController::create'); // Formulaire d'ajout de commentaire
$routes->post('comments/store', 'CommentController::store'); // Traitement de l'ajout
$routes->get('comments/delete/(:num)', 'CommentController::delete/$1'); // Suppression d'un commentaire

// Routes pour NotificationController
$routes->get('notifications/create', 'NotificationController::create'); // Formulaire de création de notification
$routes->post('notifications/store', 'NotificationController::store'); // Traitement de la création
$routes->get('notifications/delete/(:num)', 'NotificationController::delete/$1'); // Suppression d'une notification