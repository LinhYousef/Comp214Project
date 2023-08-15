<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobId = $_POST["jobId"];

    $sql = "SELECT job_title FROM jobs WHERE job_id = :jobId";

    $stmt = oci_parse($connection, $sql);
    oci_bind_by_name($stmt, ":jobId", $jobId);

    if (oci_execute($stmt)) {
        if (oci_fetch($stmt)) {
            $jobTitle = oci_result($stmt, "JOB_TITLE");
            echo "Job Description: $jobTitle";
        } else {
            echo "Job ID not found.";
        }
    } else {
        echo "Error fetching job description: " . oci_error($stmt);
    }

    oci_free_statement($stmt);
    oci_close($connection);
}
?>
