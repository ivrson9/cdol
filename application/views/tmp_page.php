
	<!-- Custom styles for this template -->
	<div class="col-sm-offset-3 col-md-offset-2 main">
		<div class="channel_list">
			<a href="" class="btn btn-primary btn-sm">1</a>
			<a href="" class="btn btn-primary btn-sm">2</a>
			<a href="" class="btn btn-primary btn-sm">3</a>
			<a href="" class="btn btn-primary btn-sm">4</a>
			<a href="" class="btn btn-primary btn-sm">5</a>
		</div>
		<div class="video_view">
			<iframe width="560" height="315" src="http://www.youtube.com/embed/jNAK7QL5JjI" frameborder="0"></iframe>
		</div>
	</div>

	<script>
		function goChannelNew(channel, link_url, channel_type, tv_width, tv_height, frname) {
			var f = document.getElementById(frname);

			f.width=tv_width;
			f.height=tv_height;

			document.getElementById("channel2").value = channel;

			if (channel_type == "normalTV"){
				f.src = "channel.asp?channel="+link_url;
			} else if (channel_type == "sawliveTV") {
				f.src = "../../move_view.asp?newchURL=" + link_url;
			} else if (channel_type == "everyonTV") {
				f.src = "../../baseball_view.asp?newchURL=" + link_url;
			} else if (channel_type == "linkUrl") {
				f.src = link_url;
			}
		}


	</script>