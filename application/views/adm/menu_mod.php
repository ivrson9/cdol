	<div id="page-wrapper">

		<script language="javascript">
			function service_onload(){
				var service = document.getElementById('service');

				for(var i in service){
					if(service[i].value == "<?=$menu->s_no?>"){
						service[i].selected = true;
						break;
					}
				}
			}
			addLoadEvent(service_onload);

			$(document).ready(function() {
				$("#tmp_apply").click(function() {
					$.ajax({
						type:'POST',
						url:'/cdol/adm/menus/set_tmp_page',
						dataType:'text',
						data:{
							'contents_data':$('#contents_data').val()
						}
					}).done(function(data) {
						document.getElementById("tmp_iframe").contentDocument.location.reload(true);
					});
				});
			});
		</script>
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Menus
					<small>Modify</small>
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="main">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-file"></i> Management
					</li>
					<li class="active">
						Menus
					</li>
				</ol>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">explain</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<form action="mod_menu" method="POST" id="mod_menu">
									<input type="hidden" name="prev_service" value="<?=$menu->s_no?>"/>
									<div class="form-group">
										<label>Id</label>
										<input class="form-control" placeholder="content" value="<?=$menu->m_id?>" disabled>
										<input id="id" name="id" class="form-control" placeholder="content" value="<?=$menu->m_id?>" type="hidden">
									</div>
									<div class="form-group">
										<label>Title</label>
										<input id="title" name="title" class="form-control" placeholder="title" value="<?=$menu->m_title?>">
									</div>
									<div class="form-group">
										<label>Board or Page</label>
										<input class="form-control" placeholder="title" value="<?=$menu->m_type?>" disabled>
										<input id="type" name="type" class="form-control" placeholder="title" value="<?=$menu->m_type?>" type="hidden" >
									</div>
									<div class="form-group">
										<label>Service</label>
										<select class="form-control" id="service" name="service">
											<?php
											foreach($service as $entry){
												?>
												<option value="<?=$entry->s_no?>"><?=$entry->s_title?></option>
												<?php
											}
											?>
										</select>
									</div>
									<?php
									if($menu->m_type == 'p'){
										?>
										<div class="form-group">
											<label>Code</label>
											<textarea class="form-control col-sm-5" rows="20" cols="105" id="contents_data" name="contents_data" form="mod_menu">
												<?=$view_file?>
											</textarea>
										</div>
										<div style="text-align:center;">
											<button id="tmp_apply" type="button" class="btn btn-info" style="margin:5px" ><span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>  apply</button>
											<iframe id="tmp_iframe" src="/cdol/page/tmp_page" style="height:500px;width:100%;"></iframe>
										</div>
										<!-- 미리보기 프레임 -->
										<?php
									}
									?>
									<div>
										<button class="btn btn-primary" type="submit" >Modify</button>
										<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
