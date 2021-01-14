
<?
global $db_param;
$conn = connect_db($db_param);

    if ($conn) {
    $result = mysqli_query($conn, 'SELECT * FROM `group`');
        echo mysqli_error($conn);




    mysqli_close($conn);

    }
?>
<script type="text/javascript">

    function fillStudents(data) {
        $('#sostav').text('');
        for(let i = 0; i<data.length;i++)
            $('#sostav').append('<li id="draggable" class="list-group-item">'+data[i].surname);


    }


    function selectGroup(name) {

        $.ajax(
            '/api/getGroupStudents.php',
            {
                type: "POST",
                data: {
                    "name": name,


                },
                success: function (data) {
                    fillStudents(JSON.parse(data))
                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );


    }



</script>

<div class="container-fluid">
	<div class="col-8 offset-2">
		<h1 style="margin: 30px 0 50px 0; text-align: center;">Группы</h1>
		<div class="row">
			<div class="col-4">
				<div class="colheader">
					<p>Группа</p>
				</div>
                <div >
                    <? while ($row = $result->fetch_assoc()) {
                        $name = $row['name'];
                        echo '<li id="draggable" class="list-group-item" onclick=selectGroup("'.$name.'")>';
                        echo $row['name'].' ';
                        echo '</li>';

                    }
                    ?>
                </div>
			</div>
			<div class="col-4">
				<div class="colheader bleak">
					<p>Состав</p>
				</div>
                <div id="sostav"></div>
			</div>
			<div class="col-4">
				<div class="colheader">
					<p>Пользователи</p>
				</div>
			</div>
		</div>



        </div>
        </div>
	</div>
</div>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить группу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input class="col-5 align-self-center" type="text" placeholder="Название группы" id="groupName">
            <div class="modal-body" id="usersList">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=createChat()>Добавить</button>
            </div>
        </div>
    </div>
</div>