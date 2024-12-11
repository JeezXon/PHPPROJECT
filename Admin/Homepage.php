<?php


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (isset($_SESSION['ID']) && isset($_SESSION['user_name'])) {
    // Sanitize the 'page' parameter
    $content = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : '';

    // Map valid pages to corresponding files
    $pageMap = [
        'clients' => 'client.php',
        'agents' => 'Agent.php',
        'assign_task' => 'assign_task.php',
        'reports' => 'reports.php',
    ];

    // Determine content file or use default
    $contentFile = $pageMap[$content] ?? 'create.php';

    // Check if the file exists to avoid including non-existent files
    if (!file_exists($contentFile)) {
        $contentFile = 'create.php';
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../css/home.css">
        <title>Homepage</title>
        <style>
            body {
                font-size: larger;
                margin: 0;
                background: url("b1.png") no-repeat center center fixed;
                background-size: cover;
                font-family: Arial, sans-serif;
            }
            .container_home {
                display: flex;
                gap: 10px;
                padding: 20px;
                justify-content: center;
            }
            .text-itemz {
                padding: 15px 20px;
                border: 1px solid blue;
                text-align: center;
                text-decoration: none;
                background-color: white;
                color: black;
                font-weight: bold;
                border-radius: 5px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }
            .text-itemz:hover {
                background-color: #007BFF;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container_home">
            <a href="?page=clients" class="text-itemz">Clients</a>  
            <a href="?page=agents" class="text-itemz">Agents</a>
            <a href="?page=assign_task" class="text-itemz">Tasks</a>
            <a href="?page=reports" class="text-itemz">Reports</a>
            <a href="logout.php" class="text-itemz">Logout</a>
        </div>

        <div>
            <?php include($contentFile); ?>
        </div>
    </body>
    </html>
    <?php
} 
?>
