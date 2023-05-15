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

$deptNo = $_GET['dept_no'];

$queryDept = "SELECT dept_name, GROUP_CONCAT(CONCAT(e.first_name, ' ', e.last_name) SEPARATOR ', ') AS manager_names
              FROM departments d
              JOIN dept_manager dm ON d.dept_no = dm.dept_no
              JOIN employees e ON dm.emp_no = e.emp_no
              WHERE d.dept_no = '$deptNo'
              GROUP BY d.dept_no";
$resultDept = mysqli_query($conn, $queryDept);

if (!$resultDept) {
    die('Query failed: ' . mysqli_error($conn));
}

if ($rowDept = mysqli_fetch_assoc($resultDept)) {
    $deptName = $rowDept['dept_name'];
    $managerNames = $rowDept['manager_names'];
} else {
    die('Department not found.');
}

$queryEmp = "SELECT t.title, CONCAT(e.first_name, ' ', e.last_name) AS name, e.birth_date,
             TIMESTAMPDIFF(YEAR, e.birth_date, CURDATE()) AS age, e.gender, e.hire_date, s.salary,
             e.emp_no
             FROM employees e
             JOIN titles t ON e.emp_no = t.emp_no
             JOIN salaries s ON e.emp_no = s.emp_no
             JOIN dept_emp de ON e.emp_no = de.emp_no
             WHERE de.dept_no = '$deptNo' AND t.to_date = '9999-01-01' AND s.to_date = '9999-01-01'";
$resultEmp = mysqli_query($conn, $queryEmp);

if (!$resultEmp) {
    die('Query failed: ' . mysqli_error($conn));
}

echo'
    <style>
    table, th, td { border: 1px solid; padding: 10px; padding-left: 15px; padding-right: 15px; }

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

echo "<h2>Department: $deptName</h2>";
echo "<h3>Managers: $managerNames</h3>";

echo"
    <a class='button' href='index.php'> Back </a>
    <br>
    <br>
    ";

if (mysqli_num_rows($resultEmp) == 0) {
    echo "<p>No employees found in this department.</p>";
} else {

    echo "<table>
            <tr>
                <th>Employee Title</th>
                <th>Employee's Name</th>
                <th>Birthday</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Hire Date</th>
                <th>Latest Salary</th>
                <th>Salary History</th>
            </tr>";
    
    while ($rowEmp = mysqli_fetch_assoc($resultEmp)) {
        $empNo = $rowEmp['emp_no'];
        $title = $rowEmp['title'];
        $name = $rowEmp['name'];
        $birthDate = $rowEmp['birth_date'];
        $age = $rowEmp['age'];
        $gender = $rowEmp['gender'];
        $hireDate = $rowEmp['hire_date'];
        $salary = $rowEmp['salary'];

        echo "<tr>
                <td>$title</td>
                <td>$name</td>
                <td>$birthDate</td>
                <td>$age</td>
                <td>$gender</td>
                <td>$hireDate</td>
                <td>$salary</td>
                <td><a href='salary_history.php?emp_no=$empNo&dept_no=$deptNo'>View</a></td>
              </tr>";
    }

    echo "</table>";
}

mysqli_free_result($resultDept);
mysqli_free_result($resultEmp);
mysqli_close($conn);
?>
