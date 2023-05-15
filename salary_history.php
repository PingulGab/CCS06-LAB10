<?php
$host = 'localhost:3307';
$username = 'root';
$password = 'admin';
$database = 'employees';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Could not connect to the database: ' . mysqli_connect_error());
}
?>

<?php

$empNo = $_GET['emp_no'];
$deptNo = $_GET['dept_no'];

$queryEmp = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM employees WHERE emp_no = '$empNo'";
$resultEmp = mysqli_query($conn, $queryEmp);

if (!$resultEmp) {
    die('Query failed: ' . mysqli_error($conn));
}

if ($rowEmp = mysqli_fetch_assoc($resultEmp)) {
    $employeeName = $rowEmp['name'];
} else {
    die('Employee not found.');
}

$queryHistory = "SELECT from_date, to_date, salary
                 FROM salaries
                 WHERE emp_no = '$empNo'
                 ORDER BY from_date DESC";
$resultHistory = mysqli_query($conn, $queryHistory);

if (!$resultHistory) {
    die('Query failed: ' . mysqli_error($conn));
}

echo'
    <style>
    table, th, td { border: 1px solid; padding: 10px; padding-left: 15px; padding-right: 15px; }

    a {
        background-color: #008CBA; /* Green */
        border: none;
        border-radius: 26px;
        color: white;
        padding: 12px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        font-family: "Times New Roman";
    }
    
    </style>
    ';
    
echo"
    <a href='emp_per_dept.php?dept_no=$deptNo'> Back </a>
    ";

echo "<h2>Salary History for $employeeName</h2>";
echo "<table>
        <tr>
            <th>From Date</th>
            <th>To Date</th>
            <th>Salary</th>
        </tr>";

while ($rowHistory = mysqli_fetch_assoc($resultHistory)) {
    $fromDate = $rowHistory['from_date'];
    $toDate = $rowHistory['to_date'];
    $salary = $rowHistory['salary'];

    echo "<tr>
            <td>$fromDate</td>
            <td>$toDate</td>
            <td>$salary</td>
          </tr>";
}

echo "</table>";

mysqli_free_result($resultEmp);
mysqli_free_result($resultHistory);
mysqli_close($conn);
?>
