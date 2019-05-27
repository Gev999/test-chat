<div class="form-container">
    <form method="POST" action="/user/signin" class="form-field">
        <div class="form-group">
            <input class="form-input sign-in-field form-control <?php if (isset($hasErr) && $hasErr) echo 'err-input' ?>" 
            id="sign-in" type="text" placeholder="Username" name="login" 
            value="<?php if (isset($login)) echo $login ?>"/>
        </div>
        <div class="form-group">
            <input class="form-input sign-in-field form-control <?php if (isset($hasErr) && $hasErr) echo 'err-input'?>" 
            type="password" placeholder="Password" name="password" 
            value="<?php if (isset($pass)) echo $pass ?>"/>
        </div>
        <?php if (isset($hasErr) && $hasErr) echo '<p class="err-msg form-text text-muted">Not correct username or password</p>'; ?>
        <button type="submit" class="btn btn-primary" name="sign_in">Sign in</button>
        <br /> <br />
        <p class="form-text text-muted">Not have account yet? <a href="/user/register">Sign up</a></p>
    </form>
</div>
<script type="text/javascript">
     validate($('.sign-in-field'));
</script>