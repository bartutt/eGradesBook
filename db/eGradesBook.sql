CREATE TABLE `person` (
  `id` bigint(11) PRIMARY KEY,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `role_status_id` int(3) NOT NULL,
  `gender` ENUM ('male', 'female', 'other') NOT NULL,
  `tel` varchar(14) NOT NULL,
  `birth_date` date NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `city` varchar(10) NOT NULL,
  `code` int(4) NOT NULL,
  `street` varchar(20) NOT NULL,
  `house_nr` varchar(10) NOT NULL,
  `password` char(128) NOT NULL,
  `added_date` timestamp NOT NULL
);

CREATE TABLE `profiles` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20) NOT NULL
);

CREATE TABLE `subjects` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20) UNIQUE NOT NULL
);

CREATE TABLE `lesson_times` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `time` varchar(11) NOT NULL
);

CREATE TABLE `years` (
  `years` varchar(9) PRIMARY KEY,
  `current_year` varchar(9) NOT NULL
);

CREATE TABLE `marks_cat` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(40) NOT NULL
);

CREATE TABLE `role_status` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(30) UNIQUE NOT NULL
);

CREATE TABLE `classes` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `id_teacher` bigint(11) NOT NULL,
  `id_profile` int(3) NOT NULL,
  `years` varchar(9) NOT NULL
);

CREATE TABLE `marks` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_student` bigint(11) NOT NULL,
  `id_teacher` bigint(11) NOT NULL,
  `id_subject` int(3) NOT NULL,
  `mark` ENUM ('1', '2', '3', '4', '5', '6') NOT NULL,
  `cat_id` int NOT NULL,
  `weight` ENUM ('1', '2', '3', '4', '5') NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `attendance` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_student` bigint(11) NOT NULL,
  `id_subject` int(3) NOT NULL,
  `type` ENUM ('present', 'absent', 'late', 'execused', 'unexecused'),
  `lesson_time_id` int(3) NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `events` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_class` int(3) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `notes` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_student` bigint(11) NOT NULL,
  `id_teacher` bigint(11) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `class_subject` (
  `id_class` int(3),
  `id_subject` int(3),
  `id_teacher` bigint(11),
  `id_lesson_time` int(3),
  `week_day` ENUM ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL
);

CREATE TABLE `student_class` (
  `id_student` bigint(11) NOT NULL,
  `id_class` int(3) NOT NULL
);

CREATE TABLE `teacher_subject` (
  `id_teacher` bigint(11) NOT NULL,
  `id_subject` int(3) NOT NULL
);

CREATE TABLE `supervisor_student` (
  `id_student` bigint(11) NOT NULL,
  `id_supervisor` bigint(11) NOT NULL
);

CREATE TABLE `information_board` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(20),
  `content` text,
  `time_when` date,
  `time_added` timestamp
);

ALTER TABLE `person` ADD FOREIGN KEY (`role_status_id`) REFERENCES `role_status` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`id_profile`) REFERENCES `profiles` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`years`) REFERENCES `years` (`years`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `marks` ADD FOREIGN KEY (`cat_id`) REFERENCES `marks_cat` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`lesson_time_id`) REFERENCES `lesson_times` (`id`);

ALTER TABLE `events` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `notes` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `notes` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_lesson_time`) REFERENCES `lesson_times` (`id`);

ALTER TABLE `student_class` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `student_class` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `teacher_subject` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `teacher_subject` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id`);

ALTER TABLE `supervisor_student` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `supervisor_student` ADD FOREIGN KEY (`id_supervisor`) REFERENCES `person` (`id`);

ALTER TABLE student_class ADD CONSTRAINT student_class UNIQUE(id_student, id_class);

ALTER TABLE classes ADD CONSTRAINT class_year UNIQUE(name, years);

ALTER TABLE teacher_subject ADD CONSTRAINT teacher_subject UNIQUE(id_teacher, id_subject);

ALTER TABLE supervisor_student ADD CONSTRAINT spr_st UNIQUE (id_student,id_supervisor);

ALTER TABLE class_subject ADD CONSTRAINT lesson UNIQUE (id_class,id_lesson_time,week_day);

ALTER TABLE attendance ADD CONSTRAINT attendance UNIQUE (id_student, id_subject, lesson_time_id, date);

INSERT INTO `lesson_times` (`id`, `time`) VALUES (NULL, '08.15-9.00'), (NULL, '09.10-9.55'), (NULL, '10.05-10.50'), (NULL, '11.00-11-45'), (NULL, '12.05-12.50'), (NULL, '13.00-13-45'), (NULL, '13.55-14.40'), (NULL, '14.50-15.35'), (NULL, '15.45-16.30');
INSERT INTO `role_status` (`id`, `name`) VALUES (NULL, 'admin'), (NULL, 'parent'), (NULL, 'teacher'), (NULL, 'student'), (NULL, 'graduated');
INSERT INTO `person` (`id`, `name`, `surname`, `role_status_id`, `gender`, `tel`, `birth_date`, `e_mail`, `city`, `code`, `street`, `house_nr`, `password`, `added_date`) VALUES ('11111111111', 'Admin', 'Admin', '1', 'male', '', '2020-12-24', 'bw@gm.com', 'London', '1234', 'Long', '2', '$2y$10$Tvd5t0ZSa5pDd/hy7.o2ouyadWvO6xUP8WzWuKikqYtiRN.YgF/1G', current_timestamp());
INSERT INTO `years` (`years`, `current_year`) VALUES ('2020/2021', '2020/2021');
INSERT INTO `marks_cat` (`id`, `name`) VALUES (NULL, 'exam'), (NULL, 'group project');
INSERT INTO `subjects` (`id`, `name`) VALUES (NULL, 'biology'), (NULL, 'maths'), (NULL, 'art'), (NULL, 'chemistry'), (NULL, 'english');
INSERT INTO `profiles` (`id`, `name`) VALUES (NULL, 'sport'), (NULL, 'maths and physics');