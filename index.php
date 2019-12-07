<?php
echo '<head>
<title>Devil Guardian :: Your Public IP Detail</title>
<link rel="stylesheet" type="text/css" href="css/main.css" />
</head>';

// Class
require_once('class/geoplugin.class.php');
$geoplugin = new geoPlugin();
$geoplugin->locate();

// IP Detector
function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
	// IP Geo Location Detail
	$apiKey = "9399d685c1614dacac6cb6b893aecc0a";
	$user_ip = getUserIP();

	// IP Detail
	$geo = json_decode(file_get_contents("https://api.ipgeolocation.io/ipgeo?apiKey=$apiKey&ip=$user_ip"));
	$ip = $geo->ip;
	$isp = $geo->isp;
	$connection_type = $geo->connection_type;

		
	// Business Detail
	$organization = $geo->organization;
	$geoname_id = $geo->geoname_id;

		
	// Country Detail
	$continent_code = $geo->continent_code;
	$continent_name = $geo->continent_name;
	$country_code2 = $geo->country_code2;
	$country_code3 = $geo->country_code3;
	$country_name = $geo->country_name;
	$country_capital = $geo->country_capital;
	$state_prov = $geo->state_prov;
	$district = $geo->district;
	$city = $geo->city;
	$zipcode = $geo->zipcode;

	// Location Detail
	$latitude = $geo->latitude;
	$longitude = $geo->longitude;

	// Others Detail
	$is_eu = $geo->is_eu;
	$calling_code = $geo->calling_code;
	$country_tld = $geo->country_tld;
	$languages = $geo->languages;
	$country_flag = $geo->country_flag;

	// IP Logging
	$file = fopen ('ip.log', 'a+');
	fwrite($file, date('Y-m-d H:i:s') . " - $user_ip \r\n")
?>

<h1><center>Your Public IP</center></h1>
<body>
  <table align="center">
	<tr><td><strong>Name of Business</strong></td></tr>
	<tr><td>Organization Name :</td><td><?php echo $organization;?></td></tr>
	<tr><td>Organization Geo ID :</td><td><?php echo $geoname_id;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>IP Summary Detail</strong></td></tr>
	<tr><td>Your IP :</td><td><?php echo $ip;?></td></tr>
	<tr><td>Connection Type :</td><td><?php echo $connection_type;?></td></tr>
	<tr><td>ISP :</td><td><?php echo $isp;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>Locate Location</strong></td></tr>
	<tr><td>Radius of Accuracy (Miles) :</td><td><?php echo $geoplugin->locationAccuracyRadius;?></td></tr>
	<tr><td>Latitude :</td><td><?php echo $latitude;?></td></tr>
	<tr><td>Longitude :</td><td><?php echo $longitude;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>Country Detail</strong></td></tr>
	<tr><td>Continent Code :</td><td><?php echo $continent_code;?></td></tr>
	<tr><td>Continent Name :</td><td><?php echo $continent_name;?></td></tr>
	<tr><td>Country Code 2 :</td><td><?php echo $country_code2;?></td></tr>
	<tr><td>Country Code 3 :</td><td><?php echo $country_code3;?></td></tr>
	<tr><td>Country Capital :</td><td><?php echo $country_capital;?></td></tr>
	<tr><td>State :</td><td><?php echo $state_prov;?></td></tr>
	<tr><td>District :</td><td><?php echo $district;?></td></tr>
	<tr><td>City :</td><td><?php echo $city;?></td></tr>
	<tr><td>Country :</td><td><?php echo $country_name;?></td></tr>
	<tr><td>Zipcode :</td><td><?php echo $zipcode;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>Others Detail</strong></td></tr>
	<tr><td>Call Code :</td><td><?php echo $calling_code;?></td></tr>
	<tr><td>Country TLD :</td><td><?php echo $country_tld;?></td></tr>
	<tr><td>Language :</td><td><?php echo $languages;?></td></tr>
	<tr><td>Flag :</td><td><?php echo $country_flag;?></td></tr>
	<tr><td>IS EU :</td><td><?php echo $is_eu;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>Time Zone & Currency</strong></td></tr>
	<tr><td>Time Zone :</td><td><?php echo $geoplugin->timezone;?></td></tr>
	<tr><td>Exchange Rate :</td><td><?php echo $geoplugin->currencyConverter;
		if ( $geoplugin->currency != $geoplugin->currencyCode ) {
		echo "&nbsp- At todays rate, US$100 will cost you " . $geoplugin->convert(100) . "";
		}?>
	</td></tr>
	<tr><td>Currency Code :</td><td><?php echo $geoplugin->currencyCode;?></td></tr>
	<tr><td>Currency Symbol :</td><td><?php echo $geoplugin->currencySymbol;?></td></tr>
	<tr><td>EU VAT Rate :</td><td><?php echo $geoplugin->euVATrate;?></td></tr>
	<tr><td>In the EU? :</td><td><?php echo $geoplugin->inEU;?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><strong>Nearby Place</strong></td></tr>
	<tr><td></td><td>
	<?php $nearby = $geoplugin->nearby();
				if ( isset($nearby[0]['geoplugin_place']) ) {
				echo "<pre>\n";
				foreach ( $nearby as $key => $array ) {
				echo ($key + 1) .":<br />";
				echo "\t Place: " . $array['geoplugin_place'] . "<br />";
				echo "\t Country Code: " . $array['geoplugin_countryCode'] . "<br />";
				echo "\t Region: " . $array['geoplugin_region'] . "<br />";
				echo "\t County: " . $array['geoplugin_county'] . "<br />";
				echo "\t Latitude: " . $array['geoplugin_latitude'] . "<br />";
				echo "\t Longitude: " . $array['geoplugin_longitude'] . "<br />";
				echo "\t Distance (miles): " . $array['geoplugin_distanceMiles'] . "<br />";
				echo "\t Distance (km): " . $array['geoplugin_distanceKilometers'] . "<br />";
				}
		echo "</pre>\n";
	}
	?></td></tr>
	<tr><td><br/></td></tr>
	<tr><td><br/></td></tr>
  </table>
  <div align="center">
  <footer id="footer">&copy; 2015-<?php echo date("Y"); ?> :: Devil Guardian</footer>
  </div>
</body>