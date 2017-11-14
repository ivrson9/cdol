			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h3><strong>Write</strong></h3>
				<form id="writeForm" name="writeForm" enctype="multipart/form-data" method="POST">
					<table class="table">
						<tr>
							<td width="70"><strong>아이디 : </strong></td>
							<td><?=$this->session->userdata('name')?> (<?=$this->session->userdata('id')?>)</td>
						</tr>
						<tr>
							<td width="70"><strong><sup>*</sup>제목 : </strong></td>
							<td><input type="text" name="b_title" id="b_title" maxlength="150" class="form-control" placeholder="제목" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="file" multiple name="board_file[]" id="multiFiles"></td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="b_content" id="b_content" class="ckeditor" rows="13" cols="50" placeholder="내용" /></textarea></td>
						</tr>
					</table>
				</form>
				<table class="table">
					<tr>
						<td colspan="2" align="right">
							<button class="btn btn-primary" id="btn-upload">Add</button>
							<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
						</td>
					</tr>
				</table>
				<script>
				//<![CDATA[
				$(document).ready(function() {
					// 파일 해당경로 업로드 -> b_no 찾아서 hash -> DB fileUpload -> DB board
					$("#btn-upload").on("click", function(){
						var fileList = "";
						var form_data = new FormData();
						var ins = document.getElementById('multiFiles').files.length;

						if( ins != 0 ){
							for (var x = 0; x < ins; x++) {
								form_data.append("board_file[]", document.getElementById('multiFiles').files[x]);
							}

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
									}).appendTo('#writeForm');
									$('#writeForm').attr('action','/cdol/board/write_board/<?=$name?>').submit();
								},
								error: function (request,status,error){
									//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
									alert("파일 업로드가 실패 하였습니다.");
									return false;
								}
							});
						} else {
							$('#writeForm').attr('action','/cdol/board/write_board/<?=$name?>').submit();
						}

						//$('#writeForm').append('fileList', fileList);

					});
				});
				CKEDITOR.replace('b_content', {
					filebrowserUploadUrl : 'board/img_upload'
				});
				//]]>
			</script>

			</div>
