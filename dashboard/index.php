<?php
// Start the session and check for user authentication
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}

$username = $_SESSION['username'];

// Import required classes and initialize Aurora API
require_once '../aurora.php';

$auroraAPI = new AuroraAPI(
    'app_name', 
    'app_secret', 
    'app_hash', 
    'app_version', 
    'https://aurora-licensing.pro/api/lite/index.php'
);

// Retrieve subscription information
$response = $auroraAPI->checkSub($username);
$subscriptionValue = isset($response['subscription']) ? $response['subscription'] : 0;

// Map subscription values to descriptive strings
$subscriptionMapping = [
    0 => 'Unknown',
    1 => 'Free',
    2 => 'Basic',
    3 => 'Premium'
];

$licenseSubscription = isset($subscriptionMapping[$subscriptionValue]) ? $subscriptionMapping[$subscriptionValue] : 'Unknown';

// Retrieve used date, expiry date, and HWID
$response = $auroraAPI->usedDate($username);
$usedDate = isset($response['used_date']) ? $response['used_date'] : 'Unknown';

$response = $auroraAPI->checkExpiry($username);
$expiryDate = isset($response['expiry_date']) ? $response['expiry_date'] : 'Unknown';

$response = $auroraAPI->getHWID($username);
$licenseHWID = isset($response['hwid']) ? $response['hwid'] : 'Unknown';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- External styles and scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <style>
        /* Custom list group styles */
        .list-group {
            background-color: #292b2c;
            border-color: #292b2c;
        }

        .list-group-item {
            background-color: #1e1e1e;
            border-color: #292b2c;
            color: #ffffff;
        }
    </style>
    <link rel="icon" href="https://aurora-licensing.pro/images/logo.png" type="image/png">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <img src="https://aurora-licensing.pro/images/logo.png" alt="Aurora Logo" class="logo">
                <h3 class="card-title">AURORA</h3>
            </div>
            <div class="card-body">
                <!-- User information -->
                <h5 class="card-title">Welcome, <?php echo $username; ?>!</h5>
                <ul class="list-group mt-3">
                    <li class="list-group-item">License: <?php echo $username; ?></li>
                    <li class="list-group-item">License Subscription: <?php echo $licenseSubscription; ?></li>
                    <li class="list-group-item">License Used Date: <?php echo $usedDate; ?></li>
                    <li class="list-group-item">License Expiry Date: <?php echo $expiryDate; ?></li>
                    <li class="list-group-item">License HWID: <?php echo $licenseHWID; ?></li>
                </ul>
                <!-- Download Loader, Contact Us and Logout buttons -->
                <div class="mt-4">
                    <a href="download/loader.exe" class="btn btn-primary">Download Loader</a>
                    <a href="../contact/index.php" class="btn btn-primary">Contact Us</a>
                    <a href="../logout/index.php" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
