<?php
	date_default_timezone_set("UTC");
    $orderString = '0000'.$_GET['order'];
    $orderAmount = $_GET['sumID'];
    $orderDescription = 'Поръчка '.$orderString;
	$ORDER = str_pad($orderString, 6, "0", STR_PAD_LEFT); // 6 symbol order number - only numeric
	$AD_CUST_BOR_ORDER_ID = $ORDER;
	$AMOUNT = number_format($orderAmount, 2, '.', ''); // Example: 23.46
	$DESC   = $orderDescription;
	$TRTYPE = "1";
	$CURRENCY = "BGN";
	$TERMINAL = "V2400312";
	$MERCHANT = "2000000212";
	$TIMESTAMP = date("YmdHis");

	$NONCE = strtoupper(bin2hex(openssl_random_pseudo_bytes(16))); 
	$P_SIGN = strlen($TERMINAL).$TERMINAL.strlen($TRTYPE).$TRTYPE.strlen($AMOUNT).$AMOUNT.strlen($CURRENCY).$CURRENCY.strlen($ORDER).$ORDER.strlen($MERCHANT).$MERCHANT.strlen($TIMESTAMP).$TIMESTAMP.strlen($NONCE).$NONCE;

	$private_key = '-----BEGIN ENCRYPTED PRIVATE KEY-----
	MIIFDjBABgkqhkiG9w0BBQ0wMzAbBgkqhkiG9w0BBQwwDgQIYGeeSyQ76EsCAggA
	MBQGCCqGSIb3DQMHBAh5GBbOuB+EcgSCBMi43XXDcsHSITgHXqUHN9AbLKyLi0Nx
	t+juCBdnHtRTe63/RysRd6d3DeRVF3iiNqSRETOBvG/Fz/X7BTH/aaRRE4O+er1f
	GEJUBWN/BN+C2xhfdmC+U/+N22RarKvw/kKwnQFPMk8aHDugX4R2LS6yvoGEKyU5
	PLgC05t3SyuGq5HiXGd6A2QLiAHbb2gmr+tY9XPqSo/ZdamS3hTAHFv+TDpn7NVo
	rFluap0CcPf22uAW+MxdT6qbEAThV+80pCMq3066hMWV93oYXcdMHmG5HQuojuGo
	2Um93VA2zcy6YnphIgXr0cpYRD3SUPk5Z0CNsEyXLMrYpEVxrDFORfqHYQWSZvOY
	DTETE+LCN2q5Q6LTBKmU1Y6SKFoKCPti8uErcw/USnZxLpJWtD3p4RiuZx0L7jKm
	RHy4GEQBjQ3zhN1492fuSyCxDs4TE5iHNk0RlQKzRvy5YClnPx4xRnw7IowBSu/f
	DpyPY4ZCKflWb+SAktW1QpGaR6WKYME46vLmdRNjxfKFghIlHZudv/NCIczSEIKa
	8IAQU/zFqqzDnf26GWmGDMMuf5TN9DKXV+7XmVxObFLHF3ayvOAUGoNV4uCzi/aA
	AQgnDIoShyQe1pg++7168O8Ya6TDvMsWhoYf6yeVqFn1Mei3Ds94b1oZeh01vZ2E
	FgFEMR3dM3F5tYI+cKY9hy4iZiqdhTR+0l/cO6ZbyNUhZrFXMqCoffL09VVHJ1aM
	w3ptbtO6OykQRiXDl1XL7499f/EdXc2nUK4SWyi3ow31BhFeK4sPM4u7w0GLN3Av
	rXW94FC6ArwXqjqezALrfxz5gFUC0LCMvfOR/6SgQea9rSEc9Crl+WXNfMCsDxEW
	t6SFU7VcF+Rz+CqagNcFY9MOcP1x4492iQcSBzUEGzt1do6MKIJySGieqtcQifqc
	8O3o4xKF1QvfapHjUqZnd5PE4nFhGp1ejSe+eH5T3TgwjBb46HONBfq3WtXus6yc
	Rei8vmKz/3TpmL5MmNhBUTFO5xOsJQjyDWAa6yDY2tg2iA+/5Yc3j5f/WS8T725w
	vg0zFNiOR6Yi8gyx055Wpcw6QtfLeogQac1nVv+qP+czuZ4SVy+3esX5tPmU++is
	oY58ndtJ0HFaayD1TAFOWobUPXdvZXvr7rUxtUkqbNn/NSXCh/OKEYdexkVq7fAF
	4YNoEz0w8fHFtVI+FSY5Ayl4P6vTGOSQN5FlfHkmeKXdRRihXXIS7WfjjimaZZCF
	ZYB9ZMbpdvfIXjnU1TrGsVBofg0PUzm4zhxlX3XHxqVkOtIth+pt1MZ0OTkU5cr7
	qQ2rzKVUQqGr6xDwE4TFNwc1RHsM/225xRxxFkZRMYerFtyC75zUDhz32mnMBj9p
	9ZAN829MWQV5IyD7qktz9vmP0+PWx/TuMj3BJu8esAgOqju1uyO+O1xWpBn7yoaO
	QevxBQj0dBjXK4GOCHvC81HaTZdP6MVX8p/kIJzgkmvaYBy0NhnTf8rOt2NH0IIX
	+L80n+/SnnhjoU+0TgzdeHKO+icfuAasrhDdIN9kTs7i7KApC4EN870xxYlPUhEX
	123123424234pi23j4oi2uh34ou2g34u
	-----END ENCRYPTED PRIVATE KEY-----
	';
	$priv_key_password = 'passw0rd';

	$private_key_id = openssl_get_privatekey($private_key, $priv_key_password); 
	openssl_sign($P_SIGN, $signature, $private_key_id, OPENSSL_ALGO_SHA256);   

	$P_SIGN = strtoupper(bin2hex($signature)); 

	echo<<<EOT
	<!-- Формуляр за извършване на плащане -->
	<form action="https://3dsgate-dev.borica.bg/cgi-bin/cgi_link" method="post" name="ubbs_form">
	<!-- Фиксирани -->
	<input type="hidden" name="TRTYPE" value="1" />
	<input type="hidden" name="COUNTRY" value="BG" />
	<input type="hidden" name="CURRENCY" value="BGN" />
	<input type="hidden" name="ADDENDUM" value="AD,TD" />
	<input type="hidden" name="MERCH_GMT" value="+03" />
	<!-- Основни -->
	<input type="hidden" name="ORDER"  value="$ORDER" />
	<input type="hidden" name="MERCH_NAME"  value="MyWebSite name" />
	<input type="hidden" name="MERCH_URL"  value="https://mywebsite.com" />
	<input type="hidden" name="AMOUNT" value="$AMOUNT" />
	<input type="hidden" name="DESC"  value="$DESC" />
	<input type="hidden" name="TIMESTAMP" value="$TIMESTAMP" />
	<!-- Допълнителни -->
	<input type="hidden" name="TERMINAL" value="$TERMINAL" />
	<input type="hidden" name="MERCHANT" value="$MERCHANT" />
	<input type="hidden" name="AD.CUST_BOR_ORDER_ID" value="$AD_CUST_BOR_ORDER_ID" />
	<!-- Сигнатури -->
	<input type="hidden" name="NONCE" value="$NONCE" />
	<input type="hidden" name="P_SIGN" value="$P_SIGN" />
	<!-- Буттон -->
	<input type="submit" value="" /> 
	</form>
	EOT;
?>
