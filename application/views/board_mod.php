			<script type="text/javascript">
				//<![CDATA[
				$(document).ready(function() {
					$(".file_del").click(function() {
						if (window.confirm("첨부파일을 삭제하시겠습니까?")) {
							$.ajax({
								type:'POST',
								url:'/cdol/board/file_del/<?=$name?>/<?=$view->b_no?>',
								dataType:'text',
								data:{
									'file_no':$(this).attr("idx")
								}
							}).done(function(data) {
								self.location.reload();
							});
						}else{
							return false;
						}
					});
				});
				//]]>
			</script>

			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h3><strong>Modify</strong></h3>
				<form action="/cdol/board/modify_board/<?=$name?>" method="POST" enctype="multipart/form-data">
					<table class="table">
						<input type="hidden" name="b_no" value="<?=$view->b_no?>" />
						<input type="hidden" name="list_num" value="<?=$list_num?>" />
						<tr>
							<td width="70"><strong>아이디 : </strong></td>
							<td><?=$this->session->userdata('name')?> (<?=$this->session->userdata('id')?>)</td>
						</tr>
						<tr>
							<td width="70"><strong><sup>*</sup>제목 : </strong></td>
							<td><input type="text" id="b_title" name="b_title" maxlength="150" class="form-control" placeholder="제목" value="<?=$view->b_title?>" /></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="file" multiple name="board_file[]">


							</td>
						</tr>
						<tr>
<?php
	$i = 0;
	foreach($file_view as $entry){
		if($i >= 1 && $i <= count($file_view)){
			echo " | ";
		}
		$i++;
?>
							<td colspan="1">
								<p><?=$entry->original_name?></p>
<?php
		if($this->session->userdata('id') == $view->id){
?>
								<button type='button' class='file_del close' idx='<?=$entry->f_no?>' title='삭제'>&times;</button>
							</td>
<?php
		}
	}
?>
						</tr>
						<tr>
							<td colspan="2"><textarea id="b_content" name="b_content" class="ckeditor" /></textarea></td>
							<script type="text/javascript">
								var content = '<?=$view->b_content?>';
								CKEDITOR.replace('b_content', {
									filebrowserUploadUrl: '/cdol/board/img_upload'
								});
								CKEDITOR.instances.b_content.setData(content);
							</script>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<button class="btn btn-primary" type="submit" >Modify</button>
								<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
