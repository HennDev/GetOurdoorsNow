 <?php
	require 'vendor/autoload.php';
	include("databasecmdline.php");
	include("common.php");
	echo phpinfo();
	$pdo = Database::connect();
	
	//Get the users info 
	$statement = $pdo->prepare("select `user_id`,`email`,`password`,`first_name`, `last_name`, `isOutffiter` FROM users us");
	$statement->execute();
	$results = $statement->fetchAll();
	
	print print_r($results,true);
	
	
	print "Hello World!";
	
	$api = new Binance\API("vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A
","NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j");
	// Get latest price of a symbol
	$ticker = $api->prices();
	print_r($ticker); // List prices of all symbols
	echo "Price of BNB: {$ticker['BNBBTC']} BTC.\n";
	
	$ticks = $api->candlesticks("BNBBTC", "5m");
	
	
print_r($ticks);


	
	$prevday = $api->prevDay("BNBBTC");
	print_r($prevday);
	
	echo print_r(get_loaded_extensions(),true);
	
	//print "trader_cci BNBBTC: ".trader_cci();
	$vals = array(1,2,3,4);
	$atrs = trader_ma($vals, 14, $closes, TRADER_MA_TYPE_SMA);
	echo $atrs;
		
		?>

