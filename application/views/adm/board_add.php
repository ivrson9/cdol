	<div id="page-wrapper">

		<div class="container-fluid">

			<!-- Page Heading -->
			<div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">
						Menus
						<small>Add</small>
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
				<form action="add_menu" method="POST">
					<div class="form-group">
						<label>Id</label>
						<input id="id" name="id" class="form-control" placeholder="content">
					</div>
					<div class="form-group">
						<label>Title</label>
						<input id="title" name="title" class="form-control" placeholder="title">
					</div>
					<div>
						<label>Board or Page</label>
					</div>
					<div class="form-group">
						<label class="radio-inline">
							<input type="radio" name="type" id="1" value="b" checked>board
						</label>
						<label class="radio-inline">
							<input type="radio" name="type" id="2" value="p">page
						</label>
					</div>
					<div class="form-group">
						<label>Service</label>
						<select class="form-control" name="service">
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
						<button class="btn btn-primary" type="submit" >Add</button>
						<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
					</div>
				</form>
			</div>
			<!-- /.row -->

		</div>
		<!-- /.container-fluid -->

	</div>
	<!-- /#page-wrapper -->

