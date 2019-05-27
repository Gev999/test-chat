<?php
require_once(Root.'/views/Layout/header.html'); ?>

<div class="table-responsive" id="page-container">
    <h2 align="left">Hi - <?php echo $_SESSION['username'];  ?></h2>
    <h4 align="right"><a href="/user/logout">Log out</a></h4>
    <h3 align="center">Online User</h3>
    <div id="user_details"></div>
    <div id="user_model_details"></div>
</div>

<script>  
    $(document).ready(function(){

        fetch_user();

        setInterval(function(){
            update_last_activity();
            fetch_user();
            update_chat_history_data();
        }, 3000);

        function fetch_user() {
            $.ajax({
                url: "/user/fetch_user",
                method:"POST",
                success:function(data) {
                    $('#user_details').html(data);
                }
            })
        }

        function update_last_activity(){
            $.ajax({
                url:"/user/update_last_activity",
                success:function()
                {

                }
            })
        }

        function make_chat_dialog_box(to_user_id, to_user_name) {
            var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
            modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
            modal_content += '</div>';
            modal_content += '<div class="form-group">';
            modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
            modal_content += '</div><div class="form-group" align="right">';
            modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
            $('#user_model_details').html(modal_content);
        }

        $(document).on('click', '.start_chat', function(){
            var to_user_id = $(this).data('touserid');
            var to_user_name = $(this).data('tousername');
            make_chat_dialog_box(to_user_id, to_user_name);
            $("#user_dialog_"+to_user_id).dialog({
            autoOpen:false,
            width:400
            });
            $('#user_dialog_'+to_user_id).dialog('open');
        });

        $(document).on('click', '.send_chat', function(){
            var to_user_id = $(this).attr('id');
            var chat_message = $('#chat_message_'+to_user_id).val();
            $.ajax({
                url:"/user/insert_chat",
                method:"POST",
                data:{to_user_id:to_user_id, chat_message:chat_message},
                success:function(data) {
                    $('#chat_message_'+to_user_id).val('');
                    $('#chat_history_'+to_user_id).html(data);
                }
            })
        });

        function fetch_user_chat_history(to_user_id) {
            $.ajax({
                url:"/user/fetch_user_chat_history",
                method:"POST",
                data:{to_user_id:to_user_id},
                success:function(data){
                    $('#chat_history_'+to_user_id).html(data);
                }
            })
        }

        function update_chat_history_data() {
            $('.chat_history').each(function(){
                var to_user_id = $(this).data('touserid');
                fetch_user_chat_history(to_user_id);
            });
        }

        $(document).on('click', '.ui-button-icon', function(){
            $('.user_dialog').dialog('destroy').remove();
        });    
    });  
</script>

<?php
require_once(Root.'/views/Layout/footer.html');