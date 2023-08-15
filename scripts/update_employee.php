<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST["employeeId"];
    $newSalary = $_POST["newSalary"];

    $sql = "UPDATE employees SET salary = :newSalary WHERE employee_id = :employeeId";

    $stmt = oci_parse($connection, $sql);
    oci_bind_by_name($stmt, ":employeeId", $employeeId);
    oci_bind_by_name($stmt, ":newSalary", $newSalary);

    if (oci_execute($stmt)) {
        echo "Employee salary updated successfully!";
    } else {
        echo "Error updating employee salary: " . oci_error($stmt);
    }

    oci_free_statement($stmt);
    oci_close($connection);
}
?>
