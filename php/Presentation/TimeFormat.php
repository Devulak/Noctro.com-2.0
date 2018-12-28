<?php

namespace Presentation;
	class TimeFormat
	{
		public static function convert($time = false)
		{
			$seconds = time() - $time;

			if($seconds == 0)
			{
				return "just now";
			}
			if($seconds < 0)
			{
				return "never";
			}

			$times['second']	= floor($seconds);
			$times['minute']	= floor($seconds / 60);
			$times['hour']		= floor($seconds / 60 / 60);
			$times['day']		= floor($seconds / 60 / 60 / 24);
			$times['week']		= floor($seconds / 60 / 60 / 24 / 7);
			$times['month']		= floor($seconds / 60 / 60 / 24 / 365 * 12);
			$times['year']		= floor($seconds / 60 / 60 / 24 / 365);

			foreach($times as $key => $value)
			{
				if($value >= 1)
				{
					$smhdwmy = $value . " " . $key . ($value != 1 ? "s" : "");
				}
			}
			
			return $smhdwmy . " ago";
		}
	}
?>