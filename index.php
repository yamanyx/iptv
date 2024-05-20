<?php
// Read the JSON file
$jsonData = file_get_contents("../httpcanary.json");

// Decode JSON data
$data = json_decode($jsonData, true);

// Check if delete action is triggered
if (isset($_GET['delete'])) {
    $deviceIdToDelete = $_GET['delete'];
    
    // Remove the device with the given ID
    foreach ($data as $key => $device) {
        if ($device['deviceId'] === $deviceIdToDelete) {
            unset($data[$key]);
            break;
        }
    }
    
    // Encode data back to JSON
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    
    // Write back to the file
    file_put_contents("../httpcanary.json", $jsonData);
    
    // Redirect to refresh the page
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// Count total devices
$totalDevices = count($data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTTP Canary Devices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .delete-btn {
            background-color: #ff0000;
            color: #ffffff;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #cc0000;
        }
        .total-devices {
            margin-top: 20px;
            text-align: center;
        }
		.content {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 10px;
    max-width: 850px;
}
    </style>
</head>
<body>
<div class="content">
    <h1>HTTP Canary Devices</h1>
	<p class="total-devices">Total Devices: <?= $totalDevices ?></p>
    <table>
        <tr>
            <th>Device ID</th>
            <th>Date Created</th>
            <th>Action</th>
        </tr>
        <?php foreach ($data as $device): ?>
            <tr>
                <td><?= $device['deviceId'] ?></td>
                <td><?= $device['date'] ?></td>
                <td>
                    <form method="GET" action="">
                        <input type="hidden" name="delete" value="<?= $device['deviceId'] ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
