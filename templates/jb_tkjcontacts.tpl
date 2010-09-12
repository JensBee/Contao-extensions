<?php
  	$out='';
echo 'CNT: '.sizeof($this->jb_tkj_contacts);
  	$out.= '<div class="block jb_tkj_contacts '.$this->class.'" style="overflow:visible;margin-top:2em;">';
  	  	
  	foreach($this->jb_tkj_contacts as $contact) {
		if ($contact['avatar']) {
			$out.= '<div align="center">';
			$out.=	'<div class="block" style="margin-right:40px; overflow:visible; background:url(tl_files/tkj-radsport/img/staff_bubble.png) no-repeat; width:120px; height:165px; text-align:center;">'.	
						'<img style="margin-left:25px; margin-top:-20px; border:2px solid #ff8432;" title="'.$contact['firstname'].' '.$contact['lastname'].'" alt="Foto von '.$contact['firstname'].' '.$contact['lastname'].'" src="'.$contact['avatar'].'"/>'.
					'</div>';
			$out.= '</div>'; 
		}
		$out.= 	'<div style="margin-top:-30px;">'.
					'<div style="border-bottom:1px dotted #757575; font-style:italic;">'.$this->headline.'</div>'.				
					'<div style="float:left;"><strong>'.$contact['firstname'].' '.$contact['lastname'].'</strong></div>'.
					'<div style="float:right;"><a href="#" class="link_forward">Kontakt</a></div>'.
					'<div class="ce_text">'.
						$contact['description'].
					'</div>'.
				'</div>';
  	}
  	
  	
  	$out.= '</div>';
	
  	echo $out;
?>
