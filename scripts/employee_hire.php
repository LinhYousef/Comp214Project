<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $salary = $_POST["salary"];
    $hireDate = $_POST["hireDate"];
    $phone = $_POST["phone"];
    $jobId = $_POST["jobId"];
    $managerId = $_POST["managerId"];
    $departmentId = $_POST["departmentId"];

    $sql = "INSERT INTO employees (employee_id, first_name, last_name, email, salary, hire_date, phone_number, job_id, manager_id, department_id) 
            VALUES (employees_seq.NEXTVAL, :firstName, :lastName, :email, :salary, TO_DATE(:hireDate, 'YYYY-MM-DD'), :phone, :jobId, :managerId, :departmentId)";

    $stmt = oci_parse($connection, $sql);
    oci_bind_by_name($stmt, ":firstName", $firstName);
    oci_bind_by_name($stmt, ":lastName", $lastName);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":salary", $salary);
    oci_bind_by_name($stmt, ":hireDate", $hireDate);
    oci_bind_by_name($stmt, ":phone", $phone);
    oci_bind_by_name($stmt, ":jobId", $jobId);
    oci_bind_by_name($stmt, ":managerId", $managerId);
    oci_bind_by_name($stmt, ":departmentId", $departmentId);

    if (oci_execute($stmt)) {
        echo "Employee hired successfully!";
    } else {
        echo "Error hiring employee: " . oci_error($stmt);
    }

    oci_free_statement($stmt);
    oci_close($connection);
}
?>
