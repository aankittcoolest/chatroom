

$(function() {
    onlineChatMembers();
    offlineChatMembers();
    onlineNonChatMembers();
    offlineNonChatMembers();
});


$(document).on('keydown', function(e){
    if(e.which==13){ // Up
        myFunction();
    }
});


$("#message").keypress(function(event){
    console.log(event);
    if(event.keyCode == 13){
        myFunction();
    }
});

function sendMessage() {
 var $messages = $('#messages');
 var message = $("#message").val();
 var chat_room_id = $("#chat_room_id").val();
 $("#message").val("");
 var dataString = 'message='+message;
  $.ajax({
        type: 'POST',
        url: URL+'/update-message/'+chat_room_id,
        data: dataString,
        success: function(message) {
              document.getElementById('chat-frame').contentWindow.location.reload();
        }
      });
}

function onlineChatMembers() {
  var chat_room_id = $("#chat_room_id").val();
   $.ajax({
         type: 'GET',
         url: URL+'/online-chat-members/'+chat_room_id,
         data: '',
         success: function(data) {
            if(data) {
              $.each(data, function( key, value) {
                  $('.online').append('<li><i class="fa fa-circle online-icon"></i><span class="tab">'+ value +'</span></li>');
              });
            }

         }
       });
 }

 function offlineChatMembers() {
   var chat_room_id = $("#chat_room_id").val();
    $.ajax({
          type: 'GET',
          url: URL+'/offline-chat-members/'+chat_room_id,
          data: '',
          success: function(data) {
            if(data) {
              $.each(data, function( key, value) {
                  $('.offline').append('<li><i class="fa fa-circle offline-icon"></i><span class="tab">'+ value +'</span></li>');
              });
            }

             //console.log(data);
          }
        });
  }

  function onlineNonChatMembers() {
    var chat_room_id = $("#chat_room_id").val();
    var online_flag = 1;
     $.ajax({
           type: 'GET',
           url: URL+'/online-nonchat-members/'+chat_room_id,
           data: '',
           success: function(data) {
              if(data) {
                $.each(data, function( key, value) {
                    checkInvitation(key, value,  chat_room_id, online_flag);
                });
              }
           }
         });
   }

   function offlineNonChatMembers() {
     var chat_room_id = $("#chat_room_id").val();
     var online_flag = 0;
     var abc = '';
      $.ajax({
            type: 'GET',
            url: URL+'/offline-nonchat-members/'+chat_room_id,
            data: '',
            success: function(data) {
               if(data) {
                 $.each(data, function( key, value) {
                  checkInvitation(key, value, chat_room_id, online_flag);
                 });

               }
            }
          });
    }

    function checkInvitation(member_id, member_name, chatroom_id, online_flag) {
      var chat_room_id = $("#chat_room_id").val();
      var inviter_name = '';
       $.ajax({
             type: 'GET',
             url: URL+'/get-inviter/'+ member_id +'/chatroom='+chat_room_id,
             data: '',
             success: function(data) {
               if(data) {
                 $.each(data, function( key, value) {
                      if(online_flag == 1) {
                          $('.online-non-members').append('<tr><td><i class="fa fa-circle online-icon"></i><span class="tab">'+ member_name +'</span></td><td>Invited By '+ value +'</td></tr>');

                      } else {
                          $('.offline-non-members').append('<tr><td><i class="fa fa-circle offline-icon"></i><span class="tab">'+ member_name +'</span></td><td>Invited By '+ value +'</td></tr>');
                      }


                 });
               } else if(online_flag == 1) {
                 $('.online-non-members').append('<tr><td><i class="fa fa-circle online-icon"></i><span class="tab">'+ member_name +'</span></td><td><a href = '+URL+'/invite-member/'+ member_id +'/chatroom='+chat_room_id+' class="btn btn-primary btn-sm" id="invite_member_'+member_id+'">Invite</a></td></tr>');
               } else {
                $('.offline-non-members').append('<tr><td><i class="fa fa-circle offline-icon"></i><span class="tab">'+ member_name +'</span></td><td><a href = '+URL+'/invite-member/'+ member_id +'/chatroom='+chat_room_id+' class="btn btn-primary btn-sm" id="invite_member_'+member_id+'">Invite</a></td></tr>');
               }
             }
           });
    }
