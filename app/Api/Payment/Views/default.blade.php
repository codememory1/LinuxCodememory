<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Оплата</title>
	<?php
		echo Assets::css('all.min');
		echo Assets::css('Api/payment');
		echo Assets::css('libs_component/tooltip');
	
		$payment = new App\Api\Payment\Payment();
	
		$error = $payment->data()->handleError();
		$error = $error->getError();
	?>
</head>
<body>
<!--
	
	
	<span cdm-tooltip="Сообщение" cdm-tooltip-position="top" cdm-tooltip-auto-position="false">Толтип</span>
-->
	
<!--	Основной блок-->
	<main class="container">
		<!--		Блок с описанием-->
		
		<div class="oplata">
			<span>Оплата Товара</span>
		</div>
		
		<div class="header">
			<header id="header__payment">
				<div class="header__content">
					<span class="description">{{$data['description']}}</span>
					<div class="content__header-block-right">
						<a href="#"><i class="fal fa-times-circle"></i></a>
					</div>
				</div>
			</header>
			
<!--			блок с описанием сумма к оплате-->
			<div class="content__header-block-right-two">
				<div class="content__amount">
					<div class="basic-amount">
						<span><span class="text-amount">К оплате: </span><span class="amount-currency"><span id="amount">{{$data['amount']}} <i class="fal fa-ruble-sign"></i></span></span></span>
					</div>
				</div>
			</div>
		</div>
		
<!--		блок информации оплаты-->
		<div class="content-basic">
			<div class="common__content-basic">
				@if(!count($error))
					<div class="information-oplata">
						<span class="basic-info" id="goods">Название Товара: <u>Test#1</u></span>
						<div class="hr"></div>
						<span class="basic-info">Важная информация:</span>
						<ul class="basic-info-ul">
							<li>- Перевод средств будет отправлен на счет пользователя: <a href="">31232214124</a></li>
							<li>- С вашего счета будет списано: <span class="a">{{$data['amount']}} RUB</span></li>
							<li>- Комисия с покупателя: <span class="a">1%</span> / <span class="a">{{$data['amount'] / 10 * 1}} RUB</span></li>
							<li>- Операция действует: <span class="a">10</span> минут</li>
						</ul>
					</div>
					<div class="hr"></div>
					<div class="form-payment">

						<form action="" method="">
							<div class="content-form">
								<div class="content-input">
									<label for="email">Email для отправки чека</label>
									<input type="text" name="email" placeholder="Почта" id="email" value="{{$data['email']}}">
									<button>Отплатить {{$data['amount']}} RUB</button>
								</div>
							</div>
						</form>

					</div>
				@endif
				
				@foreach($error as $code => $message)
					<div class="invalid-payment">
						<span class="message-error-payment">{{$message}} Error Code: {{$code}}.</span>
					</div>
				@endforeach
			</div>
		</div>
		<div class="footer">
			<span><a href="">GAMES-AKK</a> - Универсальный сайт продаж</span>
		</div>
	</main>
	
</body>
</html>

<?php
	//echo Assets::js('jquery-3.4.1.min');
	//echo Assets::js('libs_component/tooltip');
?>


