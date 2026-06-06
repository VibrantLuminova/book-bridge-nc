<?php
    require_once '../includes/db_connect.php';

    // Function to log errors when submitting a donation
    function log_error($message) {
        $logFile = __DIR__ . '/../logs/error_log.txt';
        $timestamp = date("Y-m-d H:i:s");
        $entry = "[$timestamp] $message\n";
        file_put_contents($logFile, $entry, FILE_APPEND);
    }

    // Get form data from donation_form.php
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? null;
    $quantity = $_POST['quantity'] ?? 0;
    $county = $_POST['county'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($title && $author && $quantity && $county && $email) {
        $stmt = $conn->prepare("INSERT INTO donation_inventory (title, author, isbn, quantity, county, email) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssiss", $title, $author, $isbn, $quantity, $county, $email);
            if ($stmt->execute()) {
                $donationNumber = $stmt->insert_id;
            } else {
                log_error("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        } else {
            log_error("Prepare failed: " . $conn->error);
        }
    } else {
        log_error("Missing form input data");
    }

    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Donation Confirmation</title>
        <link rel="icon" type="image" href="/images/bookbridge1.png">
        <link rel="stylesheet" href="/bookbridgenc/css/style.css">
    </head>

    <body class="process_donation">
        <header><?php include '../includes/header.php'; ?></header>

        <div class="main-container">
            <section class="section-tan">
                <div class="content-wrapper">
                    <?php if (isset($donationNumber)): ?>
                        <h1>Thank you for your donation!</h1>
                        <p>Your donation number is <strong><?= htmlspecialchars($donationNumber) ?></strong>.</p>
                        <p>You will receive an email including this number and the following instructions at <strong><?= htmlspecialchars($email) ?></strong>.</p><br>
                        <p><strong>Drop-off Instructions:</strong></p>
                        <p>Please write your donation number on a piece of paper and slide it under the cover of the book.</p>
                        <p>Wrap the book and drop it off at one of our donation bins!</p>

                    <?php else: ?>
                        <h2>Oops! Something went wrong.</h2>
                        <p>We couldn't process your donation. Please try again.</p>
                        <div class="error-actions">
                            <a href="javascript:history.back()" class="button">Go Back</a>
                            <a href="/content/donate.php" class="button">Start Over</a>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>

        <footer><?php include '../includes/footer.php'; ?></footer>
    </body>
</html>
