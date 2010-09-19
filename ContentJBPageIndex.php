<?php
/*
// page content (page id)
SELECT * FROM tl_content WHERE pid=? ORDER BY sorting

// page config (page id)
SELECT * FROM tl_page WHERE id=?

// page layout (page id) - if tl_page.layout != 0
SELECT * FROM tl_layout WHERE id=(SELECT layout FROM tl_page WHERE id=?)
// page layout - if tl_page.layout == 0
SELECT * FROM tl_layout WHERE fallback=1
*/

class ContentJBPageIndex extends ContentElement {
	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'jb_pidx';
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
		if (TL_MODE == 'BE') {
			$objTemplate = new backendTemplate('be_wildcard');
			$objTemplate->wildcard = '### '.$GLOBALS['TL_LANG']['CTE']['jb_pageindex'][0].' ###<br>'.
				$GLOBALS['TL_LANG']['tl_article'][$this->jbpageindex_section];

			return $objTemplate->parse();
		}
		return parent::generate();
	}

	protected function getPageContent($pid) {
		return $this->Database->prepare("Select headline, cssID FROM tl_content ".
										"WHERE pid=? AND headline!='' AND invisible!=1 ".
										"ORDER BY sorting ASC")
			->execute(intval($pid))->fetchAllAssoc();
	}
	
	/**
	 * Generate module
	 */
	protected function compile() {		
		$this->Template = new FrontendTemplate(($this->jbpageindex_template ? $this->jbpageindex_template : $this->strTemplate));		

        $this->Template->jbpageindex = $this->getPageContent($this->pid);
	}
	
}
?>