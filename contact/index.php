<?php
$webhookUrl = ''; // Replace with your actual Discord webhook URL

$botName = 'Aurora Panel'; // Replace with your actual Discord bot name
$botAvatar = 'https://aurora-licensing.pro/images/logo.png'; // Replace with your actual Discord bot name

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $discordTag = $_POST['discordTag'];
    $message = $_POST['message'];

    // Construct the embed to send to the webhook
    $embed = [
        'title' => 'New Contact Request',
        'description' => "A new contact request has been received from $email.",
        'color' => hexdec('0099ff'), // You can change the color here
        'fields' => [
            [
                'name' => 'Email',
                'value' => $email,
                'inline' => false
            ],
            [
                'name' => 'Discord Tag',
                'value' => $discordTag,
                'inline' => false
            ],
            [
                'name' => 'Message',
                'value' => $message,
                'inline' => false
            ]
        ],
        'footer' => [
            'text' => "$botName - Contact Us"
        ]
    ];

    $webhookData = json_encode(['embeds' => [$embed]]);

    // Send the webhook
    $ch = curl_init($webhookUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $webhookData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_exec($ch);
    curl_close($ch);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- External styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="icon" href="https://aurora-licensing.pro/images/logo.png" type="image/png">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <img src="https://aurora-licensing.pro/images/logo.png" alt="Aurora Logo" class="logo">
                <h3 class="card-title">Contact Us</h3>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="discordTag" class="form-label">Discord Tag</label>
                        <input type="text" class="form-control" id="discordTag" name="discordTag">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                    <a href="../dashboard/index.php" class="btn btn-primary">Return To Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
