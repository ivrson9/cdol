	<script>
		window.onload = function() {
			var id = '<?=$board_id?>';
                // board 종류 select
                for(var i=0 ; i < <?=count($list)?> ; i++){
	                	if(id == '')
	                		document.getElementById("board_select").options[0].selected = true;
	                	if(document.getElementById("board_select").options[i].value == id)
	                		document.getElementById("board_select").options[i].selected = true;
                }

                // pagination
                var num = <?=$list_num?>;
			if(num == 1){
				document.getElementById("prev").setAttribute('class', 'disabled');
				document.getElementById("prev_link").setAttribute('href', '');
			}
			if(num == <?=$page_cnt?>){
				document.getElementById("next").setAttribute('class', 'disabled');
				document.getElementById("next_link").setAttribute('href', '');
			}

                // search
                var type = '<?=$search_type?>';
			if(type != ''){
				for(var i=0 ; i < 3; i++){
					if(document.getElementById("search_type").options[i].value == type){
						document.getElementById("search_type").options[i].selected = true;
					}
				}
                }
		}

		// board 변경
		function board_change(){
			var form = document.getElementById("board_list");
			var board_id = document.getElementById("board_id");

			board_id.value = document.getElementById('board_select').value;

			form.submit();
		}

            // 전체선택
		function checkbox_select(){
			var chk_all = document.getElementById("chk_all");
			var chk = document.getElementsByName("chk");

			if(chk_all.checked == true){
				for(i = 0 ; i < chk.length ; i++){
					chk[i].checked = true;
				}
			} else {
				for(i = 0 ; i < chk.length ; i++){
					chk[i].checked = false;
				}
			}
		}

		$(document).ready(function (){
			var id = '<?=$board_id?>';
			// 게시글 삭제
			$("#del_btn").click(function() {
				var length = $("input:checkbox[name='chk']:checked").length;
				var del_list = new Array();

				$(":checkbox[name='chk']:checked").each(function(index){
					del_list[index] = $(this).val();
				});

				if (window.confirm("글을 삭제하시겠습니까?")) {
					$.post('/cdol/adm/boards/del_board', {
						board_id: id,
						del_list: del_list,
						length: length,
						isDel: true
					}, function(data){
						self.location.reload();
					});
				} else {
					return false;
				}
			});

			// 게시글 원복
			$("#return_btn").click(function() {
				var length = $("input:checkbox[name='chk']:checked").length;
				var del_list = new Array();
				$(":checkbox[name='chk']:checked").each(function(index){
					del_list[index] = $(this).val();
				});

				if (window.confirm("삭제 취소?")) {
					$.post('/cdol/adm/boards/del_board', {
						board_id: id,
						del_list: del_list,
						length: length,
						isDel: false
					}, function(data){
						self.location.reload();
					});
				} else {
					return false;
				}
			});
		});
	</script>

	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Boards
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-table"></i> Management
					</li>
					<li class="active">
						Boards
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-sm-9 col-md-8">
				<a class="btn btn-danger" id="del_btn" role="button" >Del</a>
				<a class="btn btn-primary" id="return_btn" role="button" >Return</a>
			</div>
			<div class="col-sm-9 col-md-4" style="text-align:right">
				<div class="form-group">
					<form id="board_list" name="board_list" action="/cdol/adm/boards" method="POST">
						<input type="hidden" id="board_id" name="board_id" value=""/>
					</form>
					<select class="form-control" id="board_select" name="board_select" onChange="board_change();">
						<?php
						foreach ($list as $entry){
							?>
							<option value="<?=$entry->m_id?>"><?=$entry->m_title?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>
									<label>
										<input type="checkbox" onclick="checkbox_select();" id="chk_all">
									</label>
								</th>
								<th>Title</th>
								<th>Id</th>
								<th>Ip_address</th>
								<th>Date</th>
								<th>isDel</th>
							</tr>
						</thead>
						<tbody>
							<form method="POST" id="m_frm" name="m_frm">
								<input type="hidden" name="id" id="id"/>
								<?php
								foreach($board_list as $entry){
									?>
									<tr>
										<td>
											<label>
												<input type="checkbox" name="chk" value="<?=$entry->b_no?>"> <?=$entry->b_no?>
											</label>
										</td>
										<td><?=$entry->b_title?></td>
										<td><?=$entry->id?></td>
										<td><?=$entry->ip_address?></td>
										<td><?=$entry->b_date?></td>
										<td><?=$entry->isDel?></td>
									</tr>
									<?php
								}
								?>
							</form>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- /.row -->
		<div style="text-align:center">
			<ul class='pagination'>
				<?php
				$uri = "/cdol/adm/boards";
				$addUri = "";
				if($search_cont != ''){
					$addUri = "&search_type=".$search_type."&search_cont=".$search_cont;
				}
				?>
				<li id="prev">
					<a id="prev_link" href="<?=$uri?>?b_name=<?=$board_id?>&cnt=<?=$list_num-1?><?=$addUri?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
				</li>
				<?php
				for($cnt = (int)($list_num/(5+1))*5 + 1 ; $cnt <= $page_cnt ; $cnt++ ){
					?>
					<li>
						<a href='<?=$uri?>?b_name=<?=$board_id?>&cnt=<?=$cnt?><?=$addUri?>'><?=$cnt?></a>
					</li>
					<?php
					if($cnt == 5) {
						break;
					}
				}
				?>
				<li id="next">
					<a id="next_link" href="<?=$uri?>?b_name=<?=$board_id?>&cnt=<?=$list_num+1?><?=$addUri?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</div>

		<div class="row">
			<div class="col-md-12" style="text-align:center">
				<form class="navbar-form" role="search" action="/cdol/adm/boards?b_name=<?=$board_id?>&cnt=<?=$list_num?>" method="GET">
					<select class="form-control" id="search_type" name="search_type">
						<option value="b_title">제목</option>
						<option value="b_content">내용</option>
						<option value="all">제목+내용</option>
						<option value="id">아이디</option>
					</select>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" id="search_cont" name="search_cont" value="<?=$search_cont?>"/>
					</div>
					<button class="btn btn-default" onclick="submit">Search</button>
				</form>
			</div>
		</div>

	</div>
	<!-- /#page-wrapper -->

