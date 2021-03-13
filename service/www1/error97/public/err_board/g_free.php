<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-ico" href="../../static/images/favicon/favicon.ico" />
    <link rel="stylesheet" href="../../static/css/defaults.css?ver=0" />
    <link rel="stylesheet" href="../../static/css/header.css?ver=0" />
    <link rel="stylesheet" href="../../static/css/btn_move.css" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="../../static/js/e_mousewheel.js?ver=4"></script>
    <script type="text/javascript" src="../../static/js/scroll_header.js"></script>
    <title>free board</title>
    <style>
        .b_fr {
            position: relative;
            top: 70px;
            background-color:red;
        }
        .b_fr .b_area .gr_ftitle { height: 300px; }
        .b_fr .b_area .gr_ftitle div:first-child h1 {
            font-size: 30px;
        }
    </style>
</head>
<body>
    <?php include "../header.php"; ?>
    <div class="b_fr">
        <section class="b_area">
            <article class="gr_ftitle">
                <div>
                    <h1>free bulletin board</h1>
                </div>
            </article>
            <article class="gr_contents"></article>
            <a href="./free/write_skin.php">write</a>
        </section>
    </div>
    <?php include "../btn_move.php"; ?>
</body>
</html>