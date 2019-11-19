<?php
require_once 'config.php';
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Cryptocurrency arbitrage monitor</title>

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:600&display=swap" rel="stylesheet">	
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>	

		<style>
			body {
				font-family: 'Open Sans', sans-serif;
			}
			h4 {
				margin-bottom: 0;
			}
			h4.col-title {
				text-align: center;
			}
			.table td {
				font-size: 18px;
				text-align: center;
				-webkit-transition: all 0.1s linear;
				-moz-transition: all 0.1s linear;
				-o-transition: all 0.1s linear;
				transition: all 0.1s linear;
				padding: 3px;
			}
			.table th {
				background: #eee;
				vertical-align: middle;
			}
			.table td div {
				display: inline-block;
				width: 50%;
				box-sizing: border-box;
				padding: 10px;
				border: 2px solid #fff;
				background: #fdf4f4;
			}
			.btn {
				float: right;
				margin-bottom: 10px;
			}
			.main-container {
				padding-top: 50px;
				padding-left: 30px;
				padding-right: 30px;
			}

		</style>
	</head>
	<body>
		<div class="main-container">
			<button id="control" type="button" class="btn btn-danger btn-lg">Stop</button>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col" width="10%"></th>
						<th scope="col" width="22.5%"><h4 class="col-title">BTC/USD</h4></th>
						<th scope="col" width="22.5%"><h4 class="col-title">BCH/USD</h4></th>
						<th scope="col" width="22.5%"><h4 class="col-title">ETH/USD</h4></th>
						<th scope="col" width="22.5%"><h4 class="col-title">LTC/USD</h4></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($exchanges_list as $exchange) {
					?>
					<tr id="<?php echo $exchange;?>">
						<th scope="row"><h4><?php echo $exchange;?></h4></th>
						<td id="<?php echo $exchange;?>-BTCUSD">
							<div class="bid">
								<h6>Bid</h6>
								<span>Loading..</span>
							</div><div class="ask">
								<h6>Ask</h6>
								<span>Loading..</span>
							</div>
						</td>
						<td id="<?php echo $exchange;?>-BCHUSD">
							<div class="bid">
								<h6>Bid</h6>
								<span>Loading..</span>
							</div><div class="ask">
								<h6>Ask</h6>
								<span>Loading..</span>
							</div>
						</td>
						<td id="<?php echo $exchange;?>-ETHUSD">
							<div class="bid">
								<h6>Bid</h6>
								<span>Loading..</span>
							</div><div class="ask">
								<h6>Ask</h6>
								<span>Loading..</span>
							</div>
						</td>
						<td id="<?php echo $exchange;?>-LTCUSD">
							<div class="bid">
								<h6>Bid</h6>
								<span>Loading..</span>
							</div><div class="ask">
								<h6>Ask</h6>
								<span>Loading..</span>
							</div>
						</td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<script type="application/javascript">
			var stopped=false;
			var timeouts=new Array();
			var exchanges=new Array();
			
			//SET TIME INTERVAL FOR EACH EXCHANGE DATA REQUEST (SECONDS)
            exchanges["BINANCE"]=1;
            exchanges["OKEX"]=1;
            exchanges["HITBTC"]=1;
            exchanges["KRAKEN"]=1;
            exchanges["BITFINEX"]=2;
            exchanges["BITSTAMP"]=1;
            exchanges["BITTREX"]=3;
            exchanges["HUOBI"]=1;
            exchanges["CEXIO"]=3;
            exchanges["POLONIEX"]=1;
            exchanges["COINBASE"]=2;
            exchanges["BITFOREX"]=1;
            
			//GET DATA
			function getData(exchange) {
				if(stopped) {
					return false;
				}

				$.ajax({
					method: "POST",
					url: "process.php?act=get_data",
					data: { e: exchange },
					timeout: 30000,
					success: function(response) {
						response=JSON.parse(response);
						displayData(exchange, response);
						timeouts.push( setTimeout(function() {getData(exchange)}, exchanges[exchange]*1000) );
					}
				});
			}
			
			//DISPLAY DATA
			function displayData(exchange, data) {
				for (i in data) {
					//BID
					var preVal=$("#"+exchange+"-"+i).children(".bid").children("span").html();
					preVal=parseFloat(preVal.replace("$ ", ""));
					var newVal=data[i].bid;
					if(newVal!="ERROR") {
						if(!isNaN(preVal)) {
							if(preVal>newVal) {
								$("#"+exchange+"-"+i).children(".bid").css({"background": "#e74c3c", "color": "#fff"});
							} else if(preVal<newVal) {
								$("#"+exchange+"-"+i).children(".bid").css({"background": "#2ecc71", "color": "#fff"});
							}
						}
						newVal="$ "+newVal;
					} else {
					    console.log(exchange);
					    console.log(Date.now());
					}
					$("#"+exchange+"-"+i).children(".bid").children("span").html(newVal);
					
					//ASK
					var preVal=$("#"+exchange+"-"+i).children(".ask").children("span").html();
					preVal=parseFloat(preVal.replace("$ ", ""));
					var newVal=data[i].ask;
					if(newVal!="ERROR") {
						if(!isNaN(preVal)) {
							if(preVal>newVal) {
								$("#"+exchange+"-"+i).children(".ask").css({"background": "#e74c3c", "color": "#fff"});
							} else if(preVal<newVal) {
								$("#"+exchange+"-"+i).children(".ask").css({"background": "#2ecc71", "color": "#fff"});
							}
						}
						newVal="$ "+newVal;
					}
					$("#"+exchange+"-"+i).children(".ask").children("span").html(newVal);
				}
				
				setTimeout(function() {$("#"+exchange).children("td").children("div").css({"background": "#fdf4f4", "color": "#000000"});}, 1000);
			}
			
			//STOP MONITORING
			function stopMonitoring() {
				stopped=true;
				$("#control").html("Continue");
				$("#control").removeClass("btn-danger");
				$("#control").addClass("btn-success");
				for (var i = 0; i < timeouts.length; i++) {
					clearTimeout(timeouts[i]);
				}
				timeouts=new Array();
			}
			
			//START MONITORING
			function startMonitoring() {
				stopped=false;
				$("#control").html("Stop");
				$("#control").removeClass("btn-success");
				$("#control").addClass("btn-danger");
                var exchanges_names =  Object.keys(exchanges); 

				for (i in exchanges_names) {
					getData(exchanges_names[i]);
				}
			}
			
			//ONCLICK CONTROL
			$("#control").click(function() {
				if(stopped) {
					startMonitoring();
				} else {
					stopMonitoring();
				}
			});

			$(function() {
				startMonitoring();
			});
		</script>
	</body>
</html>