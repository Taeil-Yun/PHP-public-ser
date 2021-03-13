<html>
    <head>
        <meta chatset="utf-8">
        <title>회원가입</title>
        <style>
            * { margin : 0px;
                padding : 0px;
            }
            input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            form[name="sign_up"] > section:nth-child(2) > article > span:first-child  {
                display : inline-block;
                width : 80px;
            }
        </style>
    </head>
    <body>
        <form action="./api/create_user.php" method="post" name="sign_up">
            <h1>회원가입</h1>
            <section>
                <article><span>아이디 : </span><input type="text" name="id" placeholder="ID" maxlength="20" required autocomplete=off /></article>
                <article><span>비밀번호 : </span><input type="password" name="password" placeholder="Password" maxlength="20" required autocomplete=off /></article>
                <article><span>휴대전화 : </span><input type="text" name="phone" placeholder="phone" maxlength="13" autocomplete=off /></article>
                <article><span>이메일 : </span><input type="email" name="email" placeholder="email" required autocomplete=off /></article>
                <article><span>이름 : </span><input type="text" name="u_name" placeholder="name" required autocomplete=off /></article>
            </section>
            <input type="button" name="backs" value="뒤로가기" onclick="location.href='./index.php'" />
            <input type="submit" name="signUp_ok" value="가입" />
        </form>
    </body>
</html>