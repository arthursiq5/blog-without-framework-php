<?php

require_once 'lib/common.php';

$pdo = getPDO();

$stmt = $pdo->query(
    'SELECT
        id, title, created_at, body
    FROM
        post
    ORDER BY
        created_at DESC'
);
if ($stmt === false)
{
    throw new Exception('There was a problem running this query');
}
$notFound = isset($_GET['not-found']);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'templates/title.php'; ?>

        <?php if ($notFound): ?>
            <div style="border: 1px solid #ff6666; padding: 6px;">
                Error: cannot find the requested blog post
            </div>
        <?php endif ?>

        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?= htmlEscape($row['title']) ?>
            </h2>
            <div>
                <?= convertSqlDate($row['created_at']) ?>
            </div>
            <p>
                <?= htmlEscape($row['body']) ?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?= $row['id'] ?>">Read more...</a>
            </p>
        <?php endwhile; ?>
    </body>
</html>
