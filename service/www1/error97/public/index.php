<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <meta name="google-site-verification" content="xe61wiR_H7YUoeKzxAlgj1P5laWRDQFm6iTwfCPj760" />-->
<!--    <title>Booom!</title>-->
<!--    <style>-->
<!--        * { margin : 0px; padding : 0px; }-->
<!--        html, body { width : 100%; height : 100%; overflow : hidden; }-->
<!--        #back {-->
<!--            width : 100%;-->
<!--            height : 100%;-->
<!--            background-color : transparent;-->
<!--            font-size : 200px;-->
<!--            font-weight : bold;-->
<!--            text-align : center;-->
<!--            line-height : 937px;-->
<!--        }-->
<!--        #back h3 { transition : all ease-in-out 0.5s; }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<!--    <div id="back"><h3 id="rotaa"><span id="fonts">Error97</span></h3></div>-->
<!--</body>-->
<!--</html>-->
<!---->
<!--<script>-->
<!--    var back = document.getElementById("back");-->
<!--    var rotaa = document.getElementById("rotaa");-->
<!--    var fonts = document.getElementById("fonts");-->
<!--    var texts = document.getElementById("texts");-->
<!---->
<!--    setInterval(function func() {-->
<!--        let grb_r = Math.random()*256;-->
<!--        let grb_g = Math.random()*256;-->
<!--        let grb_b = Math.random()*256;-->
<!--        let grb_r1 = Math.random()*256;-->
<!--        let grb_g1 = Math.random()*256;-->
<!--        let grb_b1 = Math.random()*256;-->
<!--        let rota = Math.random()*1080;-->
<!--        let math_r = parseInt(Math.random()*2);-->
<!--        let font_r = parseInt(Math.floor((Math.random()*200)+20));-->
<!--        if(math_r == 0) {-->
<!--            math_r = "-";-->
<!--        } else {-->
<!--            math_r = "+";-->
<!--        }-->
<!---->
<!--        back.style.backgroundColor = "rgb("+grb_r+","+grb_g+","+grb_b+")";-->
<!--        fonts.style.color = "rgb("+grb_r1+","+grb_g1+","+grb_b1+")";-->
<!--        fonts.style.fontSize = font_r+"px";-->
<!--        rotaa.style.transform = "rotate("+math_r+rota+"deg)";-->
<!--    },100);-->
<!--</script>-->

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
        <div>
            <section>
                <?php include_once "./login.php"; ?>
            </section>
        </div>
    </div>
</div>
</body>
</html>