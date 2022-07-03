<?php

require_once 'lib/common.php';

$pdo = getPDO();

if (isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];
} else {
    // So we always have a post ID var defined
    $postId = 0;
}

$stmt = $pdo->prepare(
    'SELECT
        title, created_at, body
    FROM
        post
    WHERE
        id = :id'
);
if ($stmt === false) {
    throw new Exception('There was a problem preparing this query');
}
$result = $stmt->execute(['id' => 1]);
if ($result === false) {
    throw new Exception('There was a problem running this query');
}
// Let's get a row
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?= htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'templates/title.php'; ?>
        <h2>
            <?= htmlspecialchars($row['title'], ENT_HTML5, 'UTF-8') ?>
        </h2>
        <div>
            <?= $row['created_at'] ?>
        </div>
        <p>
            <?= htmlspecialchars($row['body'], ENT_HTML5, 'UTF-8') ?>
        </p>
    </body>
</html>
