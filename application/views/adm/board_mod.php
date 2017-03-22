	<div id="page-wrapper">

		<div class="container-fluid">
			<script language="javascript">
				window.onload = function(){
					var service = document.getElementById('service');

					for(var i in service){
						if(service[i].value == '<?=$menu->s_no?>'){
							service[i].selected = true;
						}
					}
				}
			</script>
			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Menus
						<small>Modify</small>
					</h1>
					<ol class="breadcrumb">
						<li>
							<i class="fa fa-dashboard"></i>  <a href="main">Dashboard</a>
						</li>
						<li class="active">
							<i class="fa fa-file"></i> Management
						</li>
						<li class="active">
							Boards
						</li>
					</ol>
				</div>

				<form action="mod_menu" method="POST">
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
					<div>
						<button class="btn btn-primary" type="submit" >Modify</button>
						<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
					</div>
				</form>
			</div>
			<!-- /.row -->

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

