<?php
session_start();
define('FPDF_FONTPATH','font/');
require __DIR__ . "/../fpdf.php"; // Adjust the path if necessary
require __DIR__ . "/../Databases/db_connect.php";

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "testbd";

// Connect to the database
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

// Create a new PDF instance
$pdf = new FPDF('L'); // Use 'L' for landscape orientation
$pdf->AddPage();

// Set margins
$pdf->SetMargins(20, 10, 10); // Set left, top, and right margins

// Set title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'REPORTS', 0, 1, 'C');

// Set column headers
$pdf->SetFont('Arial', 'B', 10); // Smaller font size for headers
$pdf->Cell(20, 10, 'Ticket#', 1);
$pdf->Cell(30, 10, 'Client Name', 1);
$pdf->Cell(35, 10, 'Agent Name', 1);
$pdf->Cell(60, 10, 'Concern', 1);
$pdf->Cell(30, 10, 'Severity', 1);
$pdf->Cell(30, 10, 'Date Start', 1);
$pdf->Cell(30, 10, 'Date End', 1);
$pdf->Cell(20, 10, 'Status', 1);
$pdf->Ln();

// Set font for table data
$pdf->SetFont('Arial', '', 9); // Slightly larger font size for better readability

// Add data to table
if (!empty($reports)) {
    foreach ($reports as $report) {
        $pdf->Cell(20, 10, htmlspecialchars($report['Ticket_num']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($report['Client_Name']), 1);
        $pdf->Cell(35, 10, htmlspecialchars($report['Agent_Aname']), 1);
        $pdf->Cell(60, 10, htmlspecialchars($report['Concern']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($report['Severity']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($report['Date_start']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($report['Date_end']), 1);
        $pdf->Cell(20, 10, htmlspecialchars($report['Status']), 1);
        $pdf->Ln();
    }
} else {
    // If no reports available
    $pdf->Cell(0, 10, 'No data available.', 0, 1, 'C');
}

// Output the PDF
$pdf->Output('I', 'ticketreports.pdf'); // 'I' to display the PDF inline
?>
