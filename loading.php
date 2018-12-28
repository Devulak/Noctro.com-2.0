<?php
	require_once 'php/init.php';

	$doc = new Page();

	$doc->setTitle('Loading');

	$quote = new Quote('loading');

	$doc->appendXML('
		<header>
			<div class="container">
				<div>
					' . $rules . '
					<div class="description">
						' . $quote->getQuote() . '
					</div>
				</div>
			</div>
		</header>
	');
	$doc->print();
?>