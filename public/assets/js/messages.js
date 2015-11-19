
// $(function(){
//     var $messages = $('#messages');
//
//        setInterval(function() {
//          //cleanChatbox();
//          $.ajax({
//                type: 'GET',
//                url: 'http://localhost:8000/get-messages/1',
//                success: function(messages) {
//                  if(messages) {
//                    $.each(messages, function(i, message) {
//                        $messages.append('<ul>'+message+'</ul>');
//                    });
//                  }
//                }
//              });
//        }, 1000);
//
// });

// function myFunction() {
//  cleanChatbox();
//  var $messages = $('#messages');
//  var message = $("#message").val();
//  $("#message").val("");
//  var dataString = 'message='+message;
//   $.ajax({
//         type: 'POST',
//         url: 'http://localhost:8000/update-message/1',
//         data: dataString,
//         success: function(message) {
//             createHtml(message);
//             $messages.append('<ul>'+message+'</ul>');
//         }
//       });
// }

// function cleanChatbox() {
//      var count_list = $("li").length;
//      if(count_list > 10) {
//          $("li").first().remove();
//      }
//      console.log(count_list);
//
// }
