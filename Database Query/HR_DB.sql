-- Create a sequence for generating employee IDs
CREATE SEQUENCE employees_seq START WITH 1 INCREMENT BY 1;

-- Create the DEPARTMENTS table
CREATE TABLE hr_departments (
    department_id NUMBER PRIMARY KEY,
    department_name VARCHAR2(50)
);

-- Insert sample data into the DEPARTMENTS table
INSERT INTO hr_departments (department_id, department_name) VALUES (10, 'Administration');
INSERT INTO hr_departments (department_id, department_name) VALUES (20, 'Marketing');
INSERT INTO hr_departments (department_id, department_name) VALUES (30, 'Sales');
-- Add more departments as needed

-- Create the JOBS table
CREATE TABLE hr_jobs (
    job_id VARCHAR2(10) PRIMARY KEY,
    job_title VARCHAR2(50),
    min_salary NUMBER,
    max_salary NUMBER
);

-- Insert sample data into the JOBS table
INSERT INTO hr_jobs (job_id, job_title, min_salary, max_salary) VALUES ('SA_REP', 'Sales Representative', 5000, 12000);
INSERT INTO hr_jobs (job_id, job_title, min_salary, max_salary) VALUES ('AC_MGR', 'Accounting Manager', 8200, 16000);
-- Add more jobs as needed

-- Create the EMPLOYEES table
CREATE TABLE hr_employees (
    employee_id NUMBER PRIMARY KEY,
    first_name VARCHAR2(50),
    last_name VARCHAR2(50),
    email VARCHAR2(100),
    phone_number VARCHAR2(20),
    hire_date DATE,
    job_id VARCHAR2(10),
    salary NUMBER,
    manager_id NUMBER,
    department_id NUMBER,
    CONSTRAINT fk_department FOREIGN KEY (department_id) REFERENCES hr_departments (department_id),
    CONSTRAINT fk_job FOREIGN KEY (job_id) REFERENCES hr_jobs (job_id),
    CONSTRAINT fk_manager FOREIGN KEY (manager_id) REFERENCES hr_employees (employee_id)
);

-- Create a trigger to enforce the salary range constraint
CREATE OR REPLACE TRIGGER check_salary_trg
BEFORE INSERT OR UPDATE OF job_id, salary ON hr_employees
FOR EACH ROW
DECLARE
    v_minsal hr_jobs.min_salary%TYPE;
    v_maxsal hr_jobs.max_salary%TYPE;
BEGIN
    SELECT min_salary, max_salary INTO v_minsal, v_maxsal
    FROM hr_jobs
    WHERE job_id = :new.job_id;

    IF :new.salary < v_minsal OR :new.salary > v_maxsal THEN
        RAISE_APPLICATION_ERROR(-20100, 'Invalid salary. Salaries for job ' || :new.job_id || ' must be between ' || v_minsal || ' and ' || v_maxsal);
    END IF;
END;

-- Commit the changes
COMMIT;
