	<div id="page-wrapper">

		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					Users
					<small>Modify</small>
				</h1>
				<ol class="breadcrumb">
					<li>
						<i class="fa fa-dashboard"></i>  <a href="main">Dashboard</a>
					</li>
					<li class="active">
						<i class="fa fa-user"></i> Users
					</li>
				</ol>
			</div>

			<form action="mod_user" method="POST">
				<div class="form-group">
					<label>Id(E-mail)</label>
					<input class="form-control" placeholder="content" value="<?=$user->email?>" disabled>
					<input id="email" name="email" class="form-control" placeholder="content" value="<?=$user->email?>" type="hidden">
				</div>
				<div class="form-group">
					<label>Name</label>
					<input id="name" name="name" class="form-control" placeholder="title" value="<?=$user->name?>">
				</div>
				<div class="form-group">
					<label>Level</label>
					<input id="level" name="level" class="form-control" placeholder="title" value="<?=$user->level?>">
				</div>
				<div>
					<button class="btn btn-primary" type="submit" >Modify</button>
					<a class="btn btn-danger" href="javascript:history.go(-1)" role="button" >Cancel</a>
				</div>
			</form>
		</div>
		<!-- /.row -->

	</div>
	<!-- /#page-wrapper -->

