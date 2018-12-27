<?php
	header('Content-type: image/svg+xml');
	if($_GET[id])
		mt_srand($_GET[id]);
	$rand = mt_rand(0, 4);
	if(!$rand)
		$colour = 'e21c66';
	elseif($rand == 1)
		$colour = '93ca02';
	elseif($rand == 2)
		$colour = '56c1d6';
	else
		$colour = 'e5ab1b';
?>
<svg fill="#<?php echo $colour; ?>" viewBox="0 0 1500 1500" xmlns="http://www.w3.org/2000/svg">
	<rect width="1500" height="1500"/>
	<rect fill="black" opacity=".1" width="1500" height="750" y="750"/>
	<path fill="#FFFFFF" d="M750,750c138.13,0,250-111.88,250-250S888.13,250,750,250S500,361.88,500,500S611.88,750,750,750z M750,875c-166.88,0-500,83.75-500,250v125h1000v-125C1250,958.75,916.88,875,750,875z"/>
</svg>