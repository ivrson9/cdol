	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Menus
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-table"></i> Management
					</li>
					<li class="active">
						Menus
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
		<div class="col-lg-12">
				<div class="table-responsive">
					<form method="POST" id="m_frm" name="m_frm">
						<h3>Board</h3>
						<input type="hidden" name="id" id="id"/>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Title</th>
									<th>Name</th>
									<th>Url</th>
									<th>Type</th>
									<th>Service</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($menu as $entry){
									if($entry->m_type=='b'){
										?>
										<tr>
											<td><?=$entry->m_id?></td>
											<td><?=$entry->m_title?></td>
											<td><?=$entry->m_url?></td>
											<td><?=$entry->m_type?></td>
											<td><?=$entry->s_title?></td>
											<td>
												<button type="submit" class="btn btn-xs btn-info" onclick="javascript:form_post('mod', 'menu', '<?=$entry->m_id?>');">Mod</button>
												<button type="submit" class="btn btn-xs btn-danger" onclick="javascript:form_post('del', 'menu', '<?=$entry->m_id?>', '<?=$entry->s_no?>');">Del</button>
											</td>
										</tr>
										<?php
									}
								}
								?>
							</tbody>
						</table>
						<h3>Page</h3>
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Title</th>
									<th>Name</th>
									<th>Url</th>
									<th>Type</th>
									<th>Service</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($menu as $entry){
									if($entry->m_type=='p'){
										?>
										<tr>
											<td><?=$entry->m_id?></td>
											<td><?=$entry->m_title?></td>
											<td><?=$entry->m_url?></td>
											<td><?=$entry->m_type?></td>
											<td><?=$entry->s_title?></td>
											<td>
												<button type="submit" class="btn btn-xs btn-info" onclick="javascript:form_post('mod', 'menu', '<?=$entry->m_id?>');">Mod</button>
												<button type="submit" class="btn btn-xs btn-danger" onclick="javascript:form_post('del', 'menu', '<?=$entry->m_id?>', '<?=$entry->s_no?>');">Del</button>
											</td>
										</tr>
										<?php
									}
								}
								?>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
		<!-- /.row -->
		<div>
			<a class="btn btn-primary" href="/cdol/adm/menus/add_form" role="button" >Add</a>
		</div>

	</div>
	<!-- /#page-wrapper -->
