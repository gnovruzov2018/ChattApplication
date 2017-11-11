
$(document).ready(function(){
    $(document).on('click','#block',function() {
        var block_to = $(this).val();
        var id = $('input[id="lastMessageId"]').val(0);
        $('div[id="bodyMessage"]').empty();
        console.log(block_to);
        $(this).closest("button").attr('disabled',true);
        $('#friend'+block_to).attr('disabled',true);   
        $(this).next("button").attr('disabled',false);
        $.ajax({
                        url: 'blockUser.php',
                        type: "POST",
                        dataType: "json",
                        data: {"block_to": block_to},
                        success: function (data) { 
                            console.log('success'+block_to);
                        },
                        error: function (){
                            console.log('errorBlock');
                        }
        });
    });
    $(document).on('click','#unblock',function() {
        var block_to = $(this).val();
        var id = $('input[id="lastMessageId"]').val(0);
        $('div[id="bodyMessage"]').empty();
        $('#friend'+block_to).attr('disabled',false);   
        $(this).closest("button").attr('disabled',true);
        $(this).prev("button").attr('disabled',false);
        $.ajax({
                        url: 'unblockUser.php',
                        type: "POST",
                        dataType: "json",
                        data: {"block_to": block_to},
                        success: function (data) { 
                            console.log('success'+block_to);
                        },
                        error: function (){
                            console.log('errorBlock');
                        }
        });
    });
});