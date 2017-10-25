<!DOCTYPE html>
<html>
    <head>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
    </head>
    <body>
        <div id="result"></div>
        <input type="text" id="msg" />
        <input type="button" value="get result" id="getResult" />
        <script>
            $('#getResult').click( function() {
                $('#result').html('');
                $.ajax({
                    url:'ajax_receive',
                    dataType:'text',
                    type:'POST',
                    data:{
                        'msg':$('#msg').val()
                    }
                }).done(function(data) {
                    $('#result').html(data);
                });
            });
        </script>
    </body>
</html>