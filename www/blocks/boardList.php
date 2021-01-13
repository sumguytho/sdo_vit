<?
	$boardList = getDeskList($userInfo);
?>
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
									<a hidden><? echo $boardItem['deskId'] ?></a>
									<? echo $boardItem['name'] ?>
								</div>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>