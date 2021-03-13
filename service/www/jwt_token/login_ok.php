<html>
    <head>
        <meta chatset="utf-8">
        <title>로그인</title>
        <style>
            * { margin : 0px;
                padding : 0px;
            }
        </style>
    </head>
    <body>
        <form action="./api/login.php" method="post" name="sign_up">
            <h1>로그인</h1>
            <section>
                <article><span>아이디 : </span><input type="text" name="id" placeholder="ID" maxlength="20" required autocomplete=off /></article>
                <article><span>비밀번호 : </span><input type="password" name="password" placeholder="Password" maxlength="20" required autocomplete=off /></article>
            </section>
            <input type="submit" name="login" value="로그인" />
        </form>
    </body>
</html>