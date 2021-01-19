
<script>

    var tasks;
    var answers;
    var currentTaskIndex;




    function approve(id) {
        $.ajax(
            '/api/approveAnswer.php',
            {
                type: "POST",
                data: {
                    "id": id,

                },
                success: function (data) {
                    getAnswers(tasks[currentTaskIndex].taskId)
                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );
    }

    function openTask(i) {

        $('#answers').text('')
        getAnswers(tasks[i].taskId)
        currentTaskIndex = i;

        var date = new Date(tasks[i].date.replace(/-/g,"/"));
        $('#taskDateView').val(date)
        $('#taskNameView').val(tasks[i].name)
        $('#taskDeskView').val(tasks[i].description)
        $('#taskModal').modal('show')
    }

    function fillDesks(data){
        tasks = data;
        $('#openDesks').text('')
        for(let i = 0; i<data.length;i++)
            $('#openDesks').append('<li class="list-group-item" onclick="openTask('+i+')">'+data[i].name +' </li>')

    }

    function fillAnswers(data){

        $('#answers').text('')
        answers = data;
        var permissions = <? if(isset($userInfo)) echo $userInfo['permissions']; ?>;
        for(let i = 0; i<data.length;i++) {

            if(data[i].approve == 1) {
                $('#answers').append('<p id="answer" class="approve" onclick="openAnswer(' + i + ')">' + data[i].name + ' Ответ:' + data[i].answer + '' + '</p>')

            }else {

                if(permissions == 0) {

                    $('#answers').append('<p id="answer" onclick="openAnswer(' + i + ')">' + data[i].name + ' Ответ:' + data[i].answer + '' +
                        '<button onclick=approve(' + data[i].id + ') type="button" class="btn btn-primary" id="answerButton">\n' +
                        '                        Зачтёт\n' +
                        '                    </button> </p>')
                } else {
                    $('#answers').append('<p id="answer" onclick="openAnswer(' + i + ')">' + data[i].name + ' Ответ:' + data[i].answer + '</p>')
                }
            }
        }

    }


    function getAnswers(id){
        $.ajax(
            '/api/getAnswers.php',
            {
                type: "POST",
                data: {
                    "id": id,


                },
                success: function (data) {
                    fillAnswers(JSON.parse(data));
                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );


    }

    function sendAnswer(){
        $('#taskModal').modal('toggle')

        $.ajax(
            '/api/sendAnswer.php',
            {
                type: "POST",
                data: {
                    "taskId": tasks[currentTaskIndex].taskId,
                    "answer": $('#taskAnsView').val()


                },
                success: function (data) {
                    alert('Ответ успешно загружен')
                    $('#taskAnsView').val('')
                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );


    }

    function addTask(){
        $('#exampleModal').modal('toggle')
        $.ajax(
            '/api/addTask.php',
            {
                type: "POST",
                data: {
                    "deskId": <? echo $_GET['id']?>,
                    "description": $('#taskDesk').val(),
                    "name": $('#taskName').val(),
                    "date": $('#taskDate').val(),


                },
                success: function () {
                    $.ajax(
                        '/api/getAllWorks.php',
                        {
                            type: "POST",
                            data: {
                                "deskId": <? echo $_GET['id']?>,


                            },
                            success: function (data) {
                                fillDesks(JSON.parse(data));
                            },
                            error: function () {
                                alert('There was some error performing the AJAX call!');
                            }
                        }
                    );

                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );

    }


        $.ajax(
            '/api/getAllWorks.php',
            {
                type: "POST",
                data: {
                    "deskId": <? echo $_GET['id']?>,


                },
                success: function (data) {
                    fillDesks(JSON.parse(data));
                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );




</script>

<div class="container-fluid">
	<div class="col-8 offset-2">
		<h1 style="margin: 30px 0 50px 0; text-align: center;"><? echo $_GET['name']?></h1>
		<div class="row">
			<div class="col-4">
				<div class="colheader">
					<p>Открытые</p>
				</div>
				<div class="board-content">
					<div class="board-entry" id="openDesks">

					</div>


                    <?
                    if(isset($userInfo) && $userInfo['permissions']==0)
                    echo '
                    <div id="taskAdd"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Создать задание
                    </button>
                    </div>'

                    ?>


				</div>
			</div>
			<div class="col-4">
				<div class="colheader">
					<p>Сданы</p>
				</div>
				<div class="board-content">
					
				</div>
			</div>
			<div class="col-4">
				<div class="colheader">
					<p>Оценены</p>
				</div>
				<div class="board-content">
					
				</div>
			</div>
		</div>
	</div>
</div>



<!-- Modal add-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать задание</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="col-5 align-self-center" type="text" placeholder="Название задания" id="taskName">
            <textarea class="col-5 align-self-center" cols="40" rows="5" placeholder="Описание задания" id="taskDesk"></textarea>
            <input class="col-5 align-self-center" type="date" id="taskDate">

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=addTask()>Создать</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal view-->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="col-5 align-self-center" type="text" placeholder="Название задания" id="taskNameView" value readonly>
            <textarea class="col-5 align-self-center" cols="40" rows="5" placeholder="Описание задания" id="taskDeskView" readonly></textarea>
            <input class="col-5 align-self-center" type="text" id="taskDateView" readonly>

            <textarea class="col-5 align-self-center" cols="40" rows="5" placeholder="Ответ" id="taskAnsView"></textarea>

            Ответы
            <div class="board-entry" id="answers">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=sendAnswer()>Добавить ответ</button>
            </div>
        </div>
    </div>
</div>