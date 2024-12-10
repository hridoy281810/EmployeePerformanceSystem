<?php
require_once 'connection_db.php';

$error_message = "";
$attendance_rate_error = "";
$task_efficiency_error = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = $_POST['employee_id'];  
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $attendance_rate = $_POST['attendance_rate'];
    $average_task_efficiency = $_POST['average_task_efficiency'];


    if (!is_numeric($attendance_rate) || $attendance_rate < 0 || $attendance_rate > 100) {
        $attendance_rate_error = "Attendance Rate must be a number between 0 and 100.";
    }


    if (!is_numeric($average_task_efficiency) || $average_task_efficiency < 0 || $average_task_efficiency > 100) {
        $task_efficiency_error = "Average Task Efficiency must be a number between 0 and 100.";
    }


    if (empty($attendance_rate_error) && empty($task_efficiency_error)) {
        $stmt = $conn->prepare("UPDATE employees SET name = ?, designation = ?, attendance_rate = ?, average_task_efficiency = ? WHERE employee_id = ?");
        $stmt->bind_param("ssdsi", $name, $designation, $attendance_rate, $average_task_efficiency, $employee_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: view_employees.php"); 
        } else {
            $error_message = "Update failed or no changes made."; 
        }
    }
}

if (isset($_GET['employee_id'])) {  
    $employee_id = $_GET['employee_id'];
    $sql = "SELECT * FROM employees WHERE employee_id = $employee_id"; 
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();  
    } else {
        die("Employee not found!");
    }
} else {
    die("No employee ID provided!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <style>
 
        body {
            font-family: 'Arial', sans-serif;
            background-color: #2C3E50; 
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #F39C12;
            margin-bottom: 20px;
            font-size: 2rem;
        }

  
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
        }

        label {
            font-size: 1rem;
            margin-bottom: 8px;
            display: block;
            font-weight: 600;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #F39C12; 
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #F39C12; 
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1.1rem;
            cursor: pointer;
        }

        button:hover {
            background-color: #E67E22;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 16px;
            background-color: #ddd;
            color: #333;
            border: 1px solid #ccc;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
        }

        .back-btn:hover {
            background-color: #bbb;
        }

        .error-message {
            color: red;
            font-size: 1.1rem;
            margin-bottom: 20px;
            text-align: center;
            margin-top: 20px;
        }

    
        .field-error {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

    
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.8rem;
            }

            input[type="text"],
            input[type="number"],
            button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <h1>Edit Employee</h1>
    
    <div class="form-container">
        <?php if ($error_message): ?>
            <div class="error-message"><?= $error_message; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="employee_id" value="<?= $employee['employee_id']; ?>"> <!-- Hidden input for employee_id -->
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?= $employee['name']; ?>" required>
            
            <label for="designation">Designation:</label>
            <input type="text" id="designation" name="designation" value="<?= $employee['designation']; ?>" required>
            
            <label for="attendance_rate">Attendance Rate (%):</label>
            <input type="number" id="attendance_rate" name="attendance_rate" value="<?= $employee['attendance_rate']; ?>" min="0" max="100" required>
            <?php if ($attendance_rate_error): ?>
                <div class="field-error"><?= $attendance_rate_error; ?></div>
            <?php endif; ?>
            
            <label for="average_task_efficiency">Average Task Efficiency (%):</label>
            <input type="number" id="average_task_efficiency" name="average_task_efficiency" value="<?= $employee['average_task_efficiency']; ?>" min="0" max="100" required>
            <?php if ($task_efficiency_error): ?>
                <div class="field-error"><?= $task_efficiency_error; ?></div>
            <?php endif; ?>
            
            <button type="submit">Update</button>
        </form>

        <a href="view_employees.php" class="back-btn">Back to Employee List</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
