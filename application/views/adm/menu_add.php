	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Menus
					<small>Add</small>
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="main">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-file"></i> Management
					</li>
					<li class="active">
						Meuns
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
								<form action="add_menu" method="POST" role="form">
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
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->
