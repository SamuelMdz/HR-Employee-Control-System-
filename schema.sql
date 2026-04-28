-- CoreAxisHR Database Schema
-- Run this in phpMyAdmin SQL tab

CREATE DATABASE IF NOT EXISTS hr_test;
USE hr_test;

CREATE TABLE employees (
  id        INT PRIMARY KEY AUTO_INCREMENT,
  name      VARCHAR(100),
  job_title VARCHAR(100),
  status    VARCHAR(20)
);

CREATE TABLE users (
  id          INT PRIMARY KEY AUTO_INCREMENT,
  username    VARCHAR(50),
  password    VARCHAR(255),
  role        VARCHAR(20),
  employee_id INT
);

CREATE TABLE leave_requests (
  id          INT PRIMARY KEY AUTO_INCREMENT,
  employee_id INT NOT NULL,
  type        VARCHAR(50),
  start_date  DATE,
  end_date    DATE,
  reason      TEXT,
  status      VARCHAR(20) DEFAULT 'pending',
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP
);
