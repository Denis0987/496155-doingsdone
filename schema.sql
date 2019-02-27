CREATE DATABASE doingsdone
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

create table users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128) NOT NULL,
	email CHAR(128) NOT NULL ,
	password CHAR(64) NOT NULL,
	reg_date DATETIME NOT NULL DEFAULT NOW()
);

create table projects (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title_project CHAR(128),
	user_id INT NOT NULL
);

create table tasks (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title_task CHAR(128) NOT NULL,
	creation_at DATETIME DEFAULT NOW(),
	deadline DATETIME,
	done_at DATETIME,
	file_task CHAR(128),
	project_id INT NOT NULL,
	user_id INT NOT NULL
);

CREATE UNIQUE INDEX email ON users(email);
CREATE UNIQUE INDEX getProject ON projects(title_project, user_id);
CREATE INDEX doneTask ON tasks(user_id, project_id);
