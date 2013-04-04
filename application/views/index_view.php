<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
    <title>Самое самое</title>
    <link type="text/css" rel="stylesheet" href="<?=base_url();?>css/style.css"/>
    <script type="text/javascript" src="<?=base_url();?>js/jquery-1.7.1.js"></script>
</head>
<body>
    <div id="container">
        <div id="header">
            <div id="logo">Самое Самое</div>
            <div id="enter_site">
                <form>
                    <fieldset>
                        <legend>Вступить в сообщество</legend>
                         <input type="text" name="log" placeholder="Login" size="9"/>
                         <input type="password" name="pass" placeholder="Password" size="9"/>
                         <input type="submit" name="enter" value="Вход" /><br />
                         <a id="reg_link" href="?reg">Регистрация</a> || 
                         <a id="reg_link" href="contrmodel/zapros.php">Забыл пароль</a>
                    </fieldset>
                </form>
            </div>
        </div>
        <div id="nav">
            <? gen_menu($menu);?>
        </div>
        <div id="main">
            <div class="content"></div>
            <div class="rg_nav"></div>
        </div>
        <div id="footer"></div>
    </div>
</body>
</html>