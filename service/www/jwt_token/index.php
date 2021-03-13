<html>
    <head>
        <meta charset="utf-8">
        <title>main</title>
        <style>
            * { margin : 0px;
                padding : 0px;
            }
            input[name="signUp_ok"] {
                display: inline-block;
                width: 80px;
            }
        </style>
    </head>
    <body>
        <h1>home</h1>
        <?php
            if(isset($_COOKIE['JWT'])){
                echo "<p>안녕하세요 ". $_COOKIE['name'] ."님</p>";
                echo "<input type=\"button\" name=\"logout\" value=\"로그아웃\" onclick=\"location.href='./logout.php'\" />";
            }else{
                echo "<input type=\"button\" name=\"signUp_ok\" value=\"회원가입\" onclick=\"location.href='./sign.php'\" />";
                echo "<input type=\"button\" name=\"login\" value=\"로그인\" onclick=\"location.href='./login_ok.php'\" />";
            }
        ?>
    </body>
</html>