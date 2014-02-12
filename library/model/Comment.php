<?php
Rhaco::import("model.table.CommentTable");
Rhaco::import("exception.model.GenericException");

class Comment extends CommentTable{
function admin(){
 return array("ordering"=>"-id");
}
	function beforeInsert(&$db){
		$entry = $db->get(new Entry($this->getEntryId()));
		if(!Variable::istype("Entry",$entry)) return false;
		if(preg_match("/^[\w\s\d\:\/<>\[\]\"\'\.,=%&\?]+$/m",$this->comment)) return false;		
		if($entry->getCommentAnswer() != $this->getCommentAnswer()){
			ExceptionTrigger::raise(new GenericException(Message::_("incorrect answer")));
			return false;
		}
	}
	function afterInsert(&$db){
		$get = $db->get(new Entry($this->getEntryId()));
		if($get !== false){
			$get->setCommentCount($get->getCommentCount() + 1);
			$get->setUpdateDate(time());
			$get->save($db);
		}
	}
	function afterDelete(&$db){
		$get = $db->get(new Entry($this->getEntryId()));
		if($get !== false){
			$get->setCommentCount($get->getCommentCount() - 1);
			$get->save($db);
		}
	}
}

?>