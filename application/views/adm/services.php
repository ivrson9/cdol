	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Services
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-table"></i> Management
					</li>
					<li class="active">
						Services
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<form method="POST" id="m_frm" name="m_frm">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>Title</th>
									<th>Name</th>
									<th>Url</th>
									<th>Menu Count</th>
									<th>Del</th>
								</tr>
							</thead>
							<tbody>
								<input type="hidden" name="id" id="id"/>
								<?php
								foreach($service as $entry){
									?>
									<input type="hidden" names="s_id" value="<?=$entry->s_id?>">
									<tr>
										<td><?=$entry->s_id?></td>
										<td><?=$entry->s_title?></td>
										<td><?=$entry->s_url?></td>
										<td><?=$entry->m_cnt?></td>
										<td>
											<button type="submit" class="btn btn-xs btn-info" onclick="javascript:form_post('mod', 'serv', '<?=$entry->s_id?>');">Mod</button>
											<button type="submit" class="btn btn-xs btn-danger" onclick="javascript:form_post('del', 'serv', '<?=$entry->s_id?>', '<?=$entry->s_no?>');">Del</button>
										</td>
									</tr>
									<?php
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
			<a class="btn btn-primary" href="/cdol/adm/services/add_form" role="button" >Add</a>
		</div>


	</div>
	<!-- /#page-wrapper -->

