<?php
Rhaco::import("resources.Message");
Rhaco::import("database.model.TableObjectBase");
Rhaco::import("database.model.DbConnection");
Rhaco::import("database.TableObjectUtil");
Rhaco::import("database.model.Table");
Rhaco::import("database.model.Column");
/**
 * #ignore
 * 
 */
class CommentTable extends TableObjectBase{
	/**  */
	var $id;
	/**  */
	var $name;
	/**  */
	var $comment;
	/**  */
	var $createDate;
	/**  */
	var $entryId;
	var $commentAnswer;
	var $factEntryId;


	function CommentTable($id=null){
		$this->__init__($id);
	}
	function __init__($id=null){
		$this->id = null;
		$this->name = null;
		$this->comment = null;
		$this->createDate = time();
		$this->entryId = null;
		$this->commentAnswer = null;
		$this->setId($id);
	}
	function connection(){
		if(!Rhaco::isVariable("_R_D_CON_","blogkit")){
			Rhaco::addVariable("_R_D_CON_",new DbConnection("blogkit"),"blogkit");
		}
		return Rhaco::getVariable("_R_D_CON_",null,"blogkit");
	}
	function table(){
		if(!Rhaco::isVariable("_R_D_T_","Comment")){
			Rhaco::addVariable("_R_D_T_",new Table(Rhaco::constant("DATABASE_blogkit_PREFIX")."COMMENT",__CLASS__),"Comment");
		}
		return Rhaco::getVariable("_R_D_T_",null,"Comment");
	}


	/**
	 * 
	 * @return database.model.Column
	 */
	function columnId(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::Id")){
			$column = new Column("column=id,variable=id,type=serial,size=22,primary=true,",__CLASS__);
			$column->label(Message::_("id"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::Id");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::Id");
	}
	/**
	 * 
	 * @return serial
	 */
	function setId($value){
		$this->id = TableObjectUtil::cast($value,"serial");
	}
	/**
	 * 
	 */
	function getId(){
		return $this->id;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnName(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::Name")){
			$column = new Column("column=name,variable=name,type=string,require=true,",__CLASS__);
			$column->label(Message::_("name"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::Name");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::Name");
	}
	/**
	 * 
	 * @return string
	 */
	function setName($value){
		$this->name = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getName(){
		return $this->name;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnComment(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::Comment")){
			$column = new Column("column=comment,variable=comment,type=text,require=true,",__CLASS__);
			$column->label(Message::_("comment"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::Comment");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::Comment");
	}
	/**
	 * 
	 * @return text
	 */
	function setComment($value){
		$this->comment = TableObjectUtil::cast($value,"text");
	}
	/**
	 * 
	 */
	function getComment(){
		return $this->comment;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCreateDate(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::CreateDate")){
			$column = new Column("column=create_date,variable=createDate,type=timestamp,",__CLASS__);
			$column->label(Message::_("create_date"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::CreateDate");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::CreateDate");
	}
	/**
	 * 
	 * @return timestamp
	 */
	function setCreateDate($value){
		$this->createDate = TableObjectUtil::cast($value,"timestamp");
	}
	/**
	 * 
	 */
	function getCreateDate(){
		return $this->createDate;
	}
	/**  */
	function formatCreateDate($format="Y/m/d H:i:s"){
		return DateUtil::format($this->createDate,$format);
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnEntryId(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::EntryId")){
			$column = new Column("column=entry_id,variable=entryId,type=integer,size=22,require=true,reference=Entry::Id,",__CLASS__);
			$column->label(Message::_("entry_id"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::EntryId");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::EntryId");
	}
	/**
	 * 
	 * @return integer
	 */
	function setEntryId($value){
		$this->entryId = TableObjectUtil::cast($value,"integer");
	}
	/**
	 * 
	 */
	function getEntryId(){
		return $this->entryId;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function extraCommentAnswer(){
		if(!Rhaco::isVariable("_R_D_C_","Comment::CommentAnswer")){
			$column = new Column("column=comment_answer,variable=commentAnswer,type=string,require=true,",__CLASS__);
			$column->label(Message::_("comment_answer"));
			Rhaco::addVariable("_R_D_C_",$column,"Comment::CommentAnswer");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Comment::CommentAnswer");
	}
	/**
	 * 
	 * @return string
	 */
	function setCommentAnswer($value){
		$this->commentAnswer = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getCommentAnswer(){
		return $this->commentAnswer;
	}


	function getFactEntryId(){
		return $this->factEntryId;
	}
	function setFactEntryId($obj){
		$this->factEntryId = $obj;
	}
}
?>