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

/**
 * @var RouteCollection $routes
 */
//$routes->get('/', 'Home::index');

$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->get('/forgot_password', 'AuthController::forgotPassword');
$routes->get('/reset_password/(:alphanum)', 'AuthController::resetPassword/$1');
$routes->get('/active_account/(:alphanum)', 'AuthController::activeAccount/$1');
$routes->post('/login', 'AuthController::processLogin');
$routes->post('/register', 'AuthController::processRegister');
$routes->post('/forgot_password', 'AuthController::sendResetLink');
$routes->post('/reset_password', 'AuthController::updatePassword');

$routes->group('', ['filter' => 'auth'], function ($routes) {

	$routes->get('/database', 'DatabaseController::index'); // Affichage de toutes les tables
	$routes->get('/database/edit/(:any)/(:num)', 'DatabaseController::edit/$1/$2'); // Modifier un élément
	$routes->post('/database/update/(:any)/(:num)', 'DatabaseController::update/$1/$2'); // Mettre à jour un élément
	$routes->get('/database/delete/(:any)/(:num)', 'DatabaseController::delete/$1/$2'); // Supprimer un élément

	$routes->get('/dashboard', 'DashboardController::index');
	$routes->post('/dashboard/addproject', 'DashboardController::addProject');
	$routes->post('/dashboard/addLoneTask', 'DashboardController::addLoneTask');
	$routes->get('/dashboard/deleteLoneTask/(:num)', 'DashboardController::deleteLoneTask/$1');
	$routes->post('settings/UpdateLoneTask/(:num)', 'DashboardController::UpdateLoneTask/$1');
	$routes->get('/task/edit/(:num)', 'TaskController::edit/$1');
	$routes->post('/task/update/(:num)', 'TaskController::update/$1');
	$routes->get('/logout', 'AuthController::logout');
	$routes->get('settings', 'SettingsController::index');
	$routes->post('settings/create-priority', 'SettingsController::createPriority');
	$routes->get('settings/delete-priority/(:num)', 'SettingsController::deletePriority/$1');
	$routes->post('settings/update-priority/(:num)', 'SettingsController::updatePriority/$1');

	// Routes pour affichages
	$routes->get('projects', 'ProjectController::index');
	$routes->get('tasks', 'TaskController::index');
	$routes->get('AllTasks', 'TaskController::showAllTasks');

	// Routes pour UserController
	$routes->get('users', 'UserController::index'); // Liste des utilisateurs
	$routes->post('users/update', 'UserController::update'); // Mise à jour d'un utilisateur
	$routes->post('users/delete', 'UserController::deleteAccount'); // Suppression d'un utilisateur
	$routes->get('users/activate/(:num)', 'UserController::activate/$1'); // Activation d'un utilisateur
	$routes->get('users/deactivate/(:num)', 'UserController::deactivate/$1'); // Désactivation d'un utilisateur

	// Routes pour ProjectController
	$routes->get('projects/create', 'ProjectController::create'); // Formulaire de création de projet
	$routes->post('projects/store', 'ProjectController::store'); // Traitement de la création
	$routes->get('projects/delete/(:num)', 'ProjectController::delete/$1'); // Suppression d'un projet
	$routes->get('projects/view/(:num)', 'ProjectController::getProjectById/$1'); // Liste des projets d'un utilisateur
	$routes->post('ajouterTacheProjet', 'ProjectController::addTaskForProject'); // Ajout d'une tâche à un projet

	// Routes pour TaskController
	$routes->get('/singleTasks', 'TaskController::showSingleTask'); // Liste des tâches
	$routes->get('/tasks', 'TaskController::showAllTasks'); // Formulaire de modification de tâche
	$routes->get('task/create', 'TaskController::create'); // Formulaire de création de tâche
	$routes->post('task/store', 'TaskController::store'); // Traitement de la création
	$routes->post('/task/update', 'TaskController::update'); // Suppression d'une tâche
	$routes->post('updateTaskStatus', 'TaskController::updateTaskStatus'); // Met à jour le statut d'une tâche
	$routes->get('tasks/delay-tasks', 'TaskController::delayTaskFilter');
	$routes->get('tasks/priority-tasks', 'TaskController::priorityTaskFilter');
	$routes->get('tasks/due-date-tasks', 'TaskController::tasksByDueDate');
	$routes->get('tasks/all-tasks', 'TaskController::allTasks');
	$routes->post('task/delete/(:num)', 'TaskController::delete/$1');// Suppression d'une tâche
	$routes->post('task/delete', 'TaskController::deleteBasic'); // Suppression d'une tâche

	// Routes pour PriorityController
	$routes->get('priorities/create', 'PriorityController::create'); // Formulaire de création de priorité
	$routes->post('priorities/store', 'PriorityController::store'); // Traitement de la création
	$routes->get('priorities/delete/(:num)', 'PriorityController::delete/$1'); // Suppression d'une priorité

	// Routes pour CommentController
	$routes->get('comments/create', 'CommentController::create'); // Formulaire d'ajout de commentaire
	$routes->post('comments/store', 'CommentController::store'); // Traitement de l'ajout
	$routes->post('comments/update/(:num)', 'CommentController::update/$1'); // Mise à jour d'un commentaire
	$routes->post('/comments/delete/(:num)', 'CommentController::delete/$1'); // Suppression d'un commentaire

	// Routes pour NotificationController
	$routes->get('notifications/create', 'NotificationController::create'); // Formulaire de création de notification
	$routes->post('notifications/store', 'NotificationController::store'); // Traitement de la création
	$routes->get('notifications/delete/(:num)', 'NotificationController::delete/$1'); // Suppression d'une notification
});
