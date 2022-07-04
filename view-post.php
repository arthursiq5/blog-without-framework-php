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
$bodyText = htmlEscape($row['body']);
$paraText = str_replace("\n", "</p><p>", $bodyText);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?= htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'templates/title.php'; ?>
        <h2>
            <?= htmlEscape($row['title']) ?>
        </h2>
        <div>
            <?= convertSqlDate($row['created_at']) ?>
        </div>
        <p>
            <?= $paraText ?>
        </p>

        <h3><?php echo countCommentsForPost($postId) ?> comments</h3>
        <?php foreach (getCommentsForPost($postId) as $comment): ?>
            <?php // For now, we'll use a horizontal rule-off to split it up a bit ?>
            <hr />
            <div class="comment">
                <div class="comment-meta">
                    Comment from
                    <?php echo htmlEscape($comment['name']) ?>
                    on
                    <?php echo convertSqlDate($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo htmlEscape($comment['text']) ?>
                </div>
            </div>
        <?php endforeach ?>
    </body>
</html>
