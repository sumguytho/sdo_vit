
<script type="text/javascript">

    function approve(id) {
        $.ajax(
            '/api/approveUser.php',
            {
                type: "POST",
                data: {
                    "id": id,


                },
                success: function (data) {
                    $.ajax(
                        '/api/getAllUsers.php',
                        {


                            success: function (data) {
                                fillUsers(JSON.parse(data));
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

    function fillUsers(data) {

        $('#prepods').text('')
        $('#students').text('')
        $('#zay').text('')

            for(let i = 0; i<data.length;i++){


                if(data[i].permissions == '1')
                    $('#prepods').append('<li onclick=approve('+data[i].idUser+') id="draggable"'+i+' value="'+data[i].idUser+'" class="list-group-item"> '+data[i].name +' '+ data[i].surname+ '</li>')

                if(data[i].permissions == '2')
                    $('#students').append('<li onclick=approve('+data[i].idUser+') id="draggable"'+i+' value="'+data[i].idUser+'" class="list-group-item"> '+data[i].name +' '+ data[i].surname+ '</li>')

                if(data[i].permissions == '3')
                    $('#zay').append('<li onclick=approve('+data[i].idUser+') id="draggable"'+i+' value="'+data[i].idUser+'" class="list-group-item"> '+data[i].name +' '+ data[i].surname+ '</li>')

            }
    }




    $.ajax(
        '/api/getAllUsers.php',
        {


            success: function (data) {
                fillUsers(JSON.parse(data));
            },
            error: function () {
                alert('There was some error performing the AJAX call!');
            }
        }
    );
</script>

<div class="container-fluid">
	<div class="col-8 offset-2">
		<h1 style="margin: 30px 0 50px 0; text-align: center;">Пользователи</h1>
		<div class="row">
			<div class="col-4">
				<div class="colheader">
					<p>Преподаватели</p>
				</div>
			</div>
			<div class="col-4">
				<div class="colheader">
					<p>Заявки</p>
				</div>
			</div>
			<div class="col-4">
				<div class="colheader">
					<p>Студенты</p>
				</div>
			</div>
		</div>

        <div class="row">
        <div class="col-4" id="prepods">

        </div>
            <div class="col-4" id="zay">
            </div>
            <div class="col-4" id="students">
            </div>
        </div>
	</div>
</div>