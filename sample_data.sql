-- CoreAxisHR Sample Data
-- Run this AFTER schema.sql

USE hr_test;

INSERT INTO employees (name, job_title, status) VALUES
  ('Alice Johnson', 'HR Manager',  'active'),
  ('Bob Martinez',  'Developer',   'active'),
  ('Carol White',   'Designer',    'inactive');

INSERT INTO users (username, password, role, employee_id) VALUES
  ('alice', 'admin123',    'admin',    1),
  ('bob',   'manager123',  'manager',  2),
  ('carol', 'employee123', 'employee', 3);
