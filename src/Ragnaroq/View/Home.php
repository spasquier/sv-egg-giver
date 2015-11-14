<!DOCTYPE html>
<html>
<head>
    <meta charset="charset=utf-8">
    <title>Shiny Value Egg Giveaway-er</title>
</head>
<body>
<h1>Reddit Profile</h1>
<table>
    <tbody>
    <tr>
        <td><strong>Name</strong></td>
        <td><?= $me['name'] ?></td>
    </tr>
    <tr>
        <td><strong>Registered (UTC)</strong></td>
        <td><?= date('Y-m-d H:i:s', strtotime($me['created_utc'])) ?></td>
    </tr>
    <tr>
        <td><strong>Link Karma</strong></td>
        <td><?= $me['link_karma'] ?></td>
    </tr>
    <tr>
        <td><strong>Comment Karma</strong></td>
        <td><?= $me['comment_karma'] ?></td>
    </tr>
    <tr>
        <td><strong>Over 18?</strong></td>
        <td><?= $me['over_18'] ? 'Yes' : 'No' ?></td>
    </tr>
    </tbody>
</table>
</body>
</html>