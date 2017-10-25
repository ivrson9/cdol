	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Users
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-user"></i> Users
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Level</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<p>supervieser=5 | administrator=4 | user=3 | visitor=1</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Email</th>
								<th>Name</th>
								<th>Level</th>
								<th>Point</th>
								<th>isDel</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<form method="POST" id="m_frm" name="m_frm">
								<input type="hidden" name="id" id="id"/>
								<?php
								foreach($user as $entry){
									?>
									<tr>
										<td><a href="javascript:m_frm.submit();" onclick="javascript:void form_post('mod', 'user', '<?=$entry->email?>');"><?=$entry->email?></a></td>
										<td><?=$entry->name?></td>
										<td><?=$entry->level?></td>
										<td><?=$entry->point?></td>
										<td><?=$entry->isDel?></td>
										<td>
											<button type="submit" class="btn btn-xs btn-danger" onclick="javascript:form_post('del', 'user', '<?=$entry->email?>', '');">Del</button>
										</td>
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
		<div>
			<a class="btn btn-primary" href="/cdol/adm/services/add_form" role="button" >Add</a>
		</div>

	</div>
	<!-- /#page-wrapper -->
