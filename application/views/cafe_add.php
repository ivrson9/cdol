	<style type="text/css" >
		.wrap-loading{ /*화면 전체를 어둡게 합니다.*/
			position: fixed;
			left:0;
			right:0;
			top:0;
			bottom:0;
			background: rgba(0,0,0,0.2); /*not in ie */
			filter: progid:DXImageTransform.Microsoft.Gradient(startColorstr='#20000000',endColorstr='#20000000');    /* ie */
		}
		.wrap-loading div{ /*로딩 이미지*/
			position: fixed;
			top:50%;
			left:50%;
			margin-left: -21px;
			margin-top: -21px;
		}
		.display-none{ /*감추기*/
			display:none;
		}
	</style>
	<div class="wrap-loading display-none">
		<div><img src="/cdol/images/ajax_loader.gif"/></div>
	</div>

	<!-- Custom styles for this template -->
	<div class="col-sm-offset-3 col-md-offset-2 main">
		<form action="/cdol/kaffe/cafe/addWait_onWeb" method="POST" enctype="multipart/form-data">
			<label for="inputEmail" class="sr-only">Address</label>
			<input type="text" id="address" name="address" class="form-control" placeholder="Address" required autofocus>

			<label for="inputPassword" class="sr-only">Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Name" required>

			<label for="inputPassword" class="sr-only">Wifi</label>
			<input type="text" id="wifi" name="wifi" class="form-control" placeholder="Wifi" required>

			<label for="inputPassword" class="sr-only">Power</label>
			<input type="text" id="power" name="power" class="form-control" placeholder="Power" required>
			
			<label for="inputPassword" class="sr-only">Seat</label>
			<input type="text" id="seat" name="seat" class="form-control" placeholder="Seat" required>

			<button class="btn btn-primary" type="submit">Find</button>
		</form>
	</div>
	<div class="col-sm-offset-3 col-md-offset-2 main">
		<p> Excel -> Google(Find Location) -> Json </p>
		<form action="/cdol/kaffe/cafe/convertExcel" method="POST" enctype="multipart/form-data">	
			<input type="file" name="cafe_excel">
			<input type="submit" value="파일 전송" />
		</form>
	</div>

	<div class="col-sm-offset-3 col-md-offset-2 main">
		<script>
			window.onload = function() {
				var num = <?=$list_num?>;
				if(num == 1){
					document.getElementById("prev").setAttribute('class', 'disabled');
					document.getElementById("prev_link").setAttribute('href', 'javascript:;');
				}
				if(num == <?=$page_cnt?>){
					document.getElementById("next").setAttribute('class', 'disabled');
					document.getElementById("next_link").setAttribute('href', 'javascript:;');
				}
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
				$("#add_btn").click(function() {
					var length = $("input:checkbox[name='chk']:checked").length;
					var add_list = new Array();

					$(":checkbox[name='chk']:checked").each(function(index){
						add_list[index] = $(this).val();
					});

					if (window.confirm("적용?")) {
						$.ajax({
							url: '/cdol/kaffe/cafe/add',
							data: {add_list: add_list, length: length},
							dataType: 'json',
							type: 'post',
							success: function (result) {
								self.location.reload();
							},
							beforeSend: function (){
								$('.wrap-loading').removeClass('display-none');
							},
							complete: function (){
								$('.wrap-loading').addClass('display-none');
							}
						});
						// $.post('/cdol/kaffe/cafe/add', {
						// 	add_list: add_list,
						// 	length: length
						// },function(data){
						// 	self.location.reload();
						// });
					} else {
						return false;
					}
				});
			});
		</script>

		<h3><strong><?=$name?></strong></h3>
		<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th width="10">
						<label>
							<input type="checkbox" onclick="checkbox_select();" id="chk_all">
						</label>
					</th>
					<td align="center" width="10"><strong>Name</strong></td>
					<td align="center" width="180"><strong>Address</strong></td>
					<td align="center" width="10"><strong>Wifi</strong></td>
					<td align="center" width="10"><strong>Power</strong></td>
					<td align="center" width="10"><strong>Seat</strong></td>
					<td align="center" width="10"><strong>isDone</strong></td>
				</tr>
			</thead>
			<tbody>
<?php
foreach($board_list as $entry){
?>
			<tr>
				<td width="10">
					<label>
						<input type="checkbox" name="chk" value="<?=$entry->add_no?>"> <?=$entry->add_no?>
					</label>
				</td>
				<td align="center"><?=$entry->name?></td>
				<td align="center"><?=$entry->address?></td>
				<td align="center"><?=$entry->wifi?></td>
				<td align="center"><?=$entry->power?></td>
				<td align="center"><?=$entry->seat?></td>
				<td align="center"><?=$entry->isDone?></td>
			</tr>
<?php
	}
?>
			</tbody>
		</table>
		</div>
		<div class="row">
			<div class="col-md-12" style="text-align:right">
				<a class="btn btn-default" id="add_btn">Write</a>
			</div>
		</div>
		<!-- 페이징 처리 -->
		<div style="text-align:center">
			<ul class='pagination'>
<?php
$uri = "/cdol/page/cafe_add";
?>
				<li id="prev">
					<a id="prev_link" href="<?=$uri?>?cnt=<?=$list_num-1?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
				</li>
<?php
	for($cnt = (int)($list_num/(5+1))*5 + 1 ; $cnt <= $page_cnt ; $cnt++ ){
?>
				<li>
					<a href="<?=$uri?>?cnt=<?=$cnt?>"><?=$cnt?></a>
				</li>
<?php
		if($cnt == 5) {
			break;
		}
	}
?>
				<li id="next">
					<a id="next_link" href="<?=$uri?>?cnt=<?=$list_num+1?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
				</li>
			</ul>
		</div>
	</div>