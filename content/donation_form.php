<?php
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';

    $nc_counties = [
        "Alamance", "Alexander", "Alleghany", "Anson", "Ashe", "Avery", "Beaufort", "Bertie", "Bladen", "Brunswick",
        "Buncombe", "Burke", "Cabarrus", "Caldwell", "Camden", "Carteret", "Caswell", "Catawba", "Chatham", "Cherokee",
        "Chowan", "Clay", "Cleveland", "Columbus", "Craven", "Cumberland", "Currituck", "Dare", "Davidson", "Davie",
        "Duplin", "Durham", "Edgecombe", "Forsyth", "Franklin", "Gaston", "Gates", "Graham", "Granville", "Greene",
        "Guilford", "Halifax", "Harnett", "Haywood", "Henderson", "Hertford", "Hoke", "Hyde", "Iredell", "Jackson",
        "Johnston", "Jones", "Lee", "Lenoir", "Lincoln", "Macon", "Madison", "Martin", "McDowell", "Mecklenburg",
        "Mitchell", "Montgomery", "Moore", "Nash", "New Hanover", "Northampton", "Onslow", "Orange", "Pamlico",
        "Pasquotank", "Pender", "Perquimans", "Person", "Pitt", "Polk", "Randolph", "Richmond", "Robeson", "Rockingham",
        "Rowan", "Rutherford", "Sampson", "Scotland", "Stanly", "Stokes", "Surry", "Swain", "Transylvania", "Tyrrell",
        "Union", "Vance", "Wake", "Warren", "Washington", "Watauga", "Wayne", "Wilkes", "Wilson", "Yadkin", "Yancey"
    ];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Donation Form</title>
        <link rel="icon" type="image" href="/images/bookbridge1.png">
        <link rel="stylesheet" href="/bookbridgenc/css/style.css">
    </head>

    <body>
        <header><?php include '../includes/header.php'; ?></header>

        <div class="main-container">
            <section class="section-tan">
                <div class="donate-container">
                    <h1>Donation Details</h1>

                    <form action="process_donation.php" method="post" class="donation-form">
                        <div class="form-group">
                            <label for="title">Book Title</label>
                            <input type="text" id="title" name="title" value="<?= htmlspecialchars($title) ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" name="author" value="<?= htmlspecialchars($author) ?>" readonly>
                        </div>

                        <?php if (!empty($isbn) && $isbn !== 'N/A'): ?>
                            <div class="form-group">
                                <label for="isbn">ISBN</label>
                                <input type="text" id="isbn" name="isbn" value="<?= htmlspecialchars($isbn) ?>" readonly>
                            </div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" min="1" required>
                        </div>

                        <div class="form-group">
                            <label for="county">Choose Destination</label>
                            <select id="county" name="county" required>
                                <option value="Let Us Choose">-- Select County or Let Us Choose --</option>
                                <?php foreach ($nc_counties as $county): ?>
                                    <option value="<?= htmlspecialchars($county) ?>"><?= htmlspecialchars($county) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>

                        <div class="form-group">
                            <button type="submit">Submit Donation</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <footer><?php include '../includes/footer.php'; ?></footer>
    </body>
</html>
