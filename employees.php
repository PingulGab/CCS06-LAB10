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

$deptNumber = $_GET['dept_no'];

$query = "SELECT * FROM employees WHERE emp_no IN (
            SELECT emp_no FROM dept_emp WHERE dept_no = '$deptNumber'
         )";

$result = mysqli_query($conn, $query);

if (!$result) {
    die('Query failed: ' . mysqli_error($conn));
}

mysqli_close($conn);
?>

<?php

echo'
    <style>
    table, th, td { border: 1px solid; padding: 5px; padding-left: 10px; padding-right: 10px; }

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

echo '<h1>Employees in Department ' . $deptNumber . '</h1>';

echo"
    <a href='department_list.php'> Back </a>
    <br>
    <br>
    ";

echo '<table>';
echo '<tr><th>Employee Number</th><th>First Name</th><th>Last Name</th></tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['emp_no'] . '</td>';
    echo '<td>' . $row['first_name'] . '</td>';
    echo '<td>' . $row['last_name'] . '</td>';
    echo '</tr>';
}

echo '</table>';

?>
