# Админ панель пользователей на PHP

Сделано в качестве практического задания на курсе **PHP**

### Примененные технологии
* PHP, Bootstrap 5.3

### Реализованный функционал

* Авторизация.
* Роли пользователей и действия в зависимости от них.
* Добавление пользователей.
* Удаление пользователей.
* Просмотр профиля.        
* Редактирование профиля.
* Управление статусами.
* Управление аватарами.

## Как запустить проект:
1. Создать в MySQL базу db_main.
2. Создать таблицы:
CREATE TABLE `users` (
 `id` int NOT NULL AUTO_INCREMENT,
 `email` varchar(50) NOT NULL,
 `pass` varchar(100) NOT NULL,
 `role` varchar(10) NOT NULL DEFAULT 'user',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
CREATE TABLE `info` (
 `id` int NOT NULL AUTO_INCREMENT,
 `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `job_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Онлайн',
 `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `vk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `telegram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci
3. Поместить код в папку локального сервера localhost
4. Запустить файл users.php
