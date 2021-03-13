<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
    <div>
        <div>
            <h1>Sign Up</h1>
        </div>
        <form action="sign_ok.php" method="post">
            <div>
                <!-- ID input -->
                <section>
                    <h3>
                        <label>아이디</label>
                    </h3>
                    <article>
                        <input type="text" name="id" placeholder="ID input" required />
                        <input type="hidden" name="id_flag" value="0" />
                    </article>
                </section>
                <!-- password input -->
                <section>
                    <h3>
                        <label>비밀번호</label>
                    </h3>
                    <article>
                        <input type="password" name="password" placeholder="password input" required />
                        <i class="xi-unlock-o"></i>
                        <i class="xi-lock-o"></i>
                    </article>
                </section>
                <!-- password check -->
                <section>
                    <h3>
                        <label>비밀번호 재확인</label>
                    </h3>
                    <article>
                        <input type="password" name="password_ck" placeholder="Re-enter Password" required />
                        <i class="xi-unlock-o"></i>
                        <i class="xi-lock-o"></i>
                    </article>
                </section>
                <!-- name input -->
                <section>
                    <h3>
                        <label>이름</label>
                    </h3>
                    <article>
                        <input type="text" name="name" placeholder="Name" required />
                    </article>
                </section>
                <!-- birth -->
                <section>
                    <h3>
                        <label>생년월일</label>
                    </h3>
                    <article>
                        <input type="text" name="birth" placeholder="년(4자)" required />
                        <select name="month">
                            <option>월</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                        <input type="text" name="day" placeholder="일" required />
                        <input type="hidden" id="nick_ck" value="0" />
                    </article>
                </section>
                <!-- sex select -->
                <section>
                    <h3>
                        <label>성별</label>
                    </h3>
                    <article>
                        <select name="sex">
                            <option>성별</option>
                            <option value="man">남자</option>
                            <option value="woman">여자</option>
                        </select>
                    </article>
                </section>
                <!-- E-mail input -->
                <section>
                    <h3>
                        <label>본인 확인 이메일</label>
                    </h3>
                    <article>
                        <input type="text" name="email" placeholder="Use for email authentication" required /> @
                        <input type="text" name="d_email" readonly />
                        <select name="b_email">
                            <option>선택</option>
                            <option value="@naver.com">naver.com</option>
                            <option value="@gmail.com">gmail.com</option>
                            <option value="@daum.net">daum.net</option>
                            <option value="@nate.com">nate.com</option>
                            <option value="@<?php $self=''; ?>">직접 입력</option>
                        </select>
                    </article>
                </section>
            </div>
            <div>
                <input type="button" name="btn_back" value="Prev" onclick="javascript:history.back();" />
                <input type="submit" name="btn_sign" value="Sign Up" />
            </div>
        </form>
    </div>
</body>
</html>