<?php

require_once "php/init.php";

$pa = new \Persistence\ProfileAccessor();

$profile = \Presentation\AccessPoint::GetProfile($pa);

if ($profile == null)
{
    echo "Not logged in";
}
else
{
	echo "Logged in";
}