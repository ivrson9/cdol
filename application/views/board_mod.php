
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h3><strong>Modify</strong></h3>
				<form id="modifyForm" name="modifyForm" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="b_no" value="<?=$view->b_no?>" />
					<input type="hidden" name="list_num" value="<?=$list_num?>" />
					<table class="table">
						<tr>
							<td width="70"><strong>아이디 : </strong></td>
							<td><?=$this->session->userdata('name')?> (<?=$this->session->userdata('id')?>)</td>
						</tr>
						<tr>
							<td width="70"><strong><sup>*</sup>제목 : </strong></td>
							<td><input type="text" id="b_title" name="b_title" maxlength="150" class="form-control" placeholder="제목" value="<?=$view->b_title?>" /></td>
						</tr>
						<tr>
							<td width="70"><strong>첨부 : </strong></td>
							<td>
								<input type="file" multiple name="board_file[]" id="multiFiles">
						<?php
							$i = 0;
							foreach($file_view as $entry){ ?>
								<table align="left">
								<tr>
								<td>
							<?php
								if($i >= 1 && $i <= count($file_view)){
									echo "&nbsp;|&nbsp;";
								} ?>
									<span><?=$entry->original_name?></span>
									<span class="file_del close" idx="${row.f_no}" title="삭제">&nbsp;&times;</span>
								</td>
								</tr>
								</table>
							<?php
								$i++;
							} ?>
							</td>
						</tr>
						<tr>
							<td colspan="2"><textarea id="b_content" name="b_content" class="ckeditor" /></textarea></td>
							<script type="text/javascript">

							</script>
						</tr>
					</table>
				</form>
				<table class="table">
					<tr>
						<td colspan="2" align="right">
							<button class="btn btn-primary" id="btn_modify">Modify</button>
							<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
						</td>
					</tr>
				</table>
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
						// 파일 해당경로 업로드 -> DB fileUpload -> DB board (수정부분에서는 b_no탐색 제거)
						$("#btn_modify").on("click", function(){
							var fileList = "";
							var form_data = new FormData();
							var ins = document.getElementById('multiFiles').files.length;

							if( ins != 0 ){
								for (var x = 0; x < ins; x++) {
									form_data.append("board_file[]", document.getElementById('multiFiles').files[x]);
								}
								form_data.append("b_no", "<?=$view->b_no?>");
								$.ajax({
									url: '/cdol/board/fileUpload/<?=$name?>',
									data: form_data,
									type: 'post',
									processData: false,
									contentType: false,
									success: function(result){
										file_data = result.file_data;
										$('<input>').attr({
											type: 'hidden',
											id: 'file_data',
											name: 'file_data',
											value: file_data
										}).appendTo('#modifyForm');
										$('#modifyForm').attr('action','/cdol/board/modify_board/<?=$name?>').submit();
									},
									error: function (request,status,error){
										//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
										alert("파일 업로드가 실패 하였습니다.");
										return false;
									}
								});
							} else {
								$('#modifyForm').attr('action','/cdol/board/write_board/<?=$name?>').submit();
							}
						});
					});
					//]]>
					var content = '<?=$view->b_content?>';
					CKEDITOR.replace('b_content', {
						filebrowserUploadUrl: '/cdol/board/img_upload'
					});
					CKEDITOR.instances.b_content.setData(content);
				</script>

			</div>
