<?php
class TCMB_Currency
{
	
	private $currencyCode;
	private $xml;
	private $currency = array();
	
	function __construct($cache = 0)
	{
		$this->get_tcmb_xml($cache);
		$this->sort_data();
	}
	
	private function get_tcmb_xml($cache = 0)
	{
		if($cache > 0) {
			$cacheName 	= 'currency_feed.xml';
			$cacheAge 	= $cache*60;
			if(!file_exists($cacheName) || filemtime($cacheName) > time() + $cacheAge) {
				$contents = file_get_contents('http://www.tcmb.gov.tr/kurlar/today.xml');
  				file_put_contents($cacheName, $contents);
			}
			$this->xml = simplexml_load_file($cacheName);
		} else {
			$this->xml = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
		}
	}

	private function sort_data()
	{
		foreach($this->xml->Currency as $group => $item)
		{	
			$this->currencyCode = $item['CurrencyCode'];
			foreach($item as $key => $item)
			{
				$this->currency["$this->currencyCode"]["$key"] = "$item";
			}
		}
		
		$this->currency['TRY']['Unit'] 				= 1;
		$this->currency['TRY']['Isim'] 				= 'TÜRK LİRASI';
		$this->currency['TRY']['CurrencyName'] 		= 'TRY';
		$this->currency['TRY']['ForexBuying']		= 1;
		$this->currency['TRY']['ForexSelling']		= 1;
		$this->currency['TRY']['BanknoteBuying']	= 1;
		$this->currency['TRY']['BanknoteSelling']	= 1;
	}
	

	public function get_currency($code)
	{
		return $this->currency[$code];
	}
	
	public function convert($from, $to, $value, $type = 'ForexBuying')
	{
		$deger 	= $value * $this->get_currency($from)[$type];
		$sonuc	= $deger / $this->get_currency($to)[$type];
		return round($sonuc,4);
	}

	public function getDate()
	{
		$output = json_decode(json_encode($this->xml), true);
		return $output['@attributes']['Tarih'];
	}
	
}

?>
