<?
	$boardList = getDeskList($userInfo);
?>

<script>

    var tasks;
    var answers;
    var currentTaskIndex;




    function addDesk() {

        $.ajax(
            '/api/addDesk.php',
            {
                type: "POST",
                data: {
                    "name": $('#deskName').val(),

                },
                success: function (data) {
                    window.location.reload()

                },
                error: function () {
                    alert('There was some error performing the AJAX call!');
                }
            }
        );
    }
</script>

<div class="container-fluid">
	<div class="col-4 offset-4">
		<h1 style="margin: 30px 0 50px 0; text-align: center;">Доски</h1>
		<div class="row">
			<div class="col-12">
				<div class="board-content">
					<div class="board-header">
						<? echo $userInfo['groupname']; ?>
					</div>
					<div class="board-list">
						<? if(is_array($boardList))

							foreach($boardList as $boardItem){ ?>
								<div class="board-item">
									<a hidden><? echo $boardItem['deskId'].'&name='.$boardItem['name']; ?></a>
									<? echo $boardItem['name'] ?>
								</div>
						<? } ?>

                        <?
                        if(isset($userInfo) && $userInfo['permissions']==1)
                            echo '
                    <div id="taskAdd"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Создать доску
                    </button>
                    </div>'

                        ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить доску</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <input class="col-6  align-self-center" type="text" placeholder="Название доски" id="deskName" value>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick=addDesk()>Добавить доску</button>
            </div>
        </div>
    </div>
</div>