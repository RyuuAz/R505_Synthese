-- Supprimer les tables dans l'ordre inverse des dépendances
DROP TABLE IF EXISTS notifications CASCADE;

DROP TABLE IF EXISTS comments CASCADE;

DROP TABLE IF EXISTS priority CASCADE;

DROP TABLE IF EXISTS tasks CASCADE;

DROP TABLE IF EXISTS project_user CASCADE;

DROP TABLE IF EXISTS project CASCADE;

DROP TABLE IF EXISTS users CASCADE;

-- Supprimer les types ENUM
DROP TYPE IF EXISTS task_status CASCADE;

DROP TYPE IF EXISTS notification_type CASCADE;

DROP TYPE IF EXISTS notification_status CASCADE;

-- Création des types ENUM pour les statuts des tâches et des projets
CREATE TYPE task_status AS ENUM ('pending', 'completed', 'overdue');

-- Création des types ENUM pour les notifications
CREATE TYPE notification_type AS ENUM (
    'reminder',
    'account_activation',
    'password_reset'
);

CREATE TYPE notification_status AS ENUM ('pending', 'sent', 'failed');

-- Table users
CREATE TABLE users (
    usr_id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    usr_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usr_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reset_token VARCHAR(255),
    reset_token_exp TIMESTAMP
);

-- Table projects
CREATE TABLE project (
    prj_id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    prj_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    prj_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table project_user (relation entre utilisateurs et projets)
CREATE TABLE project_user (
    prj_id INT REFERENCES project(prj_id) ON DELETE CASCADE,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    PRIMARY KEY (prj_id, usr_id) -- Clé primaire composée
);

-- Table priority
CREATE TABLE priority (
    prio_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    ordre INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    color VARCHAR(7) NOT NULL -- Hexadecimal code (e.g., #FF5733)
);

-- Table tasks
CREATE TABLE tasks (
    tsk_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    prj_id INT REFERENCES project(prj_id) ON DELETE CASCADE,
    prio_id INT REFERENCES priority(prio_id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    status task_status DEFAULT 'pending',
    tsk_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tsk_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table comments
CREATE TABLE comments (
    cmt_id SERIAL PRIMARY KEY,
    tsk_id INT REFERENCES tasks(tsk_id) ON DELETE CASCADE,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    cmt_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cmt_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table notifications
CREATE TABLE notifications (
    notif_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    type notification_type NOT NULL,
    status notification_status DEFAULT 'pending',
    notif_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);