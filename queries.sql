USE doingsdone;

INSERT INTO users (name, email, password, reg_date)
VALUES
('Bob', 'chief@bob_soc.com', md5('qwerty'), NOW()), -- 1
('Юзер', 'User@userforum.com', md5('qwerty'), NOW()); -- 2

INSERT INTO projects (title_project, user_id)
VALUES
('Входящие', 1), -- 1
('Учеба',    2), -- 2
('Работа',   1), -- 3
('Домашние дела', 2), -- 4
('Авто',     2); -- 5

INSERT INTO tasks (title_task, creation_at, deadline, done_at, file_task, project_id, user_id)
VALUES
('Собеседование в IT компании', NOW(), null, '2019-12-01', 'Home.psd', 3, 1), -- 1
('Выполнить тестовое задание', NOW(), null, '2019-12-25', 'Home.psd', 3, 1), -- 2
('Сделать задание первого раздела', NOW(), '2019-12-21', '2019-12-22', 'Home.psd', 2, 2), -- 3
('Встреча с другом', NOW(), null, '2018-12-22', 'Home.psd', 1, 1), -- 4
('Купить корм для кота', NOW(), null, '2019-02-09', 'Home.psd', 4, 2), -- 5
('Заказать пиццу', NOW(), null, '2019-02-10', 'Home.psd', 4, 2); -- 6

-- получить список из всех проектов для одного пользователя
SELECT id, title_project
  FROM projects
 WHERE user_id = 1;

-- получить список из всех задач для одного проекта
SELECT title_task, file_task, done_at, deadline, project_id
  FROM tasks  where project_id = 1;

-- обновить название задачи по её идентификатору
UPDATE tasks SET title_task = 'Купить корм для зайца'
WHERE id = 5;

