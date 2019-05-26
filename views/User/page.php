<?php
require_once(Root.'/views/Layout/header.html'); ?>

<form method="POST" action="/user/logout">
    <input type="submit" class="logout-btn" value="Log out" />
</form>

<?php
require_once(Root.'/views/Layout/footer.html');