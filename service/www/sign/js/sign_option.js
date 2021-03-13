window.onload = function() {
    let mid_name_box = document.getElementById("mid_name_box");
    let sign_ok = document.getElementsByName("sign_ok")[0];
    let password_ok = document.getElementById("password_ok");

    mid_name_box.addEventListener('change', (event) => {
        let cre_input = document.createElement("input");
        cre_input.name = "m_name";
        cre_input.id = "m_name_";
        cre_input.placeholder = "중간이름";
        if(event.target.checked) {
            document.getElementById("f_name_").after(cre_input);
            m_name_.style.marginLeft = "5px";
        } else {
            document.getElementById("m_name_").remove();
        }
    });

    let phone_ck = document.getElementById("phone_ck");
    phone_ck.addEventListener("click", function(event) {
        // p태그 생성
        let cre_p = document.createElement("p");
        cre_p.id = "p_listener1";
        cre_p.innerHTML = "인증번호 ";
        if(event.target.click) {
            // 생성된 p태그 휴대폰번호 입력칸 다음 요소로 추가
            document.getElementById("phone_frame").after(cre_p);
            // input태그(인증번호 입력칸) 생성
            let cre_phone = document.createElement("input");
            cre_phone.name = "phone_certification";
            cre_phone.id = "phone_certification";
            cre_phone.placeholder = "인증번호 입력";
            cre_phone.style.marginRight = "5px";
            // input태그(인증번호 확인버튼) 생성
            let certification_btn = document.createElement("input");
            // certification_btn.onclick = function() { _call(); }
            certification_btn.type = "button";
            certification_btn.id = "certification_btn";
            certification_btn.name = "certification_btn";
            certification_btn.value = "인증번호 확인";
            // 생성된p태그 자식요소로 추가
            document.getElementById("p_listener1").append(cre_phone);
            document.getElementById("p_listener1").append(certification_btn);
        }
        this.removeEventListener("click",arguments.callee);  // once call event listener
    });
    // function _call() {
    // <?php
    //         $phone_ = document.getElementById("phone_").value;
    //     $replace_p = str.replace("-", "", $phone_);
    //     $con = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE", "PORT") or die(mysqli_error($con));
    //
    //     $tel_search = mysqli_query($con, "SELECT hash FROM `phone_auth` WHERE mem_key='".$replace_p."' AND ck='0' ORDER BY mem_key DESC LIMIT 1") or die(mysqli_error($con));
    //     $tel_match  = mysqli_num_rows($tel_search);
    //     if($tel_match ==  document.getElementById("cre_phone").value) {
    //         mysqli_query($con, "UPDATE `phone_auth` SET ck='1' WHERE mem_key='".$replace_p."' AND ck='0'") or die(mysqli_error($con));
    //         mysqli_close($con);
    //         include_once './js/phone_check_ok.php';
    //     } else {
    //         mysqli_close($con);
    //         include_once './js/phone_check_fail.php';
    //     }
    //         ?>
    // }

    // jQuery("#id_check_btn").click(function() {  // id 중복확인
    //     if (jQuery("#id").val().trim() == "") {
    //     if (jQuery("#id").val().trim() == "") {
    //         alert("아이디를 입력해주세요");
    //         jQuery("#id").focus();
    //
    //     } else if (!regexId.test(jQuery("#id").val().trim())) {
    //         alert ("아이디는 6~20자의 영문 대소문자와 숫자, 특수문자 - , _ 만 가능합니다");
    //         return false;
    //     }else{
    //         location.href="idCheck.php?id="+jQuery("#id").val().trim();
    //     }
    // });

    let password_flag = 0;
    password_ok.onclick = function() {
        if(document.getElementById("password").value == '' && document.getElementById("password_ck").value == '') {
            alert("Password is not exsists");
        } else {
            if(document.getElementById("password").value != document.getElementById("password_ck").value) {
                alert("Password is not the same");
                password_flag = 0;
            } else {
                alert("Password is the same");
                password_flag = 1;
            }
        }
    }

    sign_ok.onclick = function(e) {
        if(document.getElementsByName("country")[0].value == '') {
            alert("Please select country");
        } else if(password_flag == 0) {
            alert("Please check the password duplicate");
            e.preventDefault();
        } else {}
    }
}