import './bootstrap';

$(document).ready(function(){
    
    $(document).on('click','#chatButton',function (e){

        e.preventDefault();

        let message = $('#chatInput').val();

        var id = $('#chatParam').val();
        var route = `/progress/cobachat/${id}`;

        if(message == ''){
            alert('Please enter both username and message')
            return false;
        }
        $.ajax({
            type:"POST",
            'url': route,
            data: {
                message:message,
                '_token': token
            },
            success: function(e) {
                $('#chatInput').val("");
                console.log('sukses');
            }
            
        });

    });

});

let project_progress_id = $("#chatParam").val();
let latestChatDate = $("#chatLatestDate").val();
var countToday =  0;

Echo.private(`project-progress.${project_progress_id}`)
.listen('.chat.sent', (event) => {
    var user_account_id = $("#current_user").val();
    var createdAtDate = new Date(event.time);
    var dateChat = new Date(event.time).toISOString().split('T')[0]
    console.log(dateChat);
    console.log(latestChatDate);
    $("#unreadMessage").html("");
    var printToday = dateChat !== latestChatDate;
    var formattedTime = createdAtDate.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    countToday+=1;
    console.log(countToday);
    if (user_account_id === event.sender){
        var newChatElement = `
        ${printToday && countToday == 1 ? '<p class="text-center">Today</p>' : ''}
        <div class="chat-container darker">
            <div class="chat-icon">
                <img src="https://img.icons8.com/?size=30&id=98957&format=png" alt="User Icon" ">
                    </div>
                    <div class="d-grid gap-2">
                <div class="chat-content">
                    <p style="padding: 0px; margin-bottom: 0px;">${event.message}</p>
                </div>
                <div class="chat-time" style="margin-left: auto;">${formattedTime}</div>
            </div>
        </div>
        `;
    } else {
        var newChatElement = `
        ${printToday && countToday == 1 ? '<p class="text-center">Today</p>' : ''}
        <div class="chat-container">
            <div class="chat-icon mt-2">
                <img src="https://img.icons8.com/?size=30&id=98957&format=png" alt="User Icon">
            </div>
            <div class="d-grid gap-2">
                <div class="chat-content">
                    <p style="padding: 0px; margin-bottom: 0px;">${event.message}</p>
                </div>
                <div class="chat-time" style="margin-right: auto;">${formattedTime}</div>
            </div>
        </div>
    `;
    }

    $('.chatContainerAppend').append(newChatElement);
});





