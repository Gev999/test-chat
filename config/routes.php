<?php

return array(
    'user/signin'=>'user/signin',
    'user/register'=>'user/register',
    'user/page'=> 'user/page',
    'user/logout'=> 'user/logout',
    'user/fetch_user'=>'user/fetchUser',
    'user/fetch_user_chat_history'=>'user/fetchUserChatHistory',
    'user/update_last_activity'=>'user/updateLastActivity',
    'user/insert_chat'=>'user/insertChat',
    'home'=>'home/index',
    '([\s\S]+)'=>'home/pageNotFound',
    '' => 'home/index'
);