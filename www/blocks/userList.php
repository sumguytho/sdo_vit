
<?
global $db_param;
$conn = connect_db($db_param);

    if ($conn) {
    $result = mysqli_query($conn, 'SELECT * FROM user');





    mysqli_close($conn);

    }
?>
<script type="text/javascript">
    $(function() {

        $('#draggable').each().draggable({

        });

    });
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
				<div class="colheader bleak">
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
        <div class="col-4">
        <? while ($row = $result->fetch_assoc()) {
            echo '<li id="draggable" class="list-group-item">';
            echo $row['name'].' ';
            echo $row['surname'];
            echo '</li>';

        }
        ?>
        </div>
        </div>
	</div>
</div>