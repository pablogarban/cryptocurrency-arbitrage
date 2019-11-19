<?php
require_once 'config.php';
if(isset($_POST["e"]) && in_array($_POST["e"], $exchanges_list)) {
	require_once 'classes/exchanges.php';

	$exchanges=new exchanges;
	
	switch ($_POST["e"]) {
		case "BINANCE":
			echo $exchanges->getBinance(true);
			break;
		case "OKEX":
			echo $exchanges->getOkex(true);
			break;
		case "HITBTC":
			echo $exchanges->getHitbtc(true);
			break;
		case "KRAKEN":
			echo $exchanges->getKraken(true);
			break;
		case "BITFINEX":
			echo $exchanges->getBitfinex(true);
			break;
		case "BITSTAMP":
			echo $exchanges->getBitstamp(true);
			break;
		case "BITTREX":
			echo $exchanges->getBittrex(true);
			break;
		case "HUOBI":
			echo $exchanges->getHuobi(true);
			break;
		case "CEXIO":
			echo $exchanges->getCexio(true);
			break;
		case "POLONIEX":
			echo $exchanges->getPolonieX(true);
			break;
		case "COINBASE":
			echo $exchanges->getCoinbase(true);
			break;
		case "BITFOREX":
			echo $exchanges->getBitforex(true);
			break;
	}
}