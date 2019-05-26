<?php
require_once(Root.'/views/Layout/header.html');

?>

<div class="form-container">
    <form method="POST" action="register" id="sign-in">
        <input class="form-input" type="text" placeholder="Login:" name="login" value="<?php echo $login ?>"/>
        <?php if (isset($nameErr) && $nameErr) echo '<p class="err-msg">'.$nameErr.'</p>' ?>
        <br />
        <input class="form-input" type="password" placeholder="Password:" name="password" value="<?php echo $pass ?>"/>
        <?php if (isset($passErr) && $passErr) echo '<p class="err-msg">'.$passErr.'</p>' ?>
        <br />
        <input type="submit" class="btn-input" name="register" value="Sign up" />
    </form>
    <p>Already have account? <a href="/user/signin">Sign in</a></p>
</div>

<?php

require_once(Root.'/views/Layout/footer.html');