<div>
    <?php
    if (!isset($_COOKIE['jwt'])) {
        ?>
        <article>
            <form action="" method="post">
                <input type="text" name="id" placeholder="id" autocomplete="off" />
                <input type="password" name="password" placeholder="password" autocomplete="off" />
                <input type="submit" value="Login" /><br>
                <div>
                    <a href="sign_up.php">Sign up</a>
                </div>
            </form>
        </article>
        <?php
    } else {
        ?>
        <article>
            <div>
                <input type="button" value="My Page" onclick="location.href='./info.php'" />
                <input type="button" value="Logout" onclick="location.href='../controller/member/logout.php';" />
            </div>
        </article>
        <?php
    }
    ?>
</div>