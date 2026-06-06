<?php
    $query = trim(filter_input(INPUT_GET, 'query', FILTER_SANITIZE_STRING) ?? '');
    $results = [];

    if ($query !== '') {
        $type = trim(filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING) ?? 'title');
        $param = in_array($type, ['title', 'author', 'isbn']) ? $type : 'title';
        $url = "https://openlibrary.org/search.json?" . $param . "=" . urlencode($query) . "&limit=50";

        $response = file_get_contents($url);
        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['docs'])) {
                foreach ($data['docs'] as $book) {
                    $title = $book['title'] ?? 'No Title';
                    $author = $book['author_name'][0] ?? 'Unknown Author';
                    $isbn = $book['isbn'][0] ?? 'N/A';
                    $coverId = $book['cover_i'] ?? null;

                    // Capitalize author and title correctly
                    $title = ucwords(strtolower($title));
                    $author = ucwords(strtolower($author));

                    $results[] = [
                        'title' => $title,
                        'author' => $author,
                        'isbn' => $isbn,
                        'cover_id' => $coverId
                    ];
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search Results</title>
        <link rel="icon" type="image" href="/images/bookbridge1.png">
        <link rel="stylesheet" href="/bookbridgenc/css/style.css" />
    </head>

    <body>
        <header><?php include '../includes/header.php'; ?></header>

        <div class="results-container">
            <h1>Search results for:</h1>
            <p class="results-string">
                <strong>
                    <?php
                    if ($_GET['type'] === 'isbn') {
                        echo strtoupper('ISBN');
                    } else {
                        echo ucwords($_GET['type']);
                    }
                    ?>:
                </strong> <i><?= htmlspecialchars($_GET['query']) ?></i>
            </p>
            <?php if (empty($results)): ?>
                <p class="no-results">No results found. <br>Please ensure the correct search type was selected or try a different search term.</p>
            <?php else: ?>
                <ul class="book-results">
                    <?php foreach ($results as $book): ?>
                        <li class="book-entry">
                            <?php if (!empty($book['cover_id'])): ?>
                                <img class="book-cover"
                                     src="https://covers.openlibrary.org/b/id/<?= htmlspecialchars($book['cover_id']) ?>-M.jpg"
                                     alt="Book Cover"
                                     onerror="this.onerror=null; this.src='https://via.placeholder.com/80x120?text=No+Image';" />
                            <?php else: ?>
                                <div class="book-cover no-cover">No Image Available</div>
                            <?php endif; ?>
                            <div class="book-info">
                                <strong><?= htmlspecialchars($book['title']) ?></strong><br />
                                <em><?= htmlspecialchars($book['author']) ?></em><br />
                                <?php if ($book['isbn'] !== 'N/A'): ?>
                                    ISBN: <?= htmlspecialchars($book['isbn']) ?>
                                <?php endif; ?>
                            </div>

                            <div class="book-button">
                                <form action="donation_form.php" method="post">
                                    <input type="hidden" name="title" value="<?= htmlspecialchars($book['title']) ?>" />
                                    <input type="hidden" name="author" value="<?= htmlspecialchars($book['author']) ?>" />
                                    <input type="hidden" name="isbn" value="<?= htmlspecialchars($book['isbn']) ?>" />
                                    <button type="submit">Donate this Book</button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <footer><?php include '../includes/footer.php'; ?></footer>
    </body>
</html>
