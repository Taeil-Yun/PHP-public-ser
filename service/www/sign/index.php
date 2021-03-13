<html>
    <head>
        <meta charset="utf-8">
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="./js/sign_option.js"></script>
        <style>
            * { margin : 0px; padding : 0px; }
        </style>
    </head>
    <body>
        <form action="./database/db_connect.php" method="post" name="sign_form">
            <p>ID
                <input type="text" name="id_" placeholder="id" id="id_" pattern="^[a-z0-9_-]{6,20}$" required />
                <input type="button" name="id_check" id="id_chk" value="중복확인" />
            </p>
            <p>Password <input type="password" name="password_" id="password" placeholder="password" pattern="^(?=.*[a-zA-Z])(?=.*[^a-zA-Z0-9])(?=.*[0-9]).{8,40}$" required /></p>
            <p>
                <input type="password" name="password_ck" id="password_ck" placeholder="Password Check" />
                <input type="button" name="password_btn" id="password_ok" value="비밀번호 확인" />
            </p>
            <p>Name
                <input type="text" name="f_name_" id="f_name_" placeholder="성" required />
                <input type="text" name="l_name_" placeholder="이름" required />
                <span id="mid_name_box">
                    <input type="checkbox" />Middle Name Use
                </span>
            </p>
            <p>Nick Name <input type="text" name="nick_" placeholder="닉네임" required /></p>
            <p>E-mail <input type="email" name="email_" placeholder="이메일" required /></p>
            <!-- 전화번호 유효성검사를 해주지않는 이유 = 단일국가 서비스가 아니라 글로벌 서비스이기 때문에 국가마다 전화번호가 달라서 유효성검사를 할 수 없음 -->
            <p id="phone_frame">Phone
                <input type="tel" name="phone_" id="phone_" placeholder="휴대번호" required />
                <input type="button" name="phone_ck" id="phone_ck" value="인증번호 받기" onclick="AjaxCall('POST');" />
            </p>
            <p>Country
                <select name="country" required>
                    <option value="">selected</option>
                    <option value="82">한국</option>
                    <option value="1">USA</option>
                    <option value="86">China</option>
                    <option value="81">Japan</option>
                    <option value="63">The Philippines</option>
                </select>
            </p>
            <input type="submit" name="sign_ok" value="가입하기" />
        </form>
    </body>
</html>
<script>
    function createData() {
        // 1. 자바스크립트 객체 형태로 전달
        let send_data = {phone: $('#phone_').val()};
        alert(data);
        return send_data;
    }

    function AjaxCall(method) {
        $.ajax({
            type: method,
            url: "./json.php?mode=" + method,
            data: createData(),
            dataType: "json",
            success: function (data, status, xhr) {
                alert(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });
    }
</script>