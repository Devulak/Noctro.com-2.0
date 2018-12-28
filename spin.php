<?php
	require_once 'php/init.php';

	$profile = Profile::getInstance();

	$GLB = new GameLotteryBase($profile);

	$GLB->SpinForGame();

	header('Location: ' . Config::GetPath() . "dashboard");
?>