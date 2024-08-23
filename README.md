Excel Upload with Progress
Features
Excel Upload: Upload .xls or .xlsx files.
Progress Tracking: Track upload progress and handle validation.
Duplicate Handling: Checks for duplicates and provides feedback.
Record Viewing: View records in a paginated table.
Server-Side Pagination: Pagination with DataTables.
Setup

1- Clone Repository:
git clone https://github.com/sunnybest023/excel-upload-progress.git
cd excel-upload-progress
Install Dependencies:

2- Update db.php with your database credentials:

3- Setup the Project:
Ensure files: index.php, view.php, db.php, fetch_data.php, upload.php, vendor/.
Place in the web server's root directory (e.g., /var/www/html).


4- Access the Application:
Upload Interface: http://your-server-address/index.php
View Records: http://your-server-address/view.php

5- Upload File:
Go to index.php.
Select file, enter number of records, click "Upload".
Track progress and handle duplicates.

6-View Records:
Go to view.php.                    
Search and paginate records.  
