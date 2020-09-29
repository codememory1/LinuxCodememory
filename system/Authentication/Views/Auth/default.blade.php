<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div class="error">
		{{$error_auth}}
	</div>
	<form action="/auth-handle" method="post" class="cdm fadeInLeft">
		<input type="hidden" name="cdm_token" value="{{protection_token()}}">
		<input type="text" name="login" placeholder="login">
		<input type="password" name="password" placeholder="password">
		<button>auth</button>
	</form>
	
	<div class="container-chat">
		<div class="wrapper"></div>
		<div class="input">
			<form onsubmit="return sendMessage();">
				<input type="text" id="message" placeholder="Сообщение">
				<input type="text" id="to" placeholder="Кому">
				<input type="submit">
			</form>
		</div>
		<span id="typing"></span>
	</div>
	
	<style>
		.container-chat {
			width: 300px;
			height: 400px;
			border-radius: 3px;
			background: #ccc;
			position: relative;
			top: 50px;
			left: 100px;
		    padding: 10px;
		}
		
		.wrapper {
			float: left;
			width: 100%;
			height: 100%;
			overflow: auto;
		}
		
		.message-chat {
			border-radius: 3px;
			float: left;
    		width: 100%;
			margin: 5px 0;
		}
		
		.my_message {
			color: #fff;
			background: blue;
			padding: 4px 6px;
			float: right;
			max-width: 70%;
		}
		
		.other_message {
			color: #fff;
			background: #7d7d7d;
			padding: 4px 6px;
			float: left;
			max-width: 70%;
		}
	</style>
	
	{!!Assets::js('jquery-3.4.1.min')!!}
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
	
	<script>
		const userid = '{{$data_user->userid}}';
	</script>
	
	{!!Assets::js('socket')!!}
	
</body>
</html>