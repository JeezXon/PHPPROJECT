<?php


$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


function get_next_ticket_number($conn) {
    $conn->query("UPDATE ticket_counter SET current_ticket_number = LAST_INSERT_ID(current_ticket_number + 1)");
    $result = $conn->query("SELECT LAST_INSERT_ID()");
    return $result->fetch_row()[0];
}

$clients = [];
$result = $conn->query("SELECT Client_name FROM clients");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}


$agents = [];
$result = $conn->query("SELECT agent_name FROM agents"); 
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $agents[] = $row;
    }
}


$tasks = [];
$result = $conn->query("SELECT t.Ticket_tnum, c.Client_name, a.agent_name, t.tconcern, t.severity, t.date_start, t.date_end 
FROM tasks t 
JOIN clients c ON t.client_tname = c.Client_name
JOIN agents a ON t.agent_tname = a.agent_name");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agent_tname = $_POST['agent_tname'];
    $tconcern = $_POST['tconcern'];
    $severity = $_POST['severity'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $client_name = $_POST['Client_name'];
    
    if (!empty($client_name)) {
        $Ticket_tnum = get_next_ticket_number($conn);

        $sql = "INSERT INTO tasks (Ticket_tnum, client_tname, agent_tname, tconcern, severity, date_start, date_end) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssss", $Ticket_tnum, $client_name, $agent_tname, $tconcern, $severity, $date_start, $date_end);

        if ($stmt->execute()) {

            $result = $conn->query("SELECT t.Ticket_tnum, c.Client_name, a.agent_name, t.tconcern, t.severity, t.date_start, t.date_end 
            FROM tasks t 
            JOIN clients c ON t.client_tname = c.Client_name
            JOIN agents a ON t.agent_tname = a.agent_name");

            $tasks = [];
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        } else {
            echo "<p>Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <style>
        h1 {
            display: flex;
            justify-content: center;
        }
        div.container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }
        form.d {
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
        table.t {
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
    <div class="container">
        <form id="taskForm" method="POST" action="" class="d">
            <h1>TASKS</h1>
            <label>Client Name</label>
            <select name="Client_name" onchange="this.form.submit()" required>
                <option value="">Select a Client</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?php echo $client['Client_name']; ?>" <?php echo isset($_POST['Client_name']) && $_POST['Client_name'] === $client['Client_name'] ? 'selected' : ''; ?>>
                        <?php echo $client['Client_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label>Agent Assign:</label>
            <select name="agent_tname" required>
                <option value="">Select an Agent</option>
                <?php foreach ($agents as $agent): ?>
                    <option value="<?php echo $agent['agent_name']; ?>"><?php echo $agent['agent_name']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Concern:</label>
            <input type="text" name="tconcern" required placeholder="Concern"><br>

            <label>Severity:</label>
            <select name="severity" required>
                <option value="Normal">Normal</option>
                <option value="Medium">Medium</option>
                <option value="Severe">High</option>
            </select><br>

            <label for="date_start">Date Start:</label>
            <input type="date" name="date_start" required><br>

            <label for="date_end">Date to Finish:</label>
            <input type="date" name="date_end" required><br>

            <button type="submit">Submit</button>
            <button type="button" onclick="window.location.href='Homepage.php'">Back</button>
        </form>
    </div>
    <table class="t">
        <thead>
            <tr>
                <th>Ticket#</th>
                <th>Client Name</th>
                <th>Agent Name</th>
                <th>Concern</th>
                <th>Severity</th>
                <th>Date Start</th>
                <th>Date to Finish</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo $task['Ticket_tnum']; ?></td>
                    <td><?php echo $task['Client_name']; ?></td>
                    <td><?php echo $task['agent_name']; ?></td>
                    <td><?php echo $task['tconcern']; ?></td>
                    <td><?php echo $task['severity']; ?></td>
                    <td><?php echo $task['date_start']; ?></td>
                    <td><?php echo $task['date_end']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
