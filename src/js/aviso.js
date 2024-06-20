$(document).ready(function(){
    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'process_login.php',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response){
                if(response.status == 'success'){
                    window.location.href = '../../index.html';
                } else {
                    $('#message').text(response.message);
                }
            }
        });
    });
});