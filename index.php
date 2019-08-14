<?php
$file = "data/data.json";
	if(!file_exists($file)){
		$json = file_get_contents('http://sknt.ru/job/frontend/data.json');
		$replace = json_decode($json);
		$tmp = $replace->tarifs[0]->tarifs[0];

		$replace->tarifs[0]->tarifs[0] = $replace->tarifs[0]->tarifs[1];
		$replace->tarifs[0]->tarifs[1] = $tmp;

		unset($tmp);

		foreach ($replace->tarifs as $plan){

			$max = $plan->tarifs[0]->price;
			$a = sizeof($plan->tarifs)-1;
			$min = $plan->tarifs[$a]->price / $plan->tarifs[$a]->pay_period;
			$plan->range = $min." - ".$max;

			unset($min,$a);

			foreach ($plan->tarifs as $b){
				$b->discount = ($max - ($b->price / $b->pay_period)) * $b->pay_period;
			}
		}
		file_put_contents($file, json_encode($replace));
	}

?>

<!DOCTYPE html>
<html lang="en">
 <head>
  <title>Test task from SkyNet</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="icon" href="/favicon.ico">

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" />
    <link rel="stylesheet" href="/css/style.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  
  <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
  <script src="https://unpkg.com/vue-router/dist/vue-router.min.js"></script>

  

  
 </head>
 <body>

<section class="container" id="app" >
	<router-view></router-view>
</section>

<script type="text/x-template" id="page1">
	<div class="row d-flex">
		<div v-for="(plan, index) in plans" style="width: 100% !important;" class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
			<div class="card">
				
				<div class="card-body">
					<a :href="'#/'+index">
						<div>
							<h5 class="title">Тариф "{{plan.title}}" </h5>
							<hr>
							<h6 v-if="plan.speed===50" class="card-subtitle mb-2 text-tarifs tarifs_50" > {{plan.speed}} Мбит/с</h6>
							<h6 v-if="plan.speed===100" class="card-subtitle mb-2 text-tarifs tarifs_100" > {{plan.speed}} Мбит/с</h6>
							<h6 v-if="plan.speed===200" class="card-subtitle mb-2 text-tarifs tarifs_200" > {{plan.speed}} Мбит/с</h6>
							<b class="card-text">{{ plan.range }} &#8381;/мес</b>
							<ul>
							   <li><span class="arrow arrow-right"></span></li>
							</ul>
							<div class="option">
								<p v-for="option in plan.free_options">{{option}}</p>
							</div>
						<div>
					</a>
					<hr>
					<a :href="plan.link">
						узнать подробнее на сайте www.sknt.ru
					</a>
				</div>

			</div>
		</div>
	</div>
</script>
<script type="text/x-template" id="page2">
	<section>
		<div class="card card-header">
						<h2 class="text-center">
							<button onclick="history.back();" class="btn float-left">
								<span class="arrow arrow-left"></span>
							</button>
							{{plans[$route.params.id].title}}
						</h2>
		</div>

		<div class="row d-flex">
			<div v-for="(plan, index) in plans[$route.params.id].tarifs" class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<div class="card">
					<div class="card-body">
					<h5 class="title">{{plan.title}}</h5>
					<hr>
					<a :href="'#/'+$route.params.id+'/'+index">
						<div>
						<b class="card-text">{{ plan.price / plan.pay_period }} ₽/мес </b>
						<ul class="page-two">
							   <li><span class="arrow arrow-right"></span></li>
						</ul>
						<p>Разовый платеж — {{ plan.price }} &#8381;</p>
						<p v-if="plan.discount>0"> Скидка — {{ plan.discount }} ₽</p>
						</div>
					</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</script>
<script type="text/x-template" id="page3">
	<section>
			<div class="card card-header">
				<h2 class="text-center">
					<button onclick="history.back();" class="btn float-left">
						<span class="arrow arrow-left"></span>
					</button>
					Выбор тарифа
				</h2>
			</div>



		<div class="row d-flex justify-content-center">
			<div class="col-12 col-xs-12 col-sm-12 col-md-6 col-lg-4">
				<div class="card">
					<div class="card-body">
						<h5 class="title">Тариф {{plan.title}}</h5>
						<hr>
						<b class="card-text">Период оплаты — {{plan.pay_period}} мес. <br>
						{{ plan.price / plan.pay_period }} &#8381;/мес </b>

						<p>разовый платёж —  {{ plan.price }} &#8381; </p>
						<p>со счета спишется — {{ plan.price }} &#8381;</p>
						<div class="card-description">
						<p>вступит в силу —  сегодня </p>
						<p>активно до — {{new Date(new Date().setMonth(+(plan.pay_period)+today.getMonth())).ddmmyyyy() }}</p>
						</div>
					
						<a href="#" class="btn btn-select btn-block">
							Выбрать
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
</script>

<script src="/js/main.js"></script>

</body>
</html>
