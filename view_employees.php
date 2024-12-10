<?php
require_once 'connection_db.php';

// Pagination Setup
$limit = 5;  
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  
$offset = ($page - 1) * $limit;

// Search Setup
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Sorting Setup
$order_by = isset($_GET['sort']) ? $_GET['sort'] : 'employee_id'; 
$order_dir = isset($_GET['dir']) ? $_GET['dir'] : 'ASC';  


$sql = "SELECT * FROM employees WHERE name LIKE ? OR designation LIKE ? ORDER BY $order_by $order_dir LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$search_param = "%$search%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();


// Count total records for pagination
$total_sql = "SELECT COUNT(*) FROM employees WHERE name LIKE ? OR designation LIKE ?";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("ss", $search_param, $search_param);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_records = $total_result->fetch_row()[0];
$total_pages = ceil($total_records / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Performance List</title>
    <style>
      
        body {
            font-family: 'Arial', sans-serif;
            height: 100vh;
            margin: 0 auto;
            background-color: #2C3E50;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding-right: 150px;
            padding-left: 150px; 
        }

        h1 {
            text-align: center;
            color: #F39C12; 
            margin-bottom: 30px;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #F39C12; 
            color: white;
            font-size: 16px;
        }

        th a {
            text-decoration: none;
            color: white;
            display: block;
            padding: 12px 15px;
            background-color: #F39C12; 
            font-size: 16px;
            text-align: left;
        }

        th a:hover {
            background-color: #E67E22;
        }

        th a.active {
            background-color: #D35400; 
        }

        tr:hover {
            background-color: #f9f9f9; 
        }

        td {
            font-size: 14px;
            color: #34495E;
        }

        a {
            text-decoration: none;
            padding: 6px 12px;
            margin: 0 5px;
            color: white;
            background-color: #1ABC9C; 
            border-radius: 4px;
        }

        a:hover {
            background-color: #16A085; 
        }

        a:active {
            background-color: #1D755B; 
        }

        .action-buttons {
            text-align: center;
        }

 
        .search-bar {
            margin-bottom: 20px;
            text-align: center;
        }

     
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 5px;
            background-color: #F39C12; 
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .pagination a:hover {
            background-color: #E67E22; 
        }

        .pagination a.disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }


.search-bar {
    margin-bottom: 20px;
    text-align: center;
}

.search-bar input[type="text"] {
    padding: 10px 15px;
    font-size: 14px;
    width: 300px;
    border-radius: 25px;
    border: 1px solid #ccc;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.search-bar input[type="text"]:focus {
    border-color: #F39C12; 
    outline: none;
    box-shadow: 0 2px 8px rgba(243, 156, 18, 0.5);
}

.search-bar button {
    padding: 10px 20px;
    font-size: 14px;
    background-color: #F39C12; /* Gold */
    color: white;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-left: 10px;
}

.search-bar button:hover {
    background-color: #E67E22; 
}

.search-bar button:active {
    background-color: #D35400; 
}

.add-button {
            display: inline-block;
            background-color: #F39C12; 
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 20px;
        }

     
    </style>
</head>
<body>
<div class="container">
    <h1>Employee Performance List</h1>
      <!-- Add Employee Button -->
      <div class="add-button">
        <a href="add_employee.php">Add Employee</a>
    </div>
    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET">
            <input type="text" name="search" placeholder="Search by name or designation" value="<?= htmlspecialchars($search); ?>" />
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>
                    <a href="?page=<?= $page; ?>&search=<?= urlencode($search); ?>&sort=employee_id&dir=<?= ($order_by == 'employee_id' && $order_dir == 'ASC') ? 'DESC' : 'ASC'; ?>" 
                       class="<?= ($order_by == 'employee_id') ? 'active' : ''; ?>">
                        ID
                    </a>
                </th>
                <th>
                    <a href="?page=<?= $page; ?>&search=<?= urlencode($search); ?>&sort=name&dir=<?= ($order_by == 'name' && $order_dir == 'ASC') ? 'DESC' : 'ASC'; ?>"
                       class="<?= ($order_by == 'name') ? 'active' : ''; ?>">
                        Name
                    </a>
                </th>
                <th>
                    <a href="?page=<?= $page; ?>&search=<?= urlencode($search); ?>&sort=designation&dir=<?= ($order_by == 'designation' && $order_dir == 'ASC') ? 'DESC' : 'ASC'; ?>"
                       class="<?= ($order_by == 'designation') ? 'active' : ''; ?>">
                        Designation
                    </a>
                </th>
                <th>
                    <a href="?page=<?= $page; ?>&search=<?= urlencode($search); ?>&sort=attendance_rate&dir=<?= ($order_by == 'attendance_rate' && $order_dir == 'ASC') ? 'DESC' : 'ASC'; ?>"
                       class="<?= ($order_by == 'attendance_rate') ? 'active' : ''; ?>">
                        Attendance Rate
                    </a>
                </th>
                <th>
                    <a href="?page=<?= $page; ?>&search=<?= urlencode($search); ?>&sort=average_task_efficiency&dir=<?= ($order_by == 'average_task_efficiency' && $order_dir == 'ASC') ? 'DESC' : 'ASC'; ?>"
                       class="<?= ($order_by == 'average_task_efficiency') ? 'active' : ''; ?>">
                        Average Task Efficiency
                    </a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['employee_id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['designation']; ?></td>
                <td><?= $row['attendance_rate']; ?>%</td>
                <td><?= $row['average_task_efficiency']; ?>%</td>
                <td class="action-buttons">
                    <a href="edit_employee.php?employee_id=<?= $row['employee_id']; ?>">Edit</a>
                    <a href="delete_employee.php?employee_id=<?= $row['employee_id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&sort=<?= $order_by; ?>&dir=<?= $order_dir; ?>" 
           class="<?= ($page <= 1) ? 'disabled' : ''; ?>" 
           <?= ($page <= 1) ? 'onclick="return false;"' : ''; ?>>Previous</a>

        <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&sort=<?= $order_by; ?>&dir=<?= $order_dir; ?>" 
           class="<?= ($page >= $total_pages) ? 'disabled' : ''; ?>" 
           <?= ($page >= $total_pages) ? 'onclick="return false;"' : ''; ?>>Next</a>
    </div>

</div>

</body>
</html>

<?php
$conn->close();
?>
