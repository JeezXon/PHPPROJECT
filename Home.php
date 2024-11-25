<?php

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";


$conn = mysqli_connect($sname, $uname, $password, $db_name);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$tasks = [];
$result = $conn->query("
    SELECT 
        t.Ticket_tnum, 
        c.Client_name, 
        a.agent_name, 
        t.tconcern, 
        t.severity, 
        t.date_start, 
        t.date_end, 
        au.Astatus 
    FROM 
        tasks t 
    JOIN 
        clients c ON t.client_tname = c.Client_name 
    JOIN 
        agents a ON t.agent_tname = a.agent_name 
    LEFT JOIN 
        agent_user au ON t.Ticket_tnum = au.ATicket_num
");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    foreach ($_POST['Ticket_tnum'] as $index => $ticketNum) {
        $clientName = $_POST['Clients_Aname'][$index];
        $agentName = $_POST['Agent_Aname'][$index];
        $concern = $_POST['Aconcern'][$index];
        $severity = $_POST['Aseverity'][$index];
        $dateStart = $_POST['Adate_start'][$index];
        $dateFinish = $_POST['Adate_F'][$index];
        $status = $_POST['status'][$index];

        // Check if the entry exists
        $checkSql = "SELECT * FROM agent_user WHERE ATicket_num = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $ticketNum);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Update existing record
            $sql = "UPDATE agent_user SET 
                        Clients_Aname = ?, 
                        Agent_Aname = ?, 
                        Aconcern = ?, 
                        Aseverity = ?, 
                        Adate_start = ?, 
                        Adate_F = ?, 
                        Astatus = ? 
                    WHERE ATicket_num = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $clientName, $agentName, $concern, $severity, $dateStart, $dateFinish, $status, $ticketNum);
            header("refresh: 2;");
        } else {
            // Insert new record
            $sql = "INSERT INTO agent_user (ATicket_num, Clients_Aname, Agent_Aname, Aconcern, Aseverity, Adate_start, Adate_F, Astatus) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $ticketNum, $clientName, $agentName, $concern, $severity, $dateStart, $dateFinish, $status);
        }

        if ($stmt->execute()) {
            echo "<p>Record for Ticket $ticketNum processed successfully!</p>";
        } else {
            echo "<p>Error processing record for Ticket $ticketNum: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
        $checkStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 50px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Task Management System</h1>
    <nav>
        <a href="Logout.php">Logout</a>
    </nav>
    <form method="POST" action="">
        <table>
            <thead>
                <tr>
                    <th>Ticket#</th>
                    <th>Client Name</th>
                    <th>Agent Name</th>
                    <th>Concern</th>
                    <th>Severity</th>
                    <th>Date Start</th>
                    <th>Date to Finish</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?php echo $task['Ticket_tnum']; ?></td>
                        <td>
                            <input type="hidden" name="Clients_Aname[]" value="<?php echo $task['Client_name']; ?>">
                            <?php echo $task['Client_name']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="Agent_Aname[]" value="<?php echo $task['agent_name']; ?>">
                            <?php echo $task['agent_name']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="Aconcern[]" value="<?php echo $task['tconcern']; ?>">
                            <?php echo $task['tconcern']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="Aseverity[]" value="<?php echo $task['severity']; ?>">
                            <?php echo $task['severity']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="Adate_start[]" value="<?php echo $task['date_start']; ?>">
                            <?php echo $task['date_start']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="Adate_F[]" value="<?php echo $task['date_end']; ?>">
                            <?php echo $task['date_end']; ?>
                        </td>
                        <td>
                            <select name="status[]">
                                <option value="Pending" <?php echo (isset($task['Astatus']) && $task['Astatus'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Ongoing" <?php echo (isset($task['Astatus']) && $task['Astatus'] == 'Ongoing') ? 'selected' : ''; ?>>Ongoing</option>
                                <option value="Done" <?php echo (isset($task['Astatus']) && $task['Astatus'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                            </select>
                            <input type="hidden" name="Ticket_tnum[]" value="<?php echo $task['Ticket_tnum']; ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" name="update">Update Status</button>
    </form>
</body>
</html>
