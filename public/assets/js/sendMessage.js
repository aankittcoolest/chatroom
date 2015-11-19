function myFunction() {
 //cleanChatbox();
 var $messages = $('#messages');
 var message = $("#message").val();
 $("#message").val("");
 var dataString = 'message='+message;
  $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/update-message/1',
        data: dataString,
        success: function(message) {
          console.log('ok');
        }
      });
}
