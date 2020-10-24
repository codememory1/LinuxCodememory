<div class="container-error_log">
	<div class="content-error_log">
		<div class="center-error">
			<center><h3>Ошибка</h3></center>
			<div class="hr"></div>
			<span class="code">
				<mark>Код ошибки:</mark> <b><?=$code;?></b>
			</span>
			<span class="file">
				<mark>Файл:</mark> <b><?=$file;?></b>
			</span>
			<span class="line">
				<mark>Строка:</mark> <b><?=$line;?></b>
			</span>
			<span class="message">
				<mark>Сообщение:</mark> <b><?=$message;?></b>
			</span>
		</div>
	</div>
</div>


<style>
	body {
		background-color: #f0f0f0;
	}
	
	.center-error {
		background: #fff;
		width: 80%;
		min-height: 15px;
		border-radius: 4px;
		position: absolute;
		top: 50%;
    	transform: translate(0px, -50%);
		border: 0.5px solid #e0e0e0;
	}
	
	.content-error_log {
		display: flex;
		justify-content: center;
		align-items: center;
	}
	
	.hr {
		border-bottom: 0.1px solid #e0e0e0;
		width: 100%;
		margin-bottom: 15px;
	}
	
	span {
		margin: 15px;
		float: left;
		width: 100%;
	}
	
	mark {
		background-color: #e02828;
		color: #fff;
		padding: 5px 6px;
		border-radius: 2px;
		width: 20%;
		float: left;
	}
	
	b {
		border-bottom: 1px solid #000;
		padding-left: 50px;
		padding-right: 50px;
		margin-right: 20px;
		float: right;
	}
	
</style>