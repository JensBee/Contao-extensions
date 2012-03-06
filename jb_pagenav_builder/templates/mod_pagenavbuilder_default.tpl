<?php
  $out = '';

  $out.='<div class="nav_page block">';

  if ($this->hasLeft) {
    $out.='<div class="link_back part first';
    if (!$this->hasMid && !$this->hasRight) {
      $out.=' last';
    }
    $out.='">';
    $out.=$this->cLeft;
    $out.='</div>';
  }

  if ($this->hasMid) { 
    $out.='<div class="link_up part';
    if (!$this->hasLeft) {
      $out.=' first';
    } else {
      if (!$this->hasRight) {
        $out.=' last';
      }
    }
    $out.='">';
    $out.=$this->cMid;
    $out.='</div>';
  }

  if ($this->cRight != '') {
    $out.='<div class="link_forward part';
    if (!$this->hasLeft && !$this->hasMid) {
      $out.=' first last';
    } else {
        $out.=' last';
    }
    $out.='">';
    $out.=$this->cRight;
    $out.='</div>';
  }

  $out.='</div>';

  echo '<!-- indexer::stop -->'.$out.'<!-- indexer::continue -->';

?>
