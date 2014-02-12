<?php
/**
 * blogkitのビュー
 */
require_once(dirname(__FILE__)."/__init__.php");
Rhaco::import("generic.Urls");
Rhaco::import("generic.Views");
Rhaco::import("network.http.Http");
Rhaco::import("database.TableObjectUtil");
Rhaco::import("tag.feed.FeedParser");
Rhaco::import("model.Entry");
Rhaco::import("model.Comment");
Rhaco::import("model.Tag");
Rhaco::import("arbo.text.Zun");
Rhaco::import("Blogkit");

$pattern = array(
			"^$"=>array("template"=>Rhaco::constant("TEMPLATE")."/entry_list.html",
							"method"=>"read",
							"args"=>array(new Entry(),new C(Q::eq(Entry::columnDraft(),false),Q::pager(Rhaco::constant("PAGE_LIMIT",10)))),
							"default"=>true
			),
			"^tag/(.+)$"=>array("template"=>Rhaco::constant("TEMPLATE")."/entry_list.html",
								"class"=>"Blogkit",
								"method"=>"findtag"),
			"^rss/(.+)$"=>array("class"=>"Blogkit","method"=>"tagrss"),
			"^rss[/]*$"=>array("class"=>"Blogkit","method"=>"rss"),
			"^([\w]+)[/]*$"=>array("method"=>"detail"),
			);

$db = new DbUtil(Comment::connection());
$parser = Urls::parser($pattern,$db);
$parser->setVariable("comment_list",$db->select(new Comment(),new C(Q::pager(5),Q::orderDesc(Comment::columnCreateDate()),Q::fact())));
$parser->setVariable("tag_list",$db->select(new Tag(),new C(Q::order(Tag::columnName()),Q::distinct(Tag::columnName()))));
$parser->setVariable("feed_list",FeedParser::getItem(Rhaco::constant("FEED_URL")));
$parser->setVariable("z",new Zun());
$parser->setVariable("links",links());
$parser->write();

function detail($name){
	global $db;

	$object = $db->get(new Entry(),new C(Q::eq(Entry::columnDraft(),false),Q::eq(Entry::columnName(),$name),Q::fact()));

	if($object === null){
		Http::status(404);
		Header::redirect(Rhaco::url());
	}
	$flow = new Flow();

	if($flow->isValid() && $flow->isPost()){
		$comment = $flow->toObject(new Comment());

		if($comment->save($db)){
			Header::redirect(Rhaco::url($object->getName()));
		}
	}
	$flow->setVariable("object",$object);
	$flow->setVariable("detail_comment_list",$db->select(new Comment(),new C(Q::eq(Comment::columnEntryId(),$object->getId()),Q::order(Comment::columnCreateDate()))));
	$flow->setTemplate(Rhaco::constant("TEMPLATE")."/entry_detail.html");
	return $flow->parser();
}

function links(){
	$result = array();
	foreach(explode("\n",Rhaco::constant("LINKS")) as $link){
		$link = trim($link);
		if(!empty($link)){
			list($url,$name) = explode(" ",$link,2);
			$result[$url] = $name;
		}
	}
	return $result;
}

?>