<!DOCTYPE html>
<html>
<head>
    <meta charset="charset=utf-8">
    <title><?= !empty($pageTitle) ? $pageTitle : "SV Giveaway-er App"  ?></title>
    <?= !empty($styles) ? $styles : '' ?>
</head>
<body>
    <?= $_viewContent ?>
    <?= !empty($scripts) ? $scripts : '' ?>
</body>
</html>