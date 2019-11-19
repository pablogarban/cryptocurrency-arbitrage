<?php

class exchanges {
	function __construct() {}
	
	#################
	# NUMBER FORMAT #
	#################
	private function numFormat($n) {
		return number_format($n, 3, '.', '');
	}

	################
	# MAKE REQUEST #
	################
	private function makeRequest($inputData, $emulateBrowser=false) {

		$groupedData=array();
		foreach($inputData as $pair) {
			if($emulateBrowser) {
				$ctx = stream_context_create(array("http"=>array("user_agent"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:63.0) Gecko/20100101 Firefox/63.0")));
				$response = file_get_contents($pair["url"], true, $ctx);
			} else {
				$response = file_get_contents($pair["url"]);
			}
			$groupedData[$pair["symbol"]]=json_decode($response);
		}
		
		return $groupedData;
	}
	
	###########
	# BINANCE #
	###########
	public function getBinance($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.binance.com/api/v3/ticker/bookTicker?symbol=BTCUSDT"),
			array("symbol"=>"BCHUSD","url"=>"https://api.binance.com/api/v3/ticker/bookTicker?symbol=BCHABCUSDT"),
			array("symbol"=>"ETHUSD","url"=>"https://api.binance.com/api/v3/ticker/bookTicker?symbol=ETHUSDT"),
			array("symbol"=>"LTCUSD","url"=>"https://api.binance.com/api/v3/ticker/bookTicker?symbol=LTCUSDT")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->bidPrice) && !empty($resp["BCHUSD"]->bidPrice) && !empty($resp["ETHUSD"]->bidPrice) && !empty($resp["LTCUSD"]->bidPrice)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bidPrice),
				"ask"=>$this->numFormat($resp["BTCUSD"]->askPrice)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bidPrice),
				"ask"=>$this->numFormat($resp["BCHUSD"]->askPrice)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bidPrice),
				"ask"=>$this->numFormat($resp["ETHUSD"]->askPrice)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bidPrice),
				"ask"=>$this->numFormat($resp["LTCUSD"]->askPrice)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}

	########
	# OKEX #
	########
	public function getOkex($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://www.okex.com/api/spot/v3/instruments/BTC-USDT/ticker"),
			array("symbol"=>"BCHUSD","url"=>"https://www.okex.com/api/spot/v3/instruments/BCH-USDT/ticker"),
			array("symbol"=>"ETHUSD","url"=>"https://www.okex.com/api/spot/v3/instruments/ETH-USDT/ticker"),
			array("symbol"=>"LTCUSD","url"=>"https://www.okex.com/api/spot/v3/instruments/LTC-USDT/ticker")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->bid) && !empty($resp["BCHUSD"]->bid) && !empty($resp["ETHUSD"]->bid) && !empty($resp["LTCUSD"]->bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->ask)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}
		
		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	##########
	# HITBTC #
	##########
	public function getHitbtc($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.hitbtc.com/api/2/public/ticker/BTCUSD"),
			array("symbol"=>"BCHUSD", "url"=>"https://api.hitbtc.com/api/2/public/ticker/BCHUSD"),
			array("symbol"=>"ETHUSD","url"=>"https://api.hitbtc.com/api/2/public/ticker/ETHUSD"),
			array("symbol"=>"LTCUSD","url"=>"https://api.hitbtc.com/api/2/public/ticker/LTCUSD")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->bid) && !empty($resp["BCHUSD"]->bid) && !empty($resp["ETHUSD"]->bid) && !empty($resp["LTCUSD"]->bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->ask)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	##########
	# KRAKEN #
	##########
	public function getKraken($toJson=false) {
		$data=array(
			array("symbol"=>"ALL","url"=>"https://api.kraken.com/0/public/Ticker?pair=xbtusd,ethusd,bchusd,ltcusd")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["ALL"]->result->XXBTZUSD->b) && !empty($resp["ALL"]->result->BCHUSD->b) && !empty($resp["ALL"]->result->XETHZUSD->b) && !empty($resp["ALL"]->result->XLTCZUSD->b)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->result->XXBTZUSD->b[0]),
				"ask"=>$this->numFormat($resp["ALL"]->result->XXBTZUSD->a[0])
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->result->BCHUSD->b[0]),
				"ask"=>$this->numFormat($resp["ALL"]->result->BCHUSD->a[0])
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->result->XETHZUSD->b[0]),
				"ask"=>$this->numFormat($resp["ALL"]->result->XETHZUSD->a[0])
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->result->XLTCZUSD->b[0]),
				"ask"=>$this->numFormat($resp["ALL"]->result->XLTCZUSD->a[0])
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;	
	}
	
	#############
	# BITFINEX #
	#############
	public function getBitfinex($toJson=false) {
		$data=array(
			array("symbol"=>"ALL","url"=>"https://api-pub.bitfinex.com/v2/tickers?symbols=tBTCUSD,tBABUSD,tETHUSD,tLTCUSD"),
		);
		
		$resp=$this->makeRequest($data);
		
		if(!empty($resp["ALL"][0][1]) && !empty($resp["ALL"][1][1]) && !empty($resp["ALL"][2][1]) && !empty($resp["ALL"][3][1])) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"][0][1]),
				"ask"=>$this->numFormat($resp["ALL"][0][3])
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"][1][1]),
				"ask"=>$this->numFormat($resp["ALL"][1][3])
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"][2][1]),
				"ask"=>$this->numFormat($resp["ALL"][2][3])
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"][3][1]),
				"ask"=>$this->numFormat($resp["ALL"][3][3])
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}
			
		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	############
	# BITSTAMP #
	############
	public function getBitstamp($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://www.bitstamp.net/api/v2/ticker/btcusd/"),
			array("symbol"=>"BCHUSD","url"=>"https://www.bitstamp.net/api/v2/ticker/bchusd/"),
			array("symbol"=>"ETHUSD","url"=>"https://www.bitstamp.net/api/v2/ticker/ethusd/"),
			array("symbol"=>"LTCUSD","url"=>"https://www.bitstamp.net/api/v2/ticker/ltcusd/")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->bid) && !empty($resp["BCHUSD"]->bid) && !empty($resp["ETHUSD"]->bid) && !empty($resp["LTCUSD"]->bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->ask)
			);

		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	###########
	# BITTREX #
	###########
	public function getBittrex($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.bittrex.com/api/v1.1/public/getticker?market=USD-BTC"),
			array("symbol"=>"BCHUSD","url"=>"https://api.bittrex.com/api/v1.1/public/getticker?market=USD-BCH"),
			array("symbol"=>"ETHUSD","url"=>"https://api.bittrex.com/api/v1.1/public/getticker?market=USD-ETH"),
			array("symbol"=>"LTCUSD","url"=>"https://api.bittrex.com/api/v1.1/public/getticker?market=USD-LTC")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->result->Bid) && !empty($resp["BCHUSD"]->result->Bid) && !empty($resp["ETHUSD"]->result->Bid) && !empty($resp["LTCUSD"]->result->Bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->result->Bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->result->Ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->result->Bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->result->Ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->result->Bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->result->Ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->result->Bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->result->Ask)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	#########
	# HUOBI #
	#########
	public function getHuobi($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.huobi.pro/market/detail/merged?symbol=btcusdt"),
			array("symbol"=>"BCHUSD","url"=>"https://api.huobi.pro/market/detail/merged?symbol=bchusdt"),
			array("symbol"=>"ETHUSD","url"=>"https://api.huobi.pro/market/detail/merged?symbol=ethusdt"),
			array("symbol"=>"LTCUSD","url"=>"https://api.huobi.pro/market/detail/merged?symbol=ltcusdt")
		);
		
		$resp=$this->makeRequest($data);
		

		if(!empty($resp["BTCUSD"]->tick->bid[0]) && !empty($resp["BCHUSD"]->tick->bid[0]) && !empty($resp["ETHUSD"]->tick->bid[0]) && !empty($resp["LTCUSD"]->tick->bid[0])) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->tick->bid[0]),
				"ask"=>$this->numFormat($resp["BTCUSD"]->tick->ask[0])
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->tick->bid[0]),
				"ask"=>$this->numFormat($resp["BCHUSD"]->tick->ask[0])
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->tick->bid[0]),
				"ask"=>$this->numFormat($resp["ETHUSD"]->tick->ask[0])
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->tick->bid[0]),
				"ask"=>$this->numFormat($resp["LTCUSD"]->tick->ask[0])
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	#########
	# CEXIO #
	#########
	public function getCexio($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://cex.io/api/ticker/BTC/USD"),
			array("symbol"=>"BCHUSD","url"=>"https://cex.io/api/ticker/BCH/USD"),
			array("symbol"=>"ETHUSD","url"=>"https://cex.io/api/ticker/ETH/USD"),
			array("symbol"=>"LTCUSD","url"=>"https://cex.io/api/ticker/LTC/USD")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->bid) && !empty($resp["BCHUSD"]->bid) && !empty($resp["ETHUSD"]->bid) && !empty($resp["LTCUSD"]->bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->ask)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	############
	# POLONIEX #
	############
	public function getPoloniex($toJson=false) {
		$data=array(
			array("symbol"=>"ALL","url"=>"https://poloniex.com/public?command=returnTicker")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["ALL"]->USDT_BTC->highestBid) && !empty($resp["ALL"]->USDT_BCHABC->highestBid) && !empty($resp["ALL"]->USDT_ETH->highestBid) && !empty($resp["ALL"]->USDT_LTC->highestBid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->USDT_BTC->highestBid),
				"ask"=>$this->numFormat($resp["ALL"]->USDT_BTC->lowestAsk)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->USDT_BCHABC->highestBid),
				"ask"=>$this->numFormat($resp["ALL"]->USDT_BCHABC->lowestAsk)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->USDT_ETH->highestBid),
				"ask"=>$this->numFormat($resp["ALL"]->USDT_ETH->lowestAsk)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["ALL"]->USDT_LTC->highestBid),
				"ask"=>$this->numFormat($resp["ALL"]->USDT_LTC->lowestAsk)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	############
	# COINBASE #
	############
	public function getCoinbase($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.pro.coinbase.com/products/BTC-USD/ticker"),
			array("symbol"=>"BCHUSD","url"=>"https://api.pro.coinbase.com/products/BCH-USD/ticker"),
			array("symbol"=>"ETHUSD","url"=>"https://api.pro.coinbase.com/products/ETH-USD/ticker"),
			array("symbol"=>"LTCUSD","url"=>"https://api.pro.coinbase.com/products/LTC-USD/ticker")
		);
		
		$resp=$this->makeRequest($data, true);

		if(!empty($resp["BTCUSD"]->bid) && !empty($resp["BCHUSD"]->bid) && !empty($resp["ETHUSD"]->bid) && !empty($resp["LTCUSD"]->bid)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["BTCUSD"]->ask)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->bid),
				"ask"=>$this->numFormat($resp["BCHUSD"]->ask)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->bid),
				"ask"=>$this->numFormat($resp["ETHUSD"]->ask)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->bid),
				"ask"=>$this->numFormat($resp["LTCUSD"]->ask)
			);

		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
	
	
	############
	# BITFOREX #
	############
	public function getBitforex($toJson=false) {
		$data=array(
			array("symbol"=>"BTCUSD","url"=>"https://api.bitforex.com/api/v1/market/depth?symbol=coin-usdt-btc&size=1"),
			array("symbol"=>"BCHUSD","url"=>"https://api.bitforex.com/api/v1/market/depth?symbol=coin-usdt-bch&size=1"),
			array("symbol"=>"ETHUSD","url"=>"https://api.bitforex.com/api/v1/market/depth?symbol=coin-usdt-eth&size=1"),
			array("symbol"=>"LTCUSD","url"=>"https://api.bitforex.com/api/v1/market/depth?symbol=coin-usdt-ltc&size=1")
		);
		
		$resp=$this->makeRequest($data);

		if(!empty($resp["BTCUSD"]->data->bids[0]->price) && !empty($resp["BCHUSD"]->data->bids[0]->price) && !empty($resp["ETHUSD"]->data->bids[0]->price) && !empty($resp["LTCUSD"]->data->bids[0]->price)) {
			$sorted["BTCUSD"]=array(
				"bid"=>$this->numFormat($resp["BTCUSD"]->data->bids[0]->price),
				"ask"=>$this->numFormat($resp["BTCUSD"]->data->asks[0]->price)
			);
			$sorted["BCHUSD"]=array(
				"bid"=>$this->numFormat($resp["BCHUSD"]->data->bids[0]->price),
				"ask"=>$this->numFormat($resp["BCHUSD"]->data->asks[0]->price)
			);
			$sorted["ETHUSD"]=array(
				"bid"=>$this->numFormat($resp["ETHUSD"]->data->bids[0]->price),
				"ask"=>$this->numFormat($resp["ETHUSD"]->data->asks[0]->price)
			);
			$sorted["LTCUSD"]=array(
				"bid"=>$this->numFormat($resp["LTCUSD"]->data->bids[0]->price),
				"ask"=>$this->numFormat($resp["LTCUSD"]->data->asks[0]->price)
			);
		} else {
			$sorted["BTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["BCHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["ETHUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
			$sorted["LTCUSD"]=array("bid"=>"ERROR", "ask"=>"ERROR");
		}

		if($toJson==true) {
			$sorted=json_encode($sorted);
		}
		
		return $sorted;
	}
}

?>