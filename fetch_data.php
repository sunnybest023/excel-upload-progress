<?php
require 'db.php';

$limit = $_POST['length'];
$start = $_POST['start'];
$searchValue = $_POST['search']['value'];

$totalRecordsQuery = "SELECT COUNT(*) as total FROM employee";
$totalRecordsResult = $mysqli->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

$query = "SELECT e.employee_id, e.name, pd.age, pd.gender, pd.address, pd.city, pd.state, pd.zip_code, pd.phone_number, ad.email, ad.emergency_contact, ad.relationship
          FROM employee e
          JOIN personal_details pd ON e.employee_id = pd.employee_id
          JOIN additional_details ad ON e.employee_id = ad.employee_id
          WHERE e.name LIKE '%$searchValue%'
          LIMIT $start, $limit";
$result = $mysqli->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        $row['employee_id'],
        $row['name'],
        $row['age'],
        $row['gender'],
        $row['address'],
        $row['city'],
        $row['state'],
        $row['zip_code'],
        $row['phone_number'],
        $row['email'],
        $row['emergency_contact'],
        $row['relationship']
    ];
}

$response = [
    'draw' => $_POST['draw'],
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $totalRecords,
    'data' => $data
];

echo json_encode($response);
?>
