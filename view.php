<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
    <!-- Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- DataTables CSS for table styling -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- DataTables Responsive CSS (optional for responsive design) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <style>
    /* Basic page styling */
    body {
        background: linear-gradient(135deg, #f0f4f8, #dbe6f0);
    }
    .container-fluid {
        padding: 0 15px;
        margin-top: 50px;
    }
    .card {
        border-radius: 10px;
        border: 1px solid #e1e5ec;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background: #007bff;
        color: white;
        border-bottom: 1px solid #0056b3;
    }
    .card-header h3 {
        margin: 0;
    }
    /* Table styling */
    .table thead th {
        background: #007bff;
        color: white;
        text-align: center;
        font-size: 0.775rem;
    }
    .table tbody tr:nth-child(even) {
        background: #f2f2f2;
    }
    .table tbody tr:hover {
        background: #e9ecef;
    }
    .table td {
        font-size: 0.775rem; /* Adjust font size as needed */
    }
    /* DataTables pagination styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.5em 1em;
        margin: 0.1em;
        border-radius: 5px;
        border: 1px solid #007bff;
        color: #007bff;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff;
        color: white;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #0056b3;
        color: white;
    }
    /* DataTables filter and length menu styling */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 0.5em;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #007bff;
        border-radius: 5px;
        padding: 0.2em;
    }
</style>
</head>
<body>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Employee Records</h3>
        </div>
        <div class="card-body">
            <!-- Table to display records -->
            <table id="recordsTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Emergency Contact</th>
                        <th>Relationship</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table body will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery for JavaScript functionalities -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Bootstrap JS for Bootstrap functionalities -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables JS for advanced table functionalities -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- DataTables Responsive JS for responsive design -->
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables with server-side processing
    $('#recordsTable').DataTable({
        responsive: true, // Make the table responsive
        "processing": true, // Show processing indicator
        "serverSide": true, // Enable server-side processing
        "ajax": {
            "url": "fetch_data.php", // URL to fetch data from
            "type": "POST" // HTTP method
        },
        "pageLength": 10, // Number of records per page
        "lengthMenu": [10, 25, 50, 100], // Options for page length
        "pagingType": "full_numbers", // Pagination style
        "order": [[0, 'asc']], // Default sorting by the first column
        "columnDefs": [
            { "className": "text-center", "targets": "_all" } // Center align all columns
        ],
        "language": {
            "paginate": {
                "previous": '<i class="fas fa-chevron-left"></i>', // Previous page icon
                "next": '<i class="fas fa-chevron-right"></i>', // Next page icon
                "first": '<i class="fas fa-chevron-left"></i>', // First page icon
                "last": '<i class="fas fa-chevron-right"></i>' // Last page icon
            },
            "search": "Filter:", // Text for search input
            "lengthMenu": "Show _MENU_ entries", // Text for page length menu
            "info": "Showing _START_ to _END_ of _TOTAL_ entries" // Text for info display
        }
    });
});
</script>
</body>
</html>
