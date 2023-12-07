DROP DATABASE IF EXISTS workshop;
CREATE DATABASE workshop;
USE workshop;
-- Création des tables avec les contraintes nécessaires
CREATE TABLE departments (
    dept_id INT PRIMARY KEY,
    dept_name VARCHAR(255) NOT NULL
);
CREATE TABLE employees (
    emp_id INT PRIMARY KEY,
    emp_name VARCHAR(255) NOT NULL,
    emp_salary INT,
    dept_id INT,
    FOREIGN KEY (dept_id) REFERENCES departments(dept_id)
);
-- Insertion des données dans les tables
INSERT INTO departments (dept_id, dept_name)
VALUES (1, 'HR'),
    (2, 'Finance'),
    (3, 'Marketing');
INSERT INTO employees (emp_id, emp_name, emp_salary, dept_id)
VALUES (1, 'Alice', 50000, 1),
    (2, 'Bob', 60000, 2),
    (3, 'Charlie', 55000, 1),
    (4, 'David', 70000, 3);
-- @block
-- Liste de tous les employés avec leurs noms de département correspondants
SELECT emp_name,
    dept_name
FROM employees
    JOIN departments ON employees.dept_id = departments.dept_id;
-- @block
-- Total des dépenses salariales pour chaque département
SELECT dept_name,
    SUM(emp_salary) AS total_salary
FROM employees
    JOIN departments ON employees.dept_id = departments.dept_id
GROUP BY departments.dept_name;
-- @block
-- Employés n'appartenant à aucun département
SELECT emp_name
FROM employees
WHERE dept_id IS NULL;
-- Nom du département et nombre d'employés dans chaque département
-- @block
SELECT dept_name,
    COUNT(emp_id) AS num_employees
FROM departments
    LEFT JOIN employees ON departments.dept_id = employees.dept_id
GROUP BY departments.dept_name;
-- Salaire le plus élevé dans chaque département avec le nom de l'employé
-- @block
SELECT dept_name,
    emp_name,
    emp_salary
FROM employees
    JOIN departments ON employees.dept_id = departments.dept_id
WHERE (employees.dept_id, emp_salary) IN (
        SELECT employees.dept_id,
            MAX(emp_salary) AS max_salary
        FROM employees
        GROUP BY employees.dept_id
    );