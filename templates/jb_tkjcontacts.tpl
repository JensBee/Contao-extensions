<?php
  	$out='';

  	$out.= '<div class="block jb_tkj_contacts '.$this->class.'" style="overflow:visible;margin-top:3em;">';
  	$out.= '<'.$this->hl.' class="s_small" style="margin-bottom:30px;">'.$this->headline.'</'.$this->hl.'>';
  	foreach($this->jb_tkj_contacts as $contact) {
  
	$out.= 	'<div style="margin-top:20px; width=9em; float:left;">'.				
				'<div style="border-bottom:1px dotted #757575"><strong>'.$contact['firstname'].' '.$contact['lastname'].'</strong></div>'.
				$contact['description'].
			'</div>'.
			'<div class="block" style="float:right; margin-right:40px; overflow:visible; background:url(tl_files/tkj-radsport/img/staff_bubble.png) no-repeat; width:120px; height:165px; text-align:center;">';
	if ($contact['avatar']) {
		$out.= '<img style="margin-left:25px; margin-top:-20px; border:2px solid #ff8432;" src="'.$contact['avatar'].'"/>';
	}
	$out.=  '</div>'.
			'<div style="clear:both;"></div>';
  	}
  	
  	$out.= '</div>';
	
  	echo $out;
?>
