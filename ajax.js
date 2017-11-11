    $( "#sendMessage" ).click(function() {
        getMessages();
        $('input[id="message"]').val('');
    });
    function getMessages(){
        var message = $('#message').val();
        $.ajax({
            url: 'message.php',
            type: "POST",
            dataType: "json",
            data: {"message": message},
        });
    }
    function updateChat(){
        var id = $('input[id="lastMessageId"]').val();
        console.log(id);
        $.ajax({
            url: 'updateMessages.php',
            type: "POST",
            dataType: "json",
            data: {"id": id},
            success: function (data) {
                $('input[id="lastMessageId"]').val(data[data.length-1].id);
                var username = $('input[id="username"]').val();
                if (data.length>30) {
                    for (var i = data.length-30; i < data.length; i++) {
                        if (username==data[i].username) {
                            $('div[id="bodyMessage"]').append('<p><b>Me: </b>'+replaceEmoticons(data[i].message)+'</p><br>');   
                        }else{
                            $('div[id="bodyMessage"]').append('<p><b>'+data[i].username+': </b>'+replaceEmoticons(data[i].message)+'</p><br>');
                        } 
                    }
                }else{
                    for (var i = 0; i < data.length; i++) {
                        if (username==data[i].username) {
                            $('div[id="bodyMessage"]').append('<p><b>Me: </b>'+replaceEmoticons(data[i].message)+'</p><br>');   
                        }else{
                            $('div[id="bodyMessage"]').append('<p><b>'+data[i].username+': </b>'+replaceEmoticons(data[i].message)+'</p><br>');
                        }
                    }
                }     
                console.log('success'+id);
            },
            error: function (){
                console.log('error');
            }
        });
    }
window.setInterval(function(){
    updateChat();
}, 1000);


function replaceEmoticons(text){
    // The base URL of all our smilies
    var url = "images/";
    var searchFor = /:D|:-D|:\)|:-\)|;\)|';-\)|:\(|:-\(|:o|:\?|8-\)|:x|:P/gi;

    // A map mapping each smiley to its image
    var map = {
    ':-)' : 'cry.png',
    ':D'  : 'devil_laugh.png',
    ':)'  : 'why_thank_you.png'  };

    // Do the replacements
    text = text.replace(searchFor, function(match) {
        var rep;

        // Look up this match to see if we have an image for it
        rep = map[match];
        return rep ? '<img src="' + url + rep + '" class="emoticons" />' : match;
    });
    return (text);

}