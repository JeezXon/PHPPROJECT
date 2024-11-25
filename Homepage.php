<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['ID']) && isset($_SESSION['user_name'])) {
  
    $content = isset($_GET['page']) ? $_GET['page'] : '';

    
    switch ($content) {
        case 'clients':
            $contentFile = 'client.php';
            break;
        case 'agents':
            $contentFile = 'agents.php';
            break;
        case 'assign_task':
            $contentFile = 'assign_task.php';
            break;
        case 'reports':
            $contentFile = 'reports.php';
            break;
        default:
        $contentFile = 'create.php';
        break;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-size: larger;
            display: block;
            margin: 0px;
        }
        .container_home {
            display: flex;
            font-size: 35px;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-start;
            font-family: fantasy, Copperplate;
            
        }
        .text-itemz {
            padding: 10px;
            border: 1px solid blue;
            flex: 1;
            text-align: center;
            text-decoration: none;
            background-color: white;
        }
        .text-itemz:hover {
            background-color: #e0e0e0;
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
} else {
    header("Location: loginSystem.php");
    exit();
}
?>
