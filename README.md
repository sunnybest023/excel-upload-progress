Excel Upload with Progress
Features
Excel Upload: Upload .xls or .xlsx files.
Progress Tracking: Track upload progress and handle validation.
Duplicate Handling: Checks for duplicates and provides feedback.
Record Viewing: View records in a paginated table.
Server-Side Pagination: Pagination with DataTables.
Setup



Clone Repository:
git clone https://github.com/sunnybest023/excel-upload-progress.git
cd excel-upload-progress
Install Dependencies:



Update db.php with your database credentials:
<?php
$mysqli = new mysqli('localhost', 'your-username', 'your-password', 'your-database');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

Setup the Project:
Ensure files: index.php, view.php, db.php, fetch_data.php, upload.php, vendor/.
Place in the web server's root directory (e.g., /var/www/html).


Access the Application:
Upload Interface: http://your-server-address/index.php
View Records: http://your-server-address/view.php

Upload File:
Go to index.php.
Select file, enter number of records, click "Upload".
Track progress and handle duplicates.

View Records:
Go to view.php.                    
Search and paginate records.  
