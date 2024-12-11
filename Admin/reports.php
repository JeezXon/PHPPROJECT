<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Initialize filter variable
$status_filter = isset($_POST['status']) ? $_POST['status'] : '';

// Prepare the SQL query with the selected filter
$query = "SELECT ATicket_num AS Ticket_num, Clients_Aname AS Client_Name, Agent_Aname, Aconcern AS Concern, Aseverity AS Severity, Adate_start AS Date_start, Adate_F AS Date_end, Astatus AS Status FROM agent_user";
if ($status_filter) {
    $query .= " WHERE Astatus = '" . mysqli_real_escape_string($conn, $status_filter) . "'";
}

$result = mysqli_query($conn, $query);
$reports = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reports[] = $row; 
    }
} else {
    echo "Error fetching data: " . mysqli_error($conn);
}

// PDF generation
if (isset($_POST['generate_pdf'])) {
    header("Content-type: application/pdf");
    header("Content-Disposition: attachment; filename=reportspdf.pdf");
    header("Cache-Control: no-cache");

    // Start output buffering
    ob_start();

    // Create a simple PDF structure
    echo "<h1>Reports</h1>";
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr>
            <th>Ticket#</th>
            <th>Client Name</th>
            <th>Agent Name</th>
            <th>Concern</th>
            <th>Severity</th>
            <th>Date Start</th>
            <th>Date End</th>
            <th>Status</th>
          </tr>";
    
    foreach ($reports as $report) {
        echo "<tr>
                <td>{$report['Ticket_num']}</td>
                <td>{$report['Client_Name']}</td>
                <td>{$report['Agent_Aname']}</td>
                <td>{$report['Concern']}</td>
                <td>{$report['Severity']}</td>
                <td>{$report['Date_start']}</td>
                <td>{$report['Date_end']}</td>
                <td>{$report['Status']}</td>
              </tr>";
    }
    
    echo "</table>";

    // Get the contents of the buffer
    $pdf_content = ob_get_clean();

    // Output the PDF content
    echo $pdf_content;

    exit; // Stop further execution
}

mysqli_close($conn); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REPORTS</title>
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
    <h1>Reports</h1>

    <form method="post" style="margin-bottom: 20px;">
        <label>Filters: </label>
        <select name="status">
            <option value="">All</option>
            <option value="Pending" <?php if ($status_filter === 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="Ongoing" <?php if ($status_filter === 'Ongoing') echo 'selected'; ?>>Ongoing</option>
            <option value="Done" <?php if ($status_filter === 'Done') echo 'selected'; ?>>Done</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <a href="printing.php" target="_blank"><button>Print PDF</button></a>

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
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['Ticket_num']); ?></td>
                        <td><?php echo htmlspecialchars($report['Client_Name']); ?></td>
                        <td><?php echo htmlspecialchars($report['Agent_Aname']); ?></td>
                        <td><?php echo htmlspecialchars($report['Concern']); ?></td>
                        <td><?php echo htmlspecialchars($report['Severity']); ?></td>
                        <td><?php echo htmlspecialchars($report['Date_start']); ?></td>
                        <td><?php echo htmlspecialchars($report['Date_end']); ?></td>
                        <td><?php echo htmlspecialchars($report['Status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
