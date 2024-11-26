drop table if EXISTS projects;
drop table if EXISTS notifications;
drop table if EXISTS comments;
drop table if EXISTS priority;
drop table if EXISTS tasks;
drop table if EXISTS users;



-- Table : users
CREATE TABLE users (
    usr_id SERIAL PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT FALSE,
    usr_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usr_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    reset_token INT,
    reset_token_exp TIMESTAMP
);

-- Table : Projet
CREATE TABLE projects (
    prj_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    prj_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    prj_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table : priority
CREATE TABLE priority (
    prio_id SERIAL PRIMARY KEY,
    tsk_id INT REFERENCES tasks(tsk_id) ON DELETE CASCADE,
    ordre INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    color VARCHAR(7) -- Hexadecimal code (e.g., #FF5733)
);
-- Table : tasks
CREATE TABLE tasks (
    tsk_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    project_id INT REFERENCES projects(prj_id) ON DELETE CASCADE,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATE,
    tsk_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tsk_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);


-- Table : comments
CREATE TABLE comments (
    cmt_id SERIAL PRIMARY KEY,
    tsk_id INT REFERENCES tasks(tsk_id) ON DELETE CASCADE,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    cmt_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cmt_updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);

CREATE type notification_type AS ENUM('reminder', 'account_activation', 'password_reset');
CREATE type notification_status AS ENUM('pending', 'sent', 'failed');

-- Table : notifications
CREATE TABLE notifications (
    notif_id SERIAL PRIMARY KEY,
    usr_id INT REFERENCES users(usr_id) ON DELETE CASCADE,
    type notification_type NOT NULL,
    statut notification_status NOT NULL,
    notif_created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

