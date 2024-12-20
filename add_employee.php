<?php
require_once 'connection_db.php';

$error_message = "";
$attendance_rate_error = "";
$task_efficiency_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and trim input values
    $name = htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8');
    $designation = htmlspecialchars(trim($_POST['designation']), ENT_QUOTES, 'UTF-8');
    $attendance_rate = $_POST['attendance_rate'];
    $average_task_efficiency = $_POST['average_task_efficiency'];

    // Validate attendance rate
    if (!is_numeric($attendance_rate) || $attendance_rate < 0 || $attendance_rate > 100) {
        $attendance_rate_error = "Attendance Rate must be a number between 0 and 100.";
    }

    // Validate average task efficiency
    if (!is_numeric($average_task_efficiency) || $average_task_efficiency < 0 || $average_task_efficiency > 100) {
        $task_efficiency_error = "Average Task Efficiency must be a number between 0 and 100.";
    }

    // If no errors, proceed with insertion
    if (empty($attendance_rate_error) && empty($task_efficiency_error)) {
        $stmt = $conn->prepare("INSERT INTO employees (name, designation, attendance_rate, average_task_efficiency) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdd", $name, $designation, $attendance_rate, $average_task_efficiency);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: view_employees.php"); // Redirect to employee list
        } else {
            $error_message = "Failed to add employee.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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

    <h1>Add Employee</h1>

    <div class="form-container">

        <form method="POST">
            
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="designation">Designation:</label>
            <input type="text" id="designation" name="designation" required>

            <label for="attendance_rate">Attendance Rate (%):</label>
            <input type="number" id="attendance_rate" name="attendance_rate" required>
            <?php if ($attendance_rate_error): ?>
                <div class="field-error"><?= $attendance_rate_error; ?></div>
            <?php endif; ?>

            <label for="average_task_efficiency">Average Task Efficiency (%):</label>
            <input type="number" id="average_task_efficiency" name="average_task_efficiency" required>
            <?php if ($task_efficiency_error): ?>
                <div class="field-error"><?= $task_efficiency_error; ?></div>
            <?php endif; ?>

            <button type="submit">Add Employee</button>
            <?php if ($error_message): ?>
            <div class="error-message"><?= $error_message; ?></div>
            <?php endif; ?>
        </form>

        <a href="view_employees.php" class="back-btn">Back to Employee List</a>
    </div>

</body>
</html>

<?php
$conn->close();
?>
