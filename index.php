<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Employee Web App</title>

        <style>
            .center {
                margin: 0;
                position: absolute;
                left: 50%;
                top: 37%;
                -ms-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .center2 {
                margin: 0;
                position: absolute;
                top: 41%;
                left: 50%;
                -ms-transform: translate(-25%, -25%);
                transform: translate(-50%, -25%);
            }

            .button {
                background-color: #008CBA;
                border: none;
                border-radius: 26px;
                color: white;
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                font-family: "Times New Roman";
            }

            label {
                font-size: 25px;
                font-family: "Times New Roman";
            }

            select {
                font-size: 20px;
                font-family: "Times New Roman";
            }

            .center3 {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
            width:500px;height:250px;
            }

        </style>
    </head>

    <body>

        <h1 style="text-align:center;"> Employee Web Application </h1>
        <img src="https://i.imgur.com/NV4sBTx.png" class="center3">
        <form action = "department_list.php">
            <div class="center">
                <button class="button"> Department List </button>
            </div>
        </form>

        <form action = "emp_per_dept.php" method = "get">
            <div class="center2">
                <label for="dept-select">Select Department:</label>
                <select name="dept_no" id="dept-select">
                <option value="d001">Department 01</option>
                <option value="d002">Department 02</option>
                <option value="d003">Department 03</option>
                <option value="d004">Department 04</option>
                <option value="d005">Department 05</option>
                <option value="d006">Department 06</option>
                <option value="d007">Department 07</option>
                <option value="d008">Department 08</option>
                <option value="d009">Department 09</option>
                </select>
                <button class="button" type="submit"> Search </button>
            </div>
        </form>
    </body>

</html>