			<script type="text/javascript">
				function boardModify(){
					var form = document.createElement("form");
					form.setAttribute("charset", "UTF-8");
					form.setAttribute("method", "Post");
					form.setAttribute("action", "/cdol/board/modify/<?=$name?>");

					hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", "cnt");
					hiddenField.setAttribute("value", "<?=$list_num?>");
					form.appendChild(hiddenField);

					hiddenField = document.createElement("input");
					hiddenField.setAttribute("type", "hidden");
					hiddenField.setAttribute("name", "b_no");
					hiddenField.setAttribute("value", "<?=$view->b_no?>");
					form.appendChild(hiddenField);

					document.body.appendChild(form);
					form.submit();
				}
				//<![CDATA[
				$(document).ready(function() {
					$("#comment_form").click(function() {
						var id = '<?=$this->session->userdata('id')?>';
						if(id == ''){
							alert("로그인 필요");
							location.replace("/cdol/user/login");
						} else {
							if( $("input#comment").val() ) { //댓글
								$.ajax({
									type:'POST',
									url:'/cdol/board/comment/<?=$name?>/<?=$view->b_no?>',
									dataType:'text',
									data:{
										'comment':$('#comment').val()
									}
								}).done(function(data) {
									self.location.reload();
								});
							}else{
								alert("댓글을 입력하세요.");
							}
						}
					});

					// $("#comment_form").click(function() {
					// 	if( $("input#comment").val() ) { //댓글
					// 		$.post(
					// 			"/cdol/board/comment/<?=$name?>/<?=$list_num?>/<?=$view->b_no?>",
					// 			{ comment:$("input#comment").val() },
					// 			function() {
					// 				self.location.reload();
					// 			}
					// 		);
					// 	}else{
					// 		alert("댓글을 입력하세요.");
					// 	}
					// });

					$(".comment_del").click(function() {
						if (window.confirm("댓글을 삭제하시겠습니까?")) {
							$.ajax({
								type:'POST',
								url:'/cdol/board/comment_del/<?=$name?>/<?=$view->b_no?>',
								dataType:'text',
								data:{
									'comment_no':$(this).attr("idx")
								}
							}).done(function(data) {
								self.location.reload();
							});
						}else{
							return false;
						}
					});

					// function lastPostFunc(){
					// 	$('div#lastPostsLoader').html('<center><em>Loading...</em></center>');
					// 	$.get('comment.more.php', {
					// 		idx:86,
					// 		lastPostID:$(".wrdLatest:last").attr("idx")
					// 	}, function(data){
					// 		if (data != "") {
					// 			$(".wrdLatest:last").after(data);
					// 		}
					// 		$('div#lastPostsLoader').empty();
					// 	});
					// };

					// $("#comment_more").click(function(){
					// 	lastPostFunc();
					// 	return false;
					// });
				});
				//]]>
				function download(file_no){
					var form = document.createElement("form");
					form.setAttribute("method","post");
					form.setAttribute("action","/cdol/board/download/<?=$name?>/<?=$view->b_no?>");
					document.body.appendChild(form);

					//input
					var input_id = document.createElement("input");
					input_id.setAttribute("type", "hidden");
					input_id.setAttribute("name", 'file_no');
					input_id.setAttribute("value", file_no);
					form.appendChild(input_id);

					//폼전송
					form.submit();
				}
			</script>

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<colgroup>
					<col style="width:80%">
					<col>
				</colgroup>
				<table class="table">
					<tr>
						<td width="70" align="right"><strong>아이디 : </strong></td>
						<td><?=$view->name?> (<?=$view->write_id?>)</td>
					</tr>
					<tr>
						<td align="right"><strong>날짜 : </strong></td>
						<td><?=$view->b_date?></td>
					</tr>
					<tr>
						<td align="right"><strong>IP : </strong></td>
						<td><?=$view->ip_address?></td>
					</tr>
					<tr>
						<td align="right"><strong>제목 : </strong></td>
						<td style="word-break:break-all;"><?=$view->b_title?></td>
					</tr>
					<tr>
						<td align="right"><strong>내용 : </strong></td>
						<td style="word-break:break-all;" rows="13"><?=$view->b_content?></td>
					</tr>
					<tr>
						<td align="right"><strong>첨부 : </strong></td>
						<td>
							<?php
								$i = 0;
								foreach($file_view as $entry){
									if($i >= 1 && $i <= count($file_view)){
										echo " | ";
									}
									$i++;
							?>
									<a href="javascript:download('<?=$entry->f_no?>')"><?=$entry->original_name?></a>
							<?php
								}
							?>
						</td>
					</tr>
				</table>
				<hr />
			</div>
			<!-- Modify Delete-->
			<div class="row">
				<div class="col-sm-9 col-md-10 col-md-offset-2 main">
					<div class="col-xs-8 col-sm-6">
<?php
if($this->session->userdata('id') == $view->write_id) {
?>
						<a href="javascript:boardModify()" class="btn btn-primary btn-sm">수정하기</a>
						<a href="/cdol/board/delete/<?=$name?>/<?=$view->b_no?>" id="delete" class="btn btn-danger btn-sm">삭제하기</a>
<?php
}
?>
					</div>
					<!-- <div class="col-xs-4 col-sm-6" style="text-align:right; border: 1ps solid #ff0000">
						<a href="board.php?table=test1&page=2" class="btn btn-default btn-sm">목록</a>
					</div> -->
				</div>
			</div>

			<div class="col-sm-9 col-md-10 col-md-offset-2 main">
				<table class="table table-hover">
<?php
foreach($comm_view as $entry){
?>
					<tr class="wrdLatest dl-horizontal" idx="<?=$entry->comment_no?>">
						<td>
							<dt><a href=""><?=$entry->id?></a></dt>
							<dd><?=$entry->comment?>
<?php
	if($this->session->userdata('id') == $entry->id){

?>
								<button type='button' class='comment_del close' idx='<?=$entry->comment_no?>' title='삭제'>&times;</button>
<?php
	}
?>
							</dd>
						</td>
					</tr>
<?php
}
?>
				</table>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<div class="input-group">
					<input type="text" id="comment" class="form-control" maxlength="150"  />
					<div class="input-group-btn">
					<button type="button" class="btn btn-default" tabindex="-1" id="comment_form">댓글</button>
					</div>
				</div><!-- /.input-group -->
			</div>
