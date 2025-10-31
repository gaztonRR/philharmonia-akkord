CREATE DATABASE IF NOT EXISTS philharmonia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE philharmonia;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('user','admin') NOT NULL DEFAULT 'user'
);
INSERT INTO users (username,password,role) VALUES
('admin', MD5('12345'), 'admin')
ON DUPLICATE KEY UPDATE username = username;

CREATE TABLE IF NOT EXISTS performers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  genre VARCHAR(255) DEFAULT NULL,
  bio TEXT,
  photo VARCHAR(255) DEFAULT 'assets/img/placeholder.jpg'
);
INSERT INTO performers (name,genre,bio) VALUES
('Симфонический оркестр филармонии «Аккорд»','Симфоническая музыка','Постоянный коллектив.'),
('Квартет «Allegro»','Камерная музыка','Камерный ансамбль.'),
('Хоровая капелла города','Хоровое пение','Праздничные концерты.');

CREATE TABLE IF NOT EXISTS concerts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  time TIME NOT NULL,
  hall VARCHAR(255) DEFAULT 'Большой зал',
  price DECIMAL(8,2) DEFAULT 0,
  performer_id INT DEFAULT NULL,
  description TEXT,
  image VARCHAR(255) DEFAULT 'assets/img/placeholder.jpg',
  FOREIGN KEY (performer_id) REFERENCES performers(id) ON DELETE SET NULL
);
INSERT INTO concerts (title,date,time,hall,price,performer_id,description) VALUES
('Открытие сезона «Аккорд»','2025-11-10','19:00:00','Большой зал',1200,1,'Торжественное открытие концертного сезона.'),
('Вечер камерной музыки','2025-11-15','18:30:00','Малый зал',900,2,'Квартеты и дуэты.'),
('Симфоническая классика','2025-11-20','19:00:00','Большой зал',1500,1,'Чайковский, Рахманинов.'),
('Музыка кино','2025-11-25','19:30:00','Большой зал',1100,NULL,'Популярные темы из кинофильмов.'),
('Рождественский концерт','2025-12-05','18:00:00','Малый зал',800,3,'Хоровые обработки и рождественские песни.'),
('Джаз-вечер','2025-12-12','20:00:00','Камерный зал',1000,NULL,'Лёгкий джаз и импровизации.');

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  concert_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  email VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (concert_id) REFERENCES concerts(id) ON DELETE CASCADE
);
