
	<!-- Custom styles for this template -->
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<form action="/cdol/kaffe/cafe/add" method="POST" enctype="multipart/form-data">
			<label for="inputEmail" class="sr-only">Latitude</label>
			<input type="text" id="latitude" name="latitude" class="form-control" placeholder="Latitude" required autofocus>

			<label for="inputEmail" class="sr-only">Longitude</label>
			<input type="text" id="longitude" name="longitude" class="form-control" placeholder="Longitude" required autofocus>

			<label for="inputPassword" class="sr-only">Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Name" required>

			<label for="inputPassword" class="sr-only">Wifi</label>
			<input type="text" id="wifi" name="wifi" class="form-control" placeholder="Wifi" required>

			<label for="inputPassword" class="sr-only">Power</label>
			<input type="text" id="power" name="power" class="form-control" placeholder="Power" required>

			<button class="btn btn-primary" type="submit">Find + Add</button>
		</form>
	</div>