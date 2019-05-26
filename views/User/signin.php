<div class="form-container">
    <form method="POST" action="/user/signin" id="sign-in">
        <input class="form-input" type="text" placeholder="Login:" name="login" 
        value="<?php if (isset($login)) echo $login ?>"/>
        <br />
        <input class="form-input" type="password" placeholder="Password:" name="password" 
        value="<?php if (isset($pass)) echo $pass ?>"/>
        <br />
        <?php if (isset($hasErr) && $hasErr) echo '<p class="err-msg">Not correct login or password</p>'; ?>
        <input type="submit" class="btn-input" name="sign_in" value="Sign in" />
    </form>
    <p>Not have account yet? <a href="/user/register">Sign up</a></p>
</div>