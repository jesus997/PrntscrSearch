<?php 
	$id = "7";
	$search_ok = false;
	if(isset($_POST["search"]) && !empty($_POST['search']) && !is_null($_POST['search'])){
		$id = $_POST['search'];
		$search_ok = true; 
	}
	$num = 10;
	if(isset($_POST["res"]) && !empty($_POST['res']) && !is_null($_POST['res'])){
		$num = $_POST['res']; 
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Buscador de imagenes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    	.form-group, .btn-group{
    		width: 100%;
    	}

    	.form-group{
			text-align: center;
			margin-top: 20px;
    	}

    	#search{
    		width: 50px;
    		text-align: center;
    	}

    	#gallery{
    		margin-top: 40px;
    		text-align: center; 
    	}

    	#gallery img{
    		max-width: 800px;
    		height: auto;
    	}

    	.up{
    		width: 60px;
    		height: 60px;
    		position: fixed;
    		right: 10px;
    		bottom: 10px;
    		z-index: 99999999;
    		text-align: center;
    	}

    	.up span{
    		margin-top: 10px;
    		font-size: 2.5em;
    	}

    	h1{
    		margin-top: 60px;
    	}

    	.footer{
    		height: 60px;
    		background-color: #f5f5f5;
    	}

    	.footer > .container > p{
    		margin-top: 23px;
    	}
    </style>
</head>
<body>
	<div class="container">
		<div class="page-header"><h1 class="text-center">Buscador de imagenes de LightShot <small>by jesshilario.net</small></h1></div>
		<form class="form-inline" action="index.php" method="post">
			<div class="form-group">
				<div class="input-group">
				  <span class="input-group-addon" id="basic-addon1">http://prntscr.com/</span>
				  <input type="text" class="form-control" id="search" placeholder="<?php echo $id ?>" name="search" aria-describedby="basic-addon1">
				  <span class="input-group-addon" id="basic-addon2">Numero de resultados</span>
				  <input type="text" class="form-control" id="search" placeholder="<?php echo $num ?>" name="res" aria-describedby="basic-addon2">
				  
				  <span class="input-group-btn">
				  	<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
				  </span>
				</div>
			</div>
		</form>

		<div class="up">
			<a id="up" href="#"><span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span></a>
		</div>

		<div id="gallery">  
			<table class="table">
				<?php
					if($search_ok){
						set_time_limit(0);

						function random_string($length){
						    $chars = "abcdefghijklmnopqrstuvwxyz1234567890";
						    $numChars = strlen($chars);
						    $string = ''; 
						    for ($i = 0; $i < $length; $i++) { 
						        $string .= substr($chars, rand(1, $numChars) - 1, 1);
						    }
						    return $string;
						}

						while ($num > 0) {
							$randstring = random_string(5); 
							$ok = false;
							try {
							    $htmldata = file_get_contents('http://prntscr.com/'.$id.$randstring); 
							    $ok = true;
							} catch (Exception $e) {
								console.log("An error ocurred whit get http://prntscr.com/".$id.$randstring);
								$ok=false;
							}

							if($ok){
								preg_match_all('/<meta name=\"twitter:image:src\" content=\"(.*?)\"\/>/is',$htmldata,$img_url); 
							    if (strlen($img_url[1][0]) > 1) {
							        echo '<tr><td><img src="'. $img_url[1][0] .'"/></td></tr>';
							    }
							    $num -= 1;
							}
						}
					}else{
						echo '<tr><td>LLena el formulario de arriba para buscar.</br>Entre mas resultados pongas mas tiempo tardara en cargar.</br>No me hago responsable por los posibles resultados xD</td></tr>';
					}
				?>
			</table>
		</div>
	</div>

	<div class="footer">
      <div class="container">
        <p class="muted credit text-center">Creado por <a href="http://jesshilario.net">JessHilario</a> con mucho amor para ti <span class="glyphicon glyphicon-heart text-danger"></span>.</p>
      </div>
    </div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.up').click(function(){
				$('body, html').animate({
					scrollTop: '0px'
				}, 300);
			});
			 
			$(window).scroll(function(){
				if( $(this).scrollTop() > 0 ){
					$('.up').slideDown(300);
				} else {
					$('.up').slideUp(300);
				}
			});
		});
	</script>
</body>
</html>
