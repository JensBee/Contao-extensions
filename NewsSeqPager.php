<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    NewsSeqPager
 * @license    LGPL 
 * @filesource
 */

/**
 * Class NewsSeqPager
 *
 * @copyright  Jens Bertram 2010 
 * @author     Jens Bertram <code@jens-bertram.net>
 * @package    NewsSeqPager
 */

class NewsSeqPager extends ModuleNewsReader {

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'news_seqpager_default';

	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate() {
        $articleId = is_numeric($this->Input->get('items')) ? $this->Input->get('items') : 0;
        $articleAlias = $this->Input->get('items');
        $this->news_archives = $this->sortOutProtected(deserialize($this->news_archives));

        // Check whether we should display the newest newsitem if none set
        if ($articleId==0 && $articleAlias=='') {            
		    $objNewsSeq = $this->Database->prepare("SELECT * FROM tl_module WHERE id=?")
                ->limit(1)
				->execute($this->id);
            
    		// Check if there are news archives
	    	if (is_array($this->news_archives) || count($this->news_archives) >= 1) {
		        if ($objNewsSeq->numRows >= 1 && $objNewsSeq->news_seqnav_loadlatest) {
                    // Get newest newsitem id
                    $time = time();
       		        $objArticle = $this->Database->prepare(
                        "SELECT id FROM tl_news ".
                        "WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ".                    
                        (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 " : "").
                        "ORDER BY date desc"
                    )
                    ->limit(1)
                    ->execute($time, $time);

                    // set newest item id
                    if (!$objArticle->numRows < 1 || $objArticle->id) {
                		$this->Input->setGet('items', $objArticle->id);
            		}
        		}
            }
        }
        return parent::generate();
    }

	/**
	 * Generate module
	 */
	protected function compile() {
        // render the newsitem
        parent::compile();

        $articleId = is_numeric($this->Input->get('items')) ? $this->Input->get('items') : 0;
        $articleAlias = $this->Input->get('items');

        // Check whether pagination is enabled
		$objNewsSeq = $this->Database->prepare("SELECT * FROM tl_module WHERE id=?")
            ->limit(1)
			->execute($this->id);

		if ($objNewsSeq->numRows < 1 || !$objNewsSeq->news_seqnav_show)	{
    		$this->Template->hasPagination = false;
			return;
		}
        $this->Template->hasPagination = true;

        if ($objNewsSeq->news_seqnav_template) {
		    $strTemplate = $objNewsSeq->news_seqnav_template;
        }

        global $objPage;
        $article = array();
        $time = time();

        // Get current newsitem id
   		$objArticle = $this->Database->prepare(
            "SELECT date FROM tl_news ".
            "WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ".
            "AND (id=? OR alias=?)". 
            (!BE_USER_LOGGED_IN ? " AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 " : "")
        )
        ->limit(1)
        ->execute($articleId, $articleAlias, $time, $time);

        if ($objArticle->numRows < 1) {
            return;
        }
        $date = intval($objArticle->date);
        $article['current'] = array('date'=>intval($objArticle->date));

        // Get previous newsitem id
        $objArticle = $this->Database->prepare(
            "SELECT *, ".
            "(SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo ".
            "FROM tl_news ".
            "WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ".
            "AND date<? ".
            (!BE_USER_LOGGED_IN ? "AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 " : "").
            "ORDER BY date desc"
        )
        ->limit(1)
        ->execute(
            $article['current']['date'], $time, $time
        );
        if ($objArticle->numRows >= 1) {
            $article['previous']['obj'] = $objArticle;
        }

        // Get next newsitem id
        $objArticle = $this->Database->prepare(
            "SELECT *, ".
            "(SELECT jumpTo FROM tl_news_archive WHERE tl_news_archive.id=tl_news.pid) AS parentJumpTo ".
            "FROM tl_news ".
            "WHERE pid IN(" . implode(',', array_map('intval', $this->news_archives)) . ") ".
            "AND date>? ".
            (!BE_USER_LOGGED_IN ? "AND (start='' OR start<?) AND (stop='' OR stop>?) AND published=1 " : "").
            "ORDER BY date asc"
        )
        ->limit(1)
        ->execute(
            $article['current']['date'], $time, $time
        );
        if ($objArticle->numRows >= 1) {
            $article['next']['obj'] = $objArticle;
        }

        // set template vars
        if (isset($article['next']['obj'])) {
            $this->Template->urlNext=$this->generateNewsUrl($article['next']['obj']);
            $this->Template->titleNext = $article['next']['obj']->headline;
        }
        if (isset($article['previous']['obj'])) {
            $this->Template->urlPrev = $this->generateNewsUrl($article['previous']['obj']);
            $this->Template->titlePrev = $article['previous']['obj']->headline;
        }
	} // end compile()

}
?>
