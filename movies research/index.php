<?php

$arrray = [];

$file = fopen("movie_data.csv","r");
while(! feof($file))
  {
  $array[] = fgetcsv($file);
  }
fclose($file);

if(isset($_GET['search'])){
	$s_word = $_GET['search'];
}
else{
	$s_word = 'murder';
}

if(isset($_GET['threshold'])){
    if ((int)$_GET['threshold']  < 5){
    $thr = $_GET['threshold'];}
}
else{
    $thr = 2;
}


for ($i =0 ;$i < sizeof($array); $i++){
		$filtered_all[] = ["title"=>$array[$i][1],"year"=>(int)$array[$i][0]];
}

$all_json =array();
for ($i =0 ;$i < sizeof($filtered_all); $i++){
	$year = (int)$filtered_all[$i]['year'];
	if ($year!=0){
	if (!isset($all_json[(int)($year/10) * 10])){
		$all_json[(int)($year/10) * 10] = 1;
	}
	else if(isset($all_json[(int)($year/10) * 10])){
		$all_json[(int)($year/10) * 10]++;
	}}
}

$all_data =[];
foreach ($all_json as $key => $value) {
	$all_data[] = ["year"=>$key,"val" =>$value];
	# code...
}

function count_words($story,$word){
    $story = str_replace('.', '', $story);
    $story = str_replace(',', '', $story);
    $story = explode(' ', $story);
    $count = 0;
    foreach ($story as $key){
        if ($key == $word){
            $count++;
        }
    }
    return $count;
}

// substr_count

for ($i =0 ;$i < sizeof($array); $i++){
	if (substr_count(strtolower($array[$i][7]), strtolower($s_word))> $thr){
		$filtered[] = ["title"=>$array[$i][1],"word"=>substr_count(strtolower($array[$i][7]), strtolower($s_word)),"year"=>(int)$array[$i][0]];
	}
}


$fil_json=array();

for ($i =0 ;$i < sizeof($filtered); $i++){
	$year = (int)$filtered[$i]['year'];
	if (!isset($fil_json[(int)($year/10) * 10])){
		$fil_json[(int)($year/10) * 10] = 1;
	}
	else if(isset($fil_json[$year])){
		$fil_json[(int)($year/10) * 10]++;
	}
}

for ($i =1901;$i<=2017;$i++){
	if(!isset($fil_json[(int)($i/10) * 10])){
		$fil_json[(int)($i/10) * 10] = 0;
	}	
}

$fin_data =[];
foreach ($fil_json as $key => $value) {
	if ($all_json[$key]>=1000){
	$fin_data[] = ["year"=>$key,"val" =>(float)$value/$all_json[$key]];}
	# code...
}

?>


<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <title>CoinStats</title>
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" href="css/jquery-ui.structure.min.css">
        <link rel="stylesheet" href="css/jquery-ui.theme.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
    </head>

    <body>

        <!-- Bootstrap grid setup -->
        <div class="container">
        	<div class="row">
        		<div class="col-md-4">
        			<h2>  </h2>
                </div>
            </div>
            <div id="selections" class="row">
                <div class="col-md-6">
                    <form class="form-inline" action="" method="get">
					  <div class="form-group mx-sm-3 mb-2">
					    <label for="search" class="sr-only">search</label>
					    <input type="text" class="form-control" name = "search" id="search" placeholder="word">
					  </div>
                      <div class="form-group mx-sm-3 mb-2">
                        <label for="threshold" class="sr-only">threshold</label>
                        <input type="text" class="form-control" name = "threshold" id="threshold" placeholder="threshold">
                      </div>
					  <button type="submit" class="btn btn-primary mb-2">search</button>
					</form>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                	<h3 style="font-family: 'Roboto Mono', monospace;"><?php echo $s_word; ?>:</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div id="chart-area"></div>                  
                </div>
            </div>
        </div>

    <!-- External JS libraries -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/d3.min.js"></script>
    <script type="text/javascript">var all_data =<?php echo json_encode($all_data,JSON_PRETTY_PRINT) ?>;</script>
    <script type="text/javascript">var word_data =<?php echo json_encode($fin_data,JSON_PRETTY_PRINT) ?>;</script>
    <script type="text/javascript">console.log(<?php echo json_encode($fil_json,JSON_PRETTY_PRINT) ?>);</script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>


    </body>
</html>

