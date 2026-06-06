<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Donate a Book</title>
        <link rel="icon" type="image" href="/images/bookbridge1.png">
        <link rel="stylesheet" href="/bookbridgenc/css/style.css" />
        <script src="/bookbridgenc/js/script.js"></script>
    </head>

    <body>
        <header><?php include '../includes/header.php'; ?></header>

        <div class="main-container">
            <section class="section-green">
                <div class="content-wrapper">
                    <p class="quote">"Low levels of literacy costs the US up to 2.2 trillion per year."</p>
                    <p class="quote-source">&mdash; <a href="http://www.thinkimpact.com/literacy-statistics/" target="_blank">Think Impact</a> </p>
                </div>
            </section>

            <section class="section-split"></section>

            <section class="section-tan">
                <div class="content-wrapper">
                    <h1 class="centered">Donate a Book</h1>
                    <p class="centered">Thank you for showing an interest in donating a book! <br>Please use the following search bar to find the book you would like to donate!</p>

                    <div class="donate-container">
                        <form action="search_results.php" method="get" class="donate-search-form">
                            <div class="search-label-container">
                                <label for="query">Search for a book by:</label>
                                <div class="search-type">
                                    <label><input type="radio" name="type" value="title" checked> Title</label>
                                    <label><input type="radio" name="type" value="author"> Author</label>
                                    <label><input type="radio" name="type" value="isbn"> ISBN</label>
                                </div>
                            </div>
                            <input type="text" id="query" name="query" placeholder="Start searching" required />
                            <button type="submit">Search</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <footer><?php include '../includes/footer.php'; ?></footer>
    </body>
</html>
