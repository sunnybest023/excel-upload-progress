<?php
// Include Composer's autoloader and database connection file
require 'vendor/autoload.php';
require 'db.php'; // Ensure you have installed phpoffice/phpspreadsheet via Composer

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Exception;

// Initialize variables for file upload validation
$uploadOk = 1;
$allowed_file_types = ['xls', 'xlsx'];

// Check if the file size exceeds the limit of 5MB
if ($_FILES["file"]["size"] > 5242880) {
    echo json_encode(['message' => 'Sorry, your file is too large.']);
    exit;
}

// Check if the file type is either XLS or XLSX
$file_type = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
if (!in_array($file_type, $allowed_file_types)) {
    echo json_encode(['message' => 'Sorry, only XLS and XLSX files are allowed.']);
    exit;
}

// Process the file if validation passes
if ($uploadOk == 1) {
    try {
        // Load the spreadsheet file
        $spreadsheet = IOFactory::load($_FILES["file"]["tmp_name"]);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        // Extract the header and initialize counters
        $header = array_shift($data);
        $totalRecords = intval($_POST['record_count']); // Number of records user expects to process
        $processedRecords = 0;
        $inserted = 0;
        $duplicateCount = 0;
        $progressPercentage = 0;
        $identifierColumn = array_search('Employee ID', $header); // Find the column index of 'Employee ID'

        // Start database transaction
        $mysqli->begin_transaction();

        // Process each row of the spreadsheet
        foreach ($data as $row) {
            if (--$totalRecords < 0) break; // Stop processing if the number of records to process is exceeded

            $employee_id = $mysqli->real_escape_string($row[$identifierColumn]);

            // Check for duplicate records
            $result = $mysqli->query("SELECT COUNT(*) as count FROM employee WHERE employee_id='$employee_id'");
            $row_count = $result->fetch_assoc()['count'];

            if ($row_count > 0) {
                $duplicateCount++; // Increment duplicate count and skip record
                continue;
            }

            // Insert data into the employee table
            $stmt = $mysqli->prepare("INSERT INTO employee (employee_id, name) VALUES (?, ?)");
            $stmt->bind_param("ss", $row[0], $row[1]);
            $stmt->execute();
            $employee_id = $mysqli->insert_id;

            // Insert data into the personal_details table
            $stmt = $mysqli->prepare("INSERT INTO personal_details (employee_id, age, gender, address, city, state, zip_code, phone_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iissssss", $employee_id, $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $row[8]);
            $stmt->execute();

            // Insert data into the additional_details table
            $stmt = $mysqli->prepare("INSERT INTO additional_details (employee_id, email, emergency_contact, relationship) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $employee_id, $row[9], $row[10], $row[11]);
            $stmt->execute();

            $inserted++; // Increment inserted records count
            $processedRecords++; // Increment processed records count
            usleep(500000); // Sleep for half a second to simulate processing time

            // Calculate progress percentage
            $progressPercentage = round(($processedRecords / intval($_POST['record_count'])) * 100);

            // Send intermediate progress update
            echo '##' . $progressPercentage . '##' . $inserted . '##' . intval($_POST['record_count']);
            ob_flush();
            flush();
        }

        // Commit transaction if all records are processed successfully
        $mysqli->commit();
        $mysqli->close();

        // Final response: indicate success and number of duplicate records
        echo "##Upload Successful##" . $duplicateCount . "##true";
        
    } catch (Exception $e) {
        // Rollback transaction if there's an error
        $mysqli->rollback();
        echo json_encode(['message' => 'Error processing file: ' . $e->getMessage()]);
    }
}
?>
