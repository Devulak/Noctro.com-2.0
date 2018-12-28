<?php
	require_once 'php/init.php';

	http_response_code(404);

	LinkCollector::addLink('login');
	LinkCollector::addScript('dust');

	$doc = new Page();

	$doc->setTitle('Oh no, something went wrong!');

	$doc->appendXML('
		<canvas id="background" />
		<script>
			var dust = Dust(document.getElementById("background"), 1);
		</script>
		<h1>Hmm...</h1>
		<h2>Hmm...</h2>
		<h3>Hmm...</h3>
		<h4>Hmm...</h4>
		<h5>Hmm...</h5>
		<h6>Whoops</h6>
	');

	$doc->print();
?>