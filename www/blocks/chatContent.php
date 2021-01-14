
<script>

    var currentChatId = -1;
    var lastChatData = 1;
    var lastChatName ='';
    String.prototype.hashCode = function() {
        var hash = 0;
        if (this.length == 0) {
            return hash;
        }
        for (var i = 0; i < this.length; i++) {
            var char = this.charCodeAt(i);
            hash = ((hash<<5)-hash)+char;
            hash = hash & hash; // Convert to 32bit integer
        }
        return hash;
    }

    setInterval(timer, 1000);

    function timer() {
        selectChat(currentChatId)
    }

    function listFill(data){
        for(let i = 0; i<data.length;i++)
            $('#usersList').append('<div class="row"><div class="col-6"> '+data[i].name +' '+ data[i].surname+ '</div><input type="checkbox" value="'+data[i].idUser+'"><div>')
    }

    function fillChatWindow(data) {


        if(lastChatData.toString().hashCode()!=data.toString().hashCode() || data[0].chatName!=lastChatName){
            $('#chatWindow').text('');
            lastChatName = data[0].chatName;
            $('#chatWindowName').text("Чат: "+data[0].chatName)
            lastChatData = data.toString().hashCode();
            data = data.sort((a,b)=> new Date(a.date) - new Date(b.date))
            for(let i = 0; i<data.length;i++)
                $('#chatWindow').append('<div class="row"><div class="col-12"> '+data[i].date +' - '+data[i].name +' '+ data[i].surname+': '+ data[i].content+ '</div><div>')
        }
    }

    function selectChat(chatId){


            currentChatId = chatId;

            $.ajax(
                '/api/getChatMessages.php',
                {
                    type: "POST",
                    data: {
                        "chatId": chatId,


                    },
                    success: function (data) {
                        fillChatWindow(JSON.parse(data));
                    },
                    error: function () {
                        alert('There was some error performing the AJAX call!');
                    }
                }
            );


    }

    function sendMessage(){
        message = $('#message').val();

        $.ajax(

            '/api/sendMessage.php',
            {
                type: "POST",
                data: {
                    "message": message,
                    "chatId": currentChatId
                },
                success: function() {
                    selectChat(currentChatId)
                },
                error: function() {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );
    }

    function listChatsFill(data){
        $('#chatsList').text('')
        for(let i = 0; i<data.length;i++)
            $('#chatsList').append('' +
                '<div class="row" onclick=selectChat('+data[i].chatId+')>' +
                    '<div class="col-4"> '
                        +data[i].name+ '' +
                    '</div>' +
                '</div>')
    }


    function createChat(){
        $('#exampleModal').modal('toggle')
        checked = $("input:checkbox:checked");
        var userIds = []
        for(let i = 0; i<checked.length;i++)
            userIds.push(checked[i].defaultValue)


        $.ajax(

            '/api/addChat.php',
            {
                type: "POST",
                data: {
                    "name": $('#chatName').val(),
                    "userIds": userIds,

                },
                success: function() {
                    $.ajax(
                        '/api/getUserChats.php',
                        {

                            success: function(data) {
                                listChatsFill(JSON.parse(data))
                            },
                            error: function() {
                                alert('There was some error performing the AJAX call!');
                            }
                        }
                    );
                },
                error: function() {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );

    }
    $(document).ready(function() {
        $('#message').keydown(function(e) {
            if(e.keyCode === 13) {
                sendMessage()
            }
        });
    });

    $(document).ready(function() {
        $('input').keydown(function(e) {
            if(e.keyCode === 13) {
                // можете делать все что угодно со значением текстового поля console.log($(this).val());
            }
        });
    });

    $.ajax(
        '/api/getAllUsers.php',
        {
            success: function(data) {
                listFill(JSON.parse(data))
            },
            error: function() {
                alert('There was some error performing the AJAX call!');
            }
        }
    );


    $.ajax(
        '/api/getUserChats.php',
        {

            success: function(data) {
                listChatsFill(JSON.parse(data))
            },
            error: function() {
                alert('There was some error performing the AJAX call!');
            }
        }
    );
</script>


<div class="container-fluid">





    <div class="row" >

    </div>
    <div class="row" id="chatWindowName">Выберите чат из списка </div>
    <div class="row" >
        <div class="col-6 bg-light my-2" id="chatWindow">


        </div>

        <div class="col-1 my-2" ></div>
        <div class="col-4 bg-light my-2" >
            <div id="chatsList">

            </div>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Создать чат
            </button>
        </div>
    </div>
    <div class="row" >
        <input type="text" placeholder="Введите сообщение" id="message">
        <button type="button" class="btn btn-primary" onclick=sendMessage()>
            Отправить
        </button>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать чат</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="col-5 align-self-center" type="text" placeholder="Название чата" id="chatName">
            <div class="modal-body" id="usersList">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=createChat()>Создать</button>
            </div>
        </div>
    </div>
</div>