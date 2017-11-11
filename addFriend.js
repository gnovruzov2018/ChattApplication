$(document).ready(function(){
    $('button[name="friend"]').click(function() {
        var friended_to = $(this).val();
        $(this).attr('disabled',true);
        $.ajax({
                        url: 'addFriend.php',
                        type: "POST",
                        dataType: "json",
                        data: {"friended_to": friended_to},
                        success: function (data) { 
                            console.log('success'+friend_req);
                        },
                        error: function (){
                            console.log('errorBlock');
                        }
                    });
         });
    });