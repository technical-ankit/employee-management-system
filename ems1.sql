CREATE DATABASE IF NOT EXISTS ems1;
USE ems1;

CREATE TABLE users(
 id INT AUTO_INCREMENT PRIMARY KEY,
 email VARCHAR(100) UNIQUE,
 password VARCHAR(255),
 role ENUM('admin','hr','employee'),
 name VARCHAR(100)
);

INSERT INTO users(email,password,role,name) VALUES
('admin@ems.com', '$2y$10$Z6iTnMGlRz1G0YI8lMP3aerf8IQT2Y.YO4UPe5V1zP4ViEz9xq8te', 'admin','Admin User'),
('hr@ems.com', '$2y$10$hpDR.y3b5LQk9q7T/EhTMeNEAErTwTCtuYv/XujqkoMC9wlEQqOyi', 'hr','HR User'),
('emp@ems.com', '$2y$10$sX/N9aYe5o9oP8qz6kImxO97JWdHSkm/k.qksLpF6ENx82fD29kqG', 'employee','Employee User');

CREATE TABLE employees(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(100),
 position VARCHAR(100),
 role_text VARCHAR(100),
 salary DECIMAL(10,2),
 pending_salary DECIMAL(10,2),
 status VARCHAR(20) DEFAULT 'active'
);

INSERT INTO employees(name,email,position,role_text,salary,pending_salary) VALUES
('Ankit Sharma','ankit@company.com','Developer','Full Stack',55000,0),
('Deepak Reddy','deepak@company.com','HR Manager','HR',45000,2000),
('Ashwin Kumar','ashwin@company.com','UI Designer','Designer',40000,0),
('Saketh Rao','saketh@company.com','Backend Developer','Developer',48000,5000),
('Priya Singh','priya@company.com','Project Manager','Manager',60000,0),
('Meena Iyer','meena@company.com','Accountant','Finance',38000,1000),
('Rohan Patel','rohan@company.com','Data Analyst','Analyst',42000,0),
('Sneha Nair','sneha@company.com','Marketing Executive','Marketing',36000,2000),
('Arjun Das','arjun@company.com','Tester','QA',37000,0),
('Kavya Joshi','kavya@company.com','HR Assistant','HR',30000,0);
