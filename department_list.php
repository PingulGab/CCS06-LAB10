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

$query = "SELECT d.dept_no, d.dept_name, CONCAT(e.first_name, ' ', e.last_name) AS manager_name, dm.from_date, dm.to_date,
          TIMESTAMPDIFF(YEAR, dm.from_date, dm.to_date) AS years
          FROM departments d
          JOIN dept_manager dm ON d.dept_no = dm.dept_no
          JOIN employees e ON dm.emp_no = e.emp_no
          ORDER BY d.dept_no";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

echo'
    <style>
    table, th, td { border: 1px solid; padding: 5px; padding-left: 10px; padding-right: 10px; }

    .button {
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
echo '<h1>List of Departments</h1>';

echo"
    <a class='button' href='index.php'> Back </a>
    <br>
    <br>
    ";

echo '<table>';
echo '<tr><th>Department Number</th><th>Department Name</th><th>Manager Name</th><th>From Date</th><th>To Date</th><th>Number of Years</th><th>Employees</th></tr>';

$prevDeptNo = null;

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';

    if ($prevDeptNo === $row['dept_no']) {
        echo '<td></td>';
        echo '<td></td>';
    } else {
        echo '<td>' . $row['dept_no'] . '</td>';
        echo '<td>' . $row['dept_name'] . '</td>';
        $prevDeptNo = $row['dept_no'];
    }

    echo '<td>' . $row['manager_name'] . '</td>';
    echo '<td>' . $row['from_date'] . '</td>';
    echo '<td>' . $row['to_date'] . '</td>';
    echo '<td>' . $row['years'] . '</td>';
    echo '<td><a href="employees.php?dept_no=' . $row['dept_no'] . '">View Employees</a></td>';

    echo '</tr>';
}

echo '</table>';

mysqli_close($conn);
?>
