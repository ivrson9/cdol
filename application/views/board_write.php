			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h3><strong>Write</strong></h3>
				<form action="/cdol/board/write_board/<?=$name?>" method="POST" enctype="multipart/form-data">
					<table class="table">
						<tr>
							<td width="70"><strong>아이디 : </strong></td>
							<td><?=$this->session->userdata('name')?> (<?=$this->session->userdata('id')?>)</td>
						</tr>
						<tr>
							<td width="70"><strong><sup>*</sup>제목 : </strong></td>
							<td><input type="text" name="b_title" maxlength="150" class="form-control" placeholder="제목" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="file" multiple name="board_file[]"></td>
						</tr>
						<tr>
							<td colspan="2"><textarea name="b_content" class="ckeditor" rows="13" cols="50" placeholder="내용" /></textarea></td>
							<script>
								CKEDITOR.replace('b_content', {
									filebrowserUploadUrl: '/cdol/board/img_upload'
								});
							</script>
						</tr>
						<tr>
							<td colspan="2" align="right">
								<button class="btn btn-primary" type="submit" >Add</button>
								<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
