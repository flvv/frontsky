<?php
error_reporting(E_ALL);
error_reporting(E_NOTICE);


$url = 'https://www.sknt.ru/job/frontend/data.json';
$json = file_get_contents($url);
$data = json_decode($json, TRUE);

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


<style>

</style>

 </head>
 <body>

<section class="container" id="app" >
	<router-view></router-view>
</section>

<div class="container">

    <div class="row">

    <?php foreach ($data['tarifs'] as $character) : ?>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
	    <div class="card">
		  <div class="card-body">
		    <h5 class="card-title title">Тариф "<?php echo $character['title']; ?>" </h5>
			    <hr>
				    <a href="#page2"> <!-- test:fix -->
					    <h6 class="card-subtitle mb-2 text-tarifs tarifs_<?php echo $character['speed']; ?>"><?php echo $character['speed']; ?> Мбит/с</h6>
							<ul>
							   <li><span class="arrow arrow-right"></span></li>
							</ul>
					    <p class="card-text">
					    <?php foreach ($character['tarifs'] as $key) {
								if ($key['pay_period'] == "12") { $clearPriceRange = intval($key['price']) / 12; }
								if ($key['pay_period'] == "1") { $keyFirstPrice = intval($key['price']);}
							} echo $clearPriceRange .' - '.$keyFirstPrice . ' &#8381;/мес'; ?>
					     </p>

					    <p><?php foreach ($character['free_options'] as $key) { echo $key . "<br>"; } ?></p>
				    </a>
			    <hr>
		    <a href= '<?php echo $character['link']; ?>' class="card-link">узнать подробнее на сайте www.sknt.ru</a>
		    <a role="button" href="#" class="btn btn-select btn-block hidden"> Выбрать </a>
		  </div>
		</div>
	</div>	
	
	<?php endforeach; ?>

	</div>



</body>
</html>
