<?php
require_once(Root.'/views/Layout/header.html');

?>

<div class="form-container">
    <form method="POST" action="/user/register" class="form-field">
        <div class="form-group">
            <input class="form-input sign-up-field form-control <?php if (isset($nameErr) && $nameErr) echo 'err-input' ?>" 
            type="text" placeholder="Username" name="login" value="<?php echo $login ?>"/>
            <?php if (isset($nameErr) && $nameErr) echo '<p class="err-msg form-text text-muted">'.$nameErr.'</p>' ?>
        </div>
        <div class="form-group">
            <input class="form-input sign-up-field form-control <?php if (isset($passErr) && $passErr) echo 'err-input' ?>" 
            type="password" placeholder="Password" name="password" value="<?php echo $pass ?>"/>
            <?php if (isset($passErr) && $passErr) echo '<p class="err-msg form-text text-muted">'.$passErr.'</p>' ?>
        </div>
        <button type="submit" class="btn btn-success" name="register">Sign up</button>
        <br /> <br />
        <p class="form-text text-muted">Already have account? <a href="/user/signin">Sign in</a></p>
    </form>
</div>
<script type="text/javascript">
     validate($('.sign-up-field'));
</script>
<script src="../../templates/js/val-reg.js"></script>

<?php

require_once(Root.'/views/Layout/footer.html');