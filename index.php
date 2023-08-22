<?php
// Import the required classes and functions
require_once 'aurora.php';

// Initialize Aurora API with credentials
$auroraAPI = new AuroraAPI(
    'app_name', 
    'app_secret', 
    'app_hash', 
    'app_version', 
    'https://aurora-licensing.pro/api/lite/index.php'
);

// Initialize variables for errors
$initError = '';
$loginError = '';

// Initialize response and handle initialization errors
$response = $auroraAPI->initializeAPI();
if (isset($response['error'])) {
    $initError = 'Initialization error: ' . $response['error'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $license = $_POST['license'];

    // Check the license using the Aurora API
    $response = $auroraAPI->checkLicense($license);

    if (isset($response['message']) && $response['message'] === 'License is valid') {
        // Start a session and redirect to the dashboard upon successful login
        session_start();
        $_SESSION['username'] = $license;
        header('Location: dashboard/index.php');
        exit;
    } else {
        $loginError = 'Invalid license or other error occurred.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <!-- External styles and scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="icon" href="https://aurora-licensing.pro/images/logo.png" type="image/png">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <img src="https://aurora-licensing.pro/images/logo.png" alt="Aurora Logo" class="logo">
                <h3 class="card-title">AURORA</h3>
            </div>
            <div class="card-body">
                <!-- Login form -->
                <form action="" method="post">
                    <div class="form-group">
                        <label for="license" class="form-label">License Key</label>
                        <input type="text" class="form-control" id="license" name="license" required>
                        <!-- Display login error if present -->
                        <?php if (isset($loginError)) { ?>
                            <div class="error-message">
                                <?php echo $loginError; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Disable login button if initialization error exists -->
                    <button type="submit" class="btn btn-primary" <?php if ($initError) echo "disabled"; ?>>Login</button>
                </form>
            </div>
        </div>
    </div>
    
    <?php if ($initError) { ?>
        <script>
            // Show the initialization error modal when the page loads
            window.addEventListener('load', function() {
                var initErrorModal = new bootstrap.Modal(document.getElementById('initErrorModal'));
                initErrorModal.show();
            });
        </script>
    <?php } ?>
    
    <!-- Bootstrap scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>