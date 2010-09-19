<?php
	$out='';

	$depth = 0;
	$count = 0;
	foreach ($this->jbpageindex as $arrHeadlineData) {
		$arrCssId = unserialize($arrHeadlineData['cssID']);		
		if ($arrCssId[0]) {
			$headlineDepth_last = $headlineDepth;
			$arrHeadline = unserialize($arrHeadlineData['headline']);
			$headlineDepth = substr($arrHeadline['unit'], 1);
			if ($headlineDepth > $headlineDepth_last) {
				$depth++;
				$count++;
				echo '<ul>';				
			} elseif ($headlineDepth < $headlineDepth_last) {
				if (($headlineDepth - $headlineDepth_last) <= 0) {					
					for ($i=0; $i<$count-1; $i++) {
						echo '</ul>';	
					}
					$count = 0;
					$depth = 1;
				} else {
					$depth = $headlineDepth_last - $headlineDepth;
				} 
			}			
			echo '<li><a href="#'.$arrCssId[0].'">'.$arrHeadline['value'].'</a></li>';
		}
		if ($arrHeadlineData end($array))
	}
	
	echo $out;
?>