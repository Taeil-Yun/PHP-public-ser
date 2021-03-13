<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-ico" href="../../../static/images/favicon/favicon.ico" />
    <link rel="stylesheet" href="../../../static/css/defaults.css?ver=0" />
    <link rel="stylesheet" href="../../../static/css/header.css?ver=0" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script>
    <script type="text/javascript" src="../../../static/js/scroll_header.js"></script>
    <title>free board</title>
    <style>

    </style>
</head>
<body>
    <?php include "../../header.php"; ?>
    <div>
        <form action="">
            <section>
                <article>
                    <div>제목</div>
                    <div>
                        <input type="text" name="title" />
                    </div>
                </article>
                <article>
                    <textarea name="content" id="editor"></textarea>
                </article>
            </section>
        </form>
    </div>
</body>
</html>

<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error=>{console.error(error);});
</script>