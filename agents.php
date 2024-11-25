<?php

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $agent_name = $_POST['agent_name'] ?? '';
    $agent_uname = $_POST['agent_uname'] ?? '';
    $agent_pass = $_POST['agent_pass'] ?? '';

    $stmt = $conn->prepare("INSERT INTO agents (agent_name, agent_uname, agent_pass) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $agent_name, $agent_uname, $agent_pass);
    if ($stmt->execute()) {
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    header("Location: Homepage.php?page=agents");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $agent_name = $_POST['agent_name'] ?? '';
    $agent_uname = $_POST['agent_uname'] ?? '';
    $agent_pass = $_POST['agent_pass'] ?? '';

    $stmt = $conn->prepare("UPDATE agents SET agent_name=?, agent_uname=?, agent_pass=? WHERE id=?");
    $stmt->bind_param("sssi", $agent_name, $agent_uname, $agent_pass, $id);
    if ($stmt->execute()) {

    } else {
        echo "Error: " . $stmt->error; 
    }
    $stmt->close();
    header("Location: Homepage.php?page=agents");
    exit();
}

if (isset($_POST['delete'])) {
    $agent_id = $_POST['agent_id'];
    $stmt = $conn->prepare("DELETE FROM agents WHERE id=?");
    $stmt->bind_param("s", $agent_id);
    if ($stmt->execute()) {
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
    header("Location: Homepage.php?page=agents");
    exit();
}

$result = $conn->query("SELECT * FROM agents");
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
        <?php while ($row = $result->fetch_assoc()): ?>
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
        <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    if (isset($_GET['edit'])) {
        $edit_id = (int)$_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM agents WHERE id=?");
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $edit_result = $stmt->get_result();
        $edit_row = $edit_result->fetch_assoc();
        $stmt->close();
    }
    ?>
</body>
</html>
