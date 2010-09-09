<?php
  /**
   * Generate selectbox contents
   */
  function tpl_beJbLocSelector_parseValues($strId, $intIndex, $intField, $arrData, $intSelected) {
    $element_id=$strId.'['.$intIndex.']['.$intField.']';
    $out ='<td>';
    $out.='<select ';
      $out.='onfocus="Backend.getScrollOffset();" ';
      $out.='class="tl_select" ';
      $out.='id="'.$element_id.'" ';
      $out.='name="'.$element_id.'" ';
      $out.='style="max-width:200px;';
    $out.='">';
    foreach ($arrData as $select) {
      $out.='<option ';
      if ($select[0] == $intSelected) {
        $out.='selected="selected" ';
      }
      $out.=' value="'.$select[0].'">'.$select[1].'</option>';
    }
    $out.='</select>';
    $out.='</td>';
    return $out;
  }

  $out='';

  $out.='<table id="ctrl_'.$this->strId.'" '.$this->attributes.' summary="'.$GLOBALS['TL_LANG']['MSC']['jblocations_tablesummary'].'">';

  $out.='<thead><tr>';
  $out.='<td>'.$this->arrLabels[0].'</td>';
  $out.='<td>'.$this->arrLabels[1].'</td>';
  $out.='</tr></thead>';

  $out.='<tbody>';
 
  $i = 0;
  foreach ($this->arrSelectStates as $arrSelectState) {
    $out.='<tr>';
    $out.=tpl_beJbLocSelector_parseValues($this->strId, $i, 0, $this->arrSelect[0], $arrSelectState[0]);
    $out.=tpl_beJbLocSelector_parseValues($this->strId, $i, 1, $this->arrSelect[1], $arrSelectState[1]);

    $out.='<td style="white-space:nowrap;">';
    foreach ($this->arrButtons as $button) {
      $out.='<a href="';
      $out.=sprintf($button['href'], $i);
      $out.='" title="'.$button['title'].'" onclick="'.$button['onclick'].'">'.$button['img'].'</a>';
    }
    $out.='</td></tr>';
    $i++;
  }

  $out.='</tbody></table>';
  echo $out;

?>
