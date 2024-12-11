<?php

  // Ensure the Database class is included
require_once "Agent.php";     // Ensure the Agent class is included

// Initialize the Database and Agent classes
$db = new Database();      // Instantiate the Database class
$conn = $db->getConnection();  // Get the database connection

$agent = new Agent($conn);  // Instantiate the Agent class with the database connection

// Get agents from the database
$agents = $agent->getAllAgents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        form.f {
            display: flex;
            justify-content: center;
            align-items: left;
            width: 300px;
            border: 5px solid #ccc;
            padding: 25px;
            border-radius: 10px;
            flex-direction: column;
            margin-top: 25px;
        }

        button {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST" action="" class="f">
            <h1>AGENTS</h1>
            <input type="hidden" name="id" value="<?php echo isset($edit_row) ? $edit_row['id'] : ''; ?>">
            <label>Agent Name:</label>
            <input name="agent_name" type="text" placeholder="Agent Name" value="<?php echo isset($edit_row) ? htmlspecialchars($edit_row['agent_name']) : ''; ?>" required><br>
            <label>Agent Username:</label>
            <input name="agent_uname" type="text" placeholder="Agent Username" value="<?php echo isset($edit_row) ? htmlspecialchars($edit_row['agent_uname']) : ''; ?>" required><br>
            <label>Password:</label>
            <input name="agent_pass" type="text" placeholder="Password" value="<?php echo isset($edit_row) ? htmlspecialchars($edit_row['agent_pass']) : ''; ?>" required><br>  
            <button type="submit" name="action" value="<?php echo isset($edit_row) ? 'edit' : 'add'; ?>"><?php echo isset($edit_row) ? 'Update' : 'Submit'; ?></button>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Check if there are agents
        if ($agents) {
            foreach ($agents as $row) {
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['agent_name']); ?></td>
                <td><?php echo htmlspecialchars($row['agent_uname']); ?></td>
                <td><?php echo htmlspecialchars($row['agent_pass']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="agent_id" value="<?php echo $row['id']; ?>" >
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php 
            }
        } else {
            echo "<tr><td colspan='4'>No agents found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
</body>
</html>
