	<div id="page-wrapper">
		<script>
			$(document).ready(function(){
				$('table tr').click(function(){
					window.location = $(this).attr('href');
					return false;
				});
			});
		</script>

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h2 class="page-header">
					Pages
				</h2>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-table"></i> Management
					</li>
					<li class="active">
						Pages
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">explain</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="table-responsive">
									<table class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>Title</th>
												<th>Name</th>
												<th>Url</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<form method="POST" id="m_frm" name="m_frm">
												<input type="hidden" name="id" id="id"/>
												<?php
												foreach($page as $entry){
													?>
													<tr href="pages/">
														<td><?=$entry->m_id?></td>
														<td><?=$entry->m_title?></td>
														<td><?=$entry->m_url?></td>
														<td>
															<button type="submit" class="btn btn-xs btn-info" onclick="javascript:form_post('mod', 'menu', '<?=$entry->m_id?>');">Mod</button>
															<button type="submit" class="btn btn-xs btn-danger" onclick="javascript:form_post('del', 'menu', '<?=$entry->m_id?>', '<?=$entry->s_no?>');">Del</button>
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
					</div>
				</div>
			</div>
		</div>

	</div>
	<!-- /#page-wrapper -->

