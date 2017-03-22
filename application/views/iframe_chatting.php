<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Socket.IO Chat Example</title>
	<link rel="stylesheet" href="/cdol/static/css/chatting.css">
</head>
<body>
	<ul class="pages">
		<li class="chat page">
			<div class="chatArea">
				<ul class="messages"></ul>
			</div>
			<input class="inputMessage" placeholder="Type here..."/>
		</li>
		<li class="login page">
			<div class="form">
				<h3 class="title">What's your nickname?</h3>
				<input class="usernameInput" type="text" maxlength="14" />
			</div>
			<input type="hidden" id="name" name="name" value="<?=$name?>" />
		</li>
	</ul>

	<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
	<script src="http://localhost:3000/socket.io/socket.io.js"></script>
	<script src="/cdol/static/js/chatting.js"></script>
	<script>
	</script>
</body>
</html>