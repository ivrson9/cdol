
	<!-- Custom styles for this template -->
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<form action="/cdol/contents/imgGoogle" method="POST" enctype="multipart/form-data">
			<label for="inputEmail" class="sr-only">Keywords</label>
			<input type="text" id="key" name="key" class="form-control" placeholder="Keywords" required autofocus>

			<label for="inputPassword" class="sr-only">Image Count</label>
			<input type="text" id="img_cnt" name="img_cnt" class="form-control" placeholder="Image Count" required>

			<label for="inputPassword" class="sr-only">Correlate Count</label>
			<input type="text" id="corr_cnt" name="corr_cnt" class="form-control" placeholder="Correlate Count" required>

			<label for="inputPassword" class="sr-only">Depth</label>
			<input type="text" id="dep" name="dep" class="form-control" placeholder="Depth" required>

			<button class="btn btn-primary" type="submit">Find</button>
		</form>
	</div>