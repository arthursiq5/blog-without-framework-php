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
?>
<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'templates/title.php'; ?>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <h2>
                <?= htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
            </h2>
            <div>
                <?= $row['created_at'] ?>
            </div>
            <p>
                <?= htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?= $row['id'] ?>">Read more...</a>
            </p>
        <?php endwhile; ?>
    </body>
</html>
