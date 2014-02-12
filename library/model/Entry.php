<?php
Rhaco::import("model.table.EntryTable");
Rhaco::import("arbo.network.Ping");
Rhaco::import("arbo.text.Zun");

class Entry extends EntryTable{
	function setTag($value){
		$this->tag = " ".trim($value);
	}

	function afterInsert(&$db){
		if($this->getName() == ""){
			$this->setName($this->getId());
			$this->save($db);
		}
		$this->_tagset($db);
		if($this->getIsping()) $this->ping();
	}
	function afterUpdate(&$db){
		return $this->afterInsert($db);
	}
	function beforeUpdate(&$db){
		$this->_tagdrop($db);
	}
	function beforeDelete(&$db){
		$this->_tagdrop($db);
		parent::beforeDelete($db);
	}
	function _tagdrop(&$db){
		$get = $db->get($this);

		if($get !== false){
			foreach(explode(" ",$get->getTag()) as $tag){
				if(!empty($tag) && 1 >= $db->count(new Entry(),new C(Q::ilike(Entry::columnTag()," ".$tag,"p")))){
					$db->delete(new Tag(),new C(Q::ilike(Tag::columnName(),$tag)));
				}
			}
		}
	}

	function _tagset(&$db){
		$tags = $this->tags();
		$result = $db->select(new Tag(),new C(Q::pattern(Tag::columnName(),$tags)));
		
		foreach($tags as $tag){
			$bool = false;

			foreach($result as $obj){
				if(Variable::iequal($tag,$obj->getName())){
					$bool = true;
					break;
				}
			}
			if(!$bool){
				$newtag = new Tag();
				$newtag->setName($tag);
				$db->insert($newtag);
			}
		}		
	}
	function tags(){
		$result = array();
		foreach(explode(" ",$this->getTag()) as $tag){
			$tag = trim($tag);
			if(!empty($tag)) $result[] = $tag;
		}
		return $result;
	}
	function toString(){
		return $this->getTitle();
	}
	function ping(){
		$zun = new Zun();
		$ping = new Ping(Rhaco::url($this->getId()),$this->getCreateDate(),null,Rhaco::url(),$this->getTitle());
		$ping->setDescription($zun->f($this->getDescription()));
		$ping->setTitle($this->getTitle());
		L::debug($ping->send(Rhaco::constant("PING_URL")));
	}
	function rdf(){
		$zun = new Zun();
		$ping = new Ping(Rhaco::url($this->getId()),$this->getCreateDate(),null,Rhaco::url(),$this->getTitle());
		$ping->setDescription($zun->f($this->getDescription()));
		$ping->setTitle($this->getTitle());
		return $ping->rdf();
	}
	function toStringCommentCount(){
		return $this->getCommentCount();
	}
	function toStringUpdateDate(){
		return $this->formatUpdateDate();
	}
	function toStringTag(&$db){
		$column = Entry::columnTag();
		$tags = $db->select(new Tag(),new C(Q::distinct(Tag::columnName())));
		$js = <<< __JS__
<script language="JavaScript">
function toggleTag(word){
	var value = " " + document.views_form.{$column->variable}.value + " ";
	value = value.replace("  "," ");

	if(value.indexOf(" " + word + " ") >= 0){
		value = value.replace(word,"");
	}else{
		value = value + word + " ";
	}
	document.views_form.{$column->variable}.value = value.substring(1,value.length-1);
}
</script>
__JS__;
		foreach($tags as $tag){
			$js .= sprintf('<a href="javascript:toggleTag(\'%s\')">%s</a>&nbsp;',$tag->getName(),$tag->getName());
		}
		return "<p>".$js."</p>".ViewsUtil::form($this,$column);
	}
	function admin(){
		return array("list_display"=>"id,name,title,description,tag,create_date,comment_count",
						"ordering"=>"-id");
	}
	function views(){
		return array("ordering"=>"-create_date");
	}

	function verifyNameInvalid(&$db){
		$column = Entry::columnName();
		$value = TableObjectUtil::getter($this,$column);

		if($value == "tag" || $value == "rss"){
			return ExceptionTrigger::raise(new IllegalArgumentException($column->label),$this->validName($column));
		}
		return true;
	}
}

?>