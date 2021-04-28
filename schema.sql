-- Создание БД
CREATE DATABASE taskforce
	DEFAULT CHARacter SET UTF8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE taskforce;

-- Тип пользователя
CREATE TABLE types (
    id INT AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    PRIMARY KEY (id)
);

-- Категории задач
CREATE TABLE categories (
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Статусы задач
CREATE TABLE statuses (
    id INT AUTO_INCREMENT,
    name VARCHAR (255) NOT NULL,
    PRIMARY KEY (id)
);

-- Список городов
CREATE TABLE cities (
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Пользователи
CREATE TABLE users (
    id INT AUTO_INCREMENT,
    dt_add DATETIME NOT NULL,
    name VARCHAR(255) NOT NULL,
    type_id INT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (type_id) REFERENCES types (id)
);

-- Задачи
CREATE TABLE tasks (
    id INT AUTO_INCREMENT,
    dt_add DATETIME NOT NULL,
    deadline DATETIME NOT NULL,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    city_id INT NOT NULL,
    status_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description VARCHAR(1000) NOT NULL,
    files VARCHAR(255) NOT NULL,
    cost INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (city_id) REFERENCES cities (id),
    FOREIGN KEY (status_id) REFERENCES statuses (id),
    INDEX tasks_name_idx (name),
    INDEX tasks_category_idx (category_id),
    INDEX tasks_user_idx (user_id),
    INDEX tasks_city_idx (city_id)
);

-- Отклики
CREATE TABLE responses (
    id INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    task_id INT NOT NULL,
    dt_add DATETIME,
    description VARCHAR(1000) NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    INDEX responses_user_idx (user_id),
    INDEX responses_task_idx (task_id)
);

-- Для полнотекстового поиска по имени задачи
CREATE FULLTEXT INDEX tasks_ft_search ON tasks(name);
