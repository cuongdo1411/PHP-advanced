<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo !empty($page_title) ? $page_title : 'Trang chủ website' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?php echo WEB_ROOT; ?>/public/assets/clients/css/style.css" />

</head>

<body>
    <div class="container">
        <?php
        $this->render('blocks/header');

        if (!empty($content) && !empty($sub_content)) {
            $this->render($content, $sub_content); // content: products/detail, sub_content: [info, title]
        }

        $this->render('blocks/footer');
        ?>
    </div>

    <script type="text/javascript" src="<?php echo WEB_ROOT; ?>/public/assets/js/script.js"></script>
</body>

</html>