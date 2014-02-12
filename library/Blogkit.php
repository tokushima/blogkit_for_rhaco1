<?php
Rhaco::import("generic.Views");
Rhaco::import("model.Entry");
Rhaco::import("arbo.text.Zun");

class Blogkit extends Views{
	/**
	 * タグ検索
	 *
	 * @param unknown_type $tags
	 * @return unknown
	 */
	function findtag($tags){
		$criteria = new Criteria();
		$criteria->q(Q::eq(Entry::columnDraft(),false));
		$criteria->q(Q::orderDesc(Entry::columnCreateDate()));

		foreach(explode("/",$tags) as $tag){
			$criteria->q(Q::ilike(Entry::columnTag()," ".$tag,"p"));
		}
		$parser = $this->read(new Entry(),$criteria,null,Rhaco::constant("PAGE_LIMIT",10));
		$parser->setVariable("tags",$tags);
		return $parser;
	}
	function tagrss($tags){
		$criteria = new Criteria();
		$criteria->q(Q::eq(Entry::columnDraft(),false));
		$criteria->q(Q::orderDesc(Entry::columnUpdateDate()));
		$criteria->q(Q::gte(Entry::columnUpdateDate(),DateUtil::addDay(time(),-7)));

		foreach(explode("/",$tags) as $tag){
			$criteria->q(Q::ilike(Entry::columnTag()," ".$tag,"p"));
		}
		$rss = new Rss20(Rhaco::constant("BLOG_TITLE"),Rhaco::constant("BLOG_DESCRIPTION"),Rhaco::url());
		$zun = new Zun();
		$items = array();

		$list = $this->dbUtil->select(new Entry(),$criteria);
		foreach($list as $entry){
			$item = new RssItem20($entry->getTitle(),$zun->f($entry->getDescription()),Rhaco::url($entry->getName()));
			$item->setPubDate($entry->getUpdateDate());
			$items[] = $item;
		}
		$rss->setItem($items);
		$rss->output();
	}
	function rss(){
		$rss = new Rss20(Rhaco::constant("BLOG_TITLE"),Rhaco::constant("BLOG_DESCRIPTION"),Rhaco::url());
		$zun = new Zun();
		$items = array();

		$list = $this->dbUtil->select(new Entry(),new C(Q::eq(Entry::columnDraft(),false),Q::gte(Entry::columnUpdateDate(),DateUtil::addDay(time(),-7)),Q::order(Entry::columnUpdateDate())));
		foreach($list as $entry){
			$item = new RssItem20($entry->getTitle(),$zun->f($entry->getDescription()),Rhaco::url($entry->getName()));
			$item->setPubDate($entry->getUpdateDate());
			$items[] = $item;
		}
		$rss->setItem($items);
		$rss->output();
	}
}
?>