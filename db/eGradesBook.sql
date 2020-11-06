CREATE TABLE `admin` (
  `login` varchar(10) UNIQUE NOT NULL,
  `password` char(128) NOT NULL
);

CREATE TABLE `person` (
  `id` bigint(11) PRIMARY KEY,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `role_status` varchar(11) NOT NULL,
  `gender` ENUM ('male', 'female', 'other') NOT NULL,
  `tel` varchar(14) NOT NULL,
  `birth_date` date NOT NULL,
  `e_mail` varchar(30) NOT NULL,
  `city` varchar(10) NOT NULL,
  `code` int(4) NOT NULL,
  `street` varchar(20) NOT NULL,
  `house_nr` varchar(10) NOT NULL,
  `password` char(128) NOT NULL
);

CREATE TABLE `profiles` (
  `id` int(3) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(20) NOT NULL
);

CREATE TABLE `subjects` (
  `id_subject` varchar(20) UNIQUE NOT NULL
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
  `type` varchar(40) NOT NULL
);

CREATE TABLE `role_status` (
  `role_status` varchar(30) UNIQUE NOT NULL
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
  `id_subject` varchar(20) NOT NULL,
  `mark` ENUM ('1', '2', '3', '4', '5', '6') NOT NULL,
  `cat_id` int NOT NULL,
  `weight` ENUM ('1', '2', '3', '4', '5') NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `attendance` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_student` bigint(11) NOT NULL,
  `id_subject` varchar(20) NOT NULL,
  `type` ENUM ('present', 'absent', 'late', 'execused', 'unexecused'),
  `lesson_time_id` int(3) NOT NULL,
  `date` date NOT NULL
);

CREATE TABLE `events` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `id_class` int(3) NOT NULL,
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
  `id_class` int(3) NOT NULL,
  `id_subject` varchar(20) NOT NULL,
  `id_teacher` bigint(11) NOT NULL,
  `id_lesson_time` int(3) NOT NULL,
  `week_day` ENUM ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL
);

CREATE TABLE `student_class` (
  `id_student` bigint(11) NOT NULL,
  `id_class` int(3) NOT NULL
);

CREATE TABLE `teacher_subject` (
  `id_teacher` bigint(11) NOT NULL,
  `id_subject` varchar(20) NOT NULL
);

CREATE TABLE `supervisor_student` (
  `id_student` bigint(11) NOT NULL,
  `id_supervisor` bigint(11) NOT NULL
);

CREATE TABLE `message` (
  `id` int(10) PRIMARY KEY AUTO_INCREMENT,
  `title` varchar(20),
  `sender` bigint(11),
  `receiver` bigint(11),
  `content` text,
  `time` timestamp
);

ALTER TABLE `person` ADD FOREIGN KEY (`role_status`) REFERENCES `role_status` (`role_status`);

ALTER TABLE `classes` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`id_profile`) REFERENCES `profiles` (`id`);

ALTER TABLE `classes` ADD FOREIGN KEY (`years`) REFERENCES `years` (`years`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `marks` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id_subject`);

ALTER TABLE `marks` ADD FOREIGN KEY (`cat_id`) REFERENCES `marks_cat` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id_subject`);

ALTER TABLE `attendance` ADD FOREIGN KEY (`lesson_time_id`) REFERENCES `lesson_times` (`id`);

ALTER TABLE `events` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `notes` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `notes` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id_subject`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `class_subject` ADD FOREIGN KEY (`id_lesson_time`) REFERENCES `lesson_times` (`id`);

ALTER TABLE `student_class` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `student_class` ADD FOREIGN KEY (`id_class`) REFERENCES `classes` (`id`);

ALTER TABLE `teacher_subject` ADD FOREIGN KEY (`id_teacher`) REFERENCES `person` (`id`);

ALTER TABLE `teacher_subject` ADD FOREIGN KEY (`id_subject`) REFERENCES `subjects` (`id_subject`);

ALTER TABLE `supervisor_student` ADD FOREIGN KEY (`id_student`) REFERENCES `person` (`id`);

ALTER TABLE `supervisor_student` ADD FOREIGN KEY (`id_supervisor`) REFERENCES `person` (`id`);

ALTER TABLE `message` ADD FOREIGN KEY (`sender`) REFERENCES `person` (`id`);

ALTER TABLE `message` ADD FOREIGN KEY (`receiver`) REFERENCES `person` (`id`);


ALTER TABLE classes ADD CONSTRAINT class_year UNIQUE(name, years);
