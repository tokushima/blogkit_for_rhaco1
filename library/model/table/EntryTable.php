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
class EntryTable extends TableObjectBase{
	/**  */
	var $id;
	/**  */
	var $name;
	/**  */
	var $title;
	/**  */
	var $description;
	/**  */
	var $tag;
	/**  */
	var $createDate;
	/**  */
	var $updateDate;
	/**  */
	var $commentCount;
	/**  */
	var $commentQuestion;
	/**  */
	var $commentAnswer;
	/** 下書き */
	var $draft;
	var $isping;
	var $dependComments;


	function EntryTable($id=null){
		$this->__init__($id);
	}
	function __init__($id=null){
		$this->id = null;
		$this->name = null;
		$this->title = null;
		$this->description = null;
		$this->tag = null;
		$this->createDate = time();
		$this->updateDate = time();
		$this->commentCount = 0;
		$this->commentQuestion = "1 + 1 = ?";
		$this->commentAnswer = "2";
		$this->draft = 0;
		$this->isping = 0;
		$this->setId($id);
	}
	function connection(){
		if(!Rhaco::isVariable("_R_D_CON_","blogkit")){
			Rhaco::addVariable("_R_D_CON_",new DbConnection("blogkit"),"blogkit");
		}
		return Rhaco::getVariable("_R_D_CON_",null,"blogkit");
	}
	function table(){
		if(!Rhaco::isVariable("_R_D_T_","Entry")){
			Rhaco::addVariable("_R_D_T_",new Table(Rhaco::constant("DATABASE_blogkit_PREFIX")."ENTRY",__CLASS__),"Entry");
		}
		return Rhaco::getVariable("_R_D_T_",null,"Entry");
	}


	/**
	 * 
	 * @return database.model.Column
	 */
	function columnId(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Id")){
			$column = new Column("column=id,variable=id,type=serial,size=22,primary=true,",__CLASS__);
			$column->label(Message::_("id"));
			$column->depend("Comment::EntryId");
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Id");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Id");
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
		if(!Rhaco::isVariable("_R_D_C_","Entry::Name")){
			$column = new Column("column=name,variable=name,type=string,size=50,unique=true,chartype=/^[\w\d]*$/i,",__CLASS__);
			$column->label(Message::_("name"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Name");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Name");
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
	function columnTitle(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Title")){
			$column = new Column("column=title,variable=title,type=string,size=100,require=true,",__CLASS__);
			$column->label(Message::_("title"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Title");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Title");
	}
	/**
	 * 
	 * @return string
	 */
	function setTitle($value){
		$this->title = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getTitle(){
		return $this->title;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnDescription(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Description")){
			$column = new Column("column=description,variable=description,type=text,require=true,",__CLASS__);
			$column->label(Message::_("description"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Description");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Description");
	}
	/**
	 * 
	 * @return text
	 */
	function setDescription($value){
		$this->description = TableObjectUtil::cast($value,"text");
	}
	/**
	 * 
	 */
	function getDescription(){
		return $this->description;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnTag(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Tag")){
			$column = new Column("column=tag,variable=tag,type=string,",__CLASS__);
			$column->label(Message::_("tag"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Tag");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Tag");
	}
	/**
	 * 
	 * @return string
	 */
	function setTag($value){
		$this->tag = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getTag(){
		return $this->tag;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCreateDate(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::CreateDate")){
			$column = new Column("column=create_date,variable=createDate,type=timestamp,",__CLASS__);
			$column->label(Message::_("create_date"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::CreateDate");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::CreateDate");
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
	function columnUpdateDate(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::UpdateDate")){
			$column = new Column("column=update_date,variable=updateDate,type=timestamp,",__CLASS__);
			$column->label(Message::_("update_date"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::UpdateDate");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::UpdateDate");
	}
	/**
	 * 
	 * @return timestamp
	 */
	function setUpdateDate($value){
		$this->updateDate = TableObjectUtil::cast($value,"timestamp");
	}
	/**
	 * 
	 */
	function getUpdateDate(){
		return $this->updateDate;
	}
	/**  */
	function formatUpdateDate($format="Y/m/d H:i:s"){
		return DateUtil::format($this->updateDate,$format);
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCommentCount(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::CommentCount")){
			$column = new Column("column=comment_count,variable=commentCount,type=integer,size=22,",__CLASS__);
			$column->label(Message::_("comment_count"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::CommentCount");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::CommentCount");
	}
	/**
	 * 
	 * @return integer
	 */
	function setCommentCount($value){
		$this->commentCount = TableObjectUtil::cast($value,"integer");
	}
	/**
	 * 
	 */
	function getCommentCount(){
		return $this->commentCount;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCommentQuestion(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::CommentQuestion")){
			$column = new Column("column=comment_question,variable=commentQuestion,type=text,",__CLASS__);
			$column->label(Message::_("comment_question"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::CommentQuestion");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::CommentQuestion");
	}
	/**
	 * 
	 * @return text
	 */
	function setCommentQuestion($value){
		$this->commentQuestion = TableObjectUtil::cast($value,"text");
	}
	/**
	 * 
	 */
	function getCommentQuestion(){
		return $this->commentQuestion;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCommentAnswer(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::CommentAnswer")){
			$column = new Column("column=comment_answer ,variable=commentAnswer,type=string,",__CLASS__);
			$column->label(Message::_("comment_answer "));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::CommentAnswer");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::CommentAnswer");
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
	/**
	 * 下書き
	 * 
	 * @return database.model.Column
	 */
	function columnDraft(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Draft")){
			$column = new Column("column=draft,variable=draft,type=boolean,",__CLASS__);
			$column->label(Message::_("draft"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Draft");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Draft");
	}
	/**
	 * 下書き
	 * 
	 * @return boolean
	 */
	function setDraft($value){
		$this->draft = TableObjectUtil::cast($value,"boolean");
	}
	/**
	 * 下書き
	 * 
	 */
	function getDraft(){
		return $this->draft;
	}
	/** 下書き */
	function isDraft(){
		return Variable::bool($this->draft);
	}
	/**
	 * Pingの発行
	 * 
	 * @return database.model.Column
	 */
	function extraIsping(){
		if(!Rhaco::isVariable("_R_D_C_","Entry::Isping")){
			$column = new Column("column=isping,variable=isping,type=boolean,",__CLASS__);
			$column->label(Message::_("isping"));
			Rhaco::addVariable("_R_D_C_",$column,"Entry::Isping");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Entry::Isping");
	}
	/**
	 * Pingの発行
	 * 
	 * @return boolean
	 */
	function setIsping($value){
		$this->isping = TableObjectUtil::cast($value,"boolean");
	}
	/**
	 * Pingの発行
	 * 
	 */
	function getIsping(){
		return $this->isping;
	}
	/** Pingの発行 */
	function isIsping(){
		return Variable::bool($this->isping);
	}


	function setDependComments($value){
		$this->dependComments = $value;
	}
	function getDependComments(){
		return $this->dependComments;
	}
}
?>