<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobId = $_POST["jobId"];
    $jobTitle = $_POST["jobTitle"];
    $minSalary = $_POST["minSalary"];
    $maxSalary = $_POST["maxSalary"];

    $sql = "INSERT INTO jobs (job_id, job_title, min_salary, max_salary) 
            VALUES (:jobId, :jobTitle, :minSalary, :maxSalary)";

    $stmt = oci_parse($connection, $sql);
    oci_bind_by_name($stmt, ":jobId", $jobId);
    oci_bind_by_name($stmt, ":jobTitle", $jobTitle);
    oci_bind_by_name($stmt, ":minSalary", $minSalary);
    oci_bind_by_name($stmt, ":maxSalary", $maxSalary);

    if (oci_execute($stmt)) {
        echo "Job created successfully!";
    } else {
        echo "Error creating job: " . oci_error($stmt);
    }

    oci_free_statement($stmt);
    oci_close($connection);
}
?>
