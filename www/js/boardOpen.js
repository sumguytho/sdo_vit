$(function(){
	$('div.board-item').click(function(e){
		var id = this.children[0].text;
		location.href = "/showAssigns.php?id=" + id;
	});
});