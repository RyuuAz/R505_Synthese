# Système de Gestion des Tâches (SGT)

## Description

Le **Système de Gestion des Tâches (SGT)** est une application web permettant de gérer les utilisateurs, les projets, les tâches et les priorités de manière collaborative et intuitive. L'application permet aux utilisateurs de créer des projets, d'ajouter des tâches avec des priorités, de commenter et de suivre l'avancement des tâches.

L'application est construite avec **CodeIgniter 4** en utilisant une architecture **MVC**, et le front-end est basé sur **Bootstrap 5** pour une interface fluide et responsive.

## Fonctionnalités principales

- **Gestion des utilisateurs** : Inscription, connexion, réinitialisation du mot de passe, activation du compte.
- **Gestion des projets** : Création, modification, suppression, et ajout d’utilisateurs à un projet.
- **Gestion des tâches** : Création, modification, suppression, tri et filtrage des tâches.
- **Priorités** : Gestion des priorités pour chaque tâche avec des couleurs et un ordre de priorité.
- **Commentaires** : Ajout de commentaires sur les tâches, tri et pagination des commentaires.
- **Notifications** : Notifications par email pour les rappels des échéances et autres événements importants.
- **Interface utilisateur** : Design responsive utilisant **Bootstrap 5** avec des pop-ups pour gérer les entités (tâches, projets, priorités) et le **drag and drop** pour réorganiser les éléments.

## Technologies utilisées

- **PHP** : 7.4 ou supérieur
- **CodeIgniter 4** : 4.x
- **Bootstrap** : 5.x
- **PostgreSQL** : 13.x (ou version supérieure)
- **Email** : Utilisation de PHP mail() ou de services externes comme SendGrid pour l'envoi des emails de notification.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé les outils suivants :

- **PHP** 7.4 ou supérieur
- **PostgreSQL** pour la gestion de la base de données

## Installation

### Clonez le dépôt
```bash
git clone https://github.com/RyuuAz/R505_Synthese.git
```

### Base de données
- adapter le fichier ```/app/Config/Database.php``` à votre base de données
- lancer le fichier ```create.sql``` dans votre base de données

### Base de données
- adapter le fichier ```/app/Config/Email.php``` à votre adresse mail

### Lancer le serveur
```bash
php spark serve
```
