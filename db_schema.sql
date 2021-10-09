-- Создание БД
CREATE DATABASE taskforce
    DEFAULT CHARacter SET UTF8
    DEFAULT COLLATE UTF8_GENERAL_CI;

USE taskforce;

-- Категории задач
CREATE TABLE categories
(
    id   INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,

    PRIMARY KEY (id)
);

-- Список городов
CREATE TABLE cities
(
    id        INT AUTO_INCREMENT,
    name      VARCHAR(255)   NOT NULL UNIQUE,
    latitude  DECIMAL(9, 7)  NOT NULL,
    longitude DECIMAL(10, 7) NOT NULL,
    PRIMARY KEY (id)
);

-- Таблица с файлами
CREATE TABLE files
(
    id   INT AUTO_INCREMENT,
    path VARCHAR(255) NOT NULL UNIQUE,
    PRIMARY KEY (id)
);

-- Пользователи
CREATE TABLE users
(
    id                       INT AUTO_INCREMENT,
    is_executor              TINYINT       NOT NULL default 0,
    dt_add                   DATETIME      NOT NULL,
    last_active_time         DATETIME      NULL,
    name                     VARCHAR(255)  NOT NULL,
    email                    VARCHAR(255)  NOT NULL UNIQUE,
    password                 VARCHAR(255)  NOT NULL,
    contacts                 VARCHAR(255)  NULL,
    phone                    VARCHAR(255)  NOT NULL,
    skype                    VARCHAR(255)  NOT NULL,
    other_contacts           VARCHAR(255)  NULL,
    birthday                 DATETIME      NOT NULL,
    about_me                 VARCHAR(1000) NOT NULL,

    notification_new_message TINYINT       NOT NULL default 0,
    notification_task_action TINYINT       NOT NULL default 0,
    notification_review      TINYINT       NOT NULL default 0,
    failed_count             INT           NOT NULL default 0,
    show_contacts            TINYINT       NOT NULL default 0,

    city_id                  INT           NOT NULL,
    avatar_file_id           INT           NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (city_id) REFERENCES cities (id),
    FOREIGN KEY (avatar_file_id) REFERENCES files (id)
);

-- Файлы пользователей
CREATE TABLE users_files
(
    id      INT AUTO_INCREMENT,
    user_id INT NOT NULL,
    file_id INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (file_id) REFERENCES files (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
);

-- Задачи
CREATE TABLE tasks
(
    id          INT AUTO_INCREMENT,
    dt_add      DATETIME      NULL,
    deadline    DATETIME      NOT NULL,
    user_id     INT           NOT NULL,
    executor_id INT           NULL,
    category_id INT           NOT NULL,
    city_id     INT           NOT NULL,
    status      TINYINT       NOT NULL,
    name        VARCHAR(255)  NOT NULL,
    description VARCHAR(1000) NOT NULL,
    cost        INT           NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id),
    FOREIGN KEY (city_id) REFERENCES cities (id),
    INDEX tasks_name_idx (name),
    INDEX tasks_category_idx (category_id),
    INDEX tasks_executor_idx (executor_id),
    INDEX tasks_city_idx (city_id)
);

-- Файлы задач
CREATE TABLE tasks_files
(
    id      INT AUTO_INCREMENT,
    task_id INT NOT NULL,
    file_id INT NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    FOREIGN KEY (file_id) REFERENCES files (id)
);

-- Сообщения
CREATE TABLE users_messages
(
    id           INT AUTO_INCREMENT,
    dt_add       DATETIME      NOT NULL,
    sender_id    INT           NOT NULL, -- отправитель
    recipient_id INT           NOT NULL, -- получатель
    text         VARCHAR(1000) NOT NULL,
    task_id      INT           NOT NULL,
    is_read      TINYINT       NOT NULL default 0,

    PRIMARY KEY (id),
    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (recipient_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

-- Отклики
CREATE TABLE responses
(
    id          INT AUTO_INCREMENT,
    dt_add      DATETIME,
    executor_id INT           NOT NULL,
    task_id     INT           NOT NULL,
    description VARCHAR(2000) NOT NULL,
    price       INT           NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id),
    INDEX responses_executor_idx (executor_id),
    INDEX responses_task_idx (task_id)
);

-- Отзывы
CREATE TABLE reviews
(
    id          INT AUTO_INCREMENT,
    dt_add      DATETIME,
    executor_id INT           NOT NULL,
    task_id     INT           NOT NULL,
    score       TINYINT       NULL default 0,
    text        TEXT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

-- Для полнотекстового поиска по имени задачи
CREATE FULLTEXT INDEX tasks_ft_search ON tasks (name);
