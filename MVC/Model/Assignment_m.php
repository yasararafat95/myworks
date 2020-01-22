<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assignment_m extends MY_Model {

	protected $_table_name = 'assignment';
	protected $_primary_key = 'assignmentID';
	protected $_primary_filter = 'intval';
	protected $_order_by = "deadlinedate desc";

	function __construct() {
		parent::__construct();
	}

	function join_get_assignment($classesID, $schoolyearID) {
		$this->db->select('*');
		$this->db->from('assignment');
		$this->db->join('subject','subject.subjectID = assignment.subjectID AND subject.classesID = assignment.classesID', 'LEFT');
		$this->db->where('assignment.schoolyearID', $schoolyearID);
		$this->db->where('assignment.classesID', $classesID);
		$query = $this->db->get();
		return $query->result();
	}
	
	function join_get_assignment_with_answer($classesID, $schoolyearID,$secid,$uID) {
		$this->db->select('assignment.title as title,subject.subject as subject,assignment.subjectID as subjectID,assignment.description as description, assignment.deadlinedate as deadlinedate,assignment.assignmentID as assignmentID,assignment.sectionID as sectionID,assignment.classesID as classesID,assignment.usertypeID as usertypeID,assignment.schoolyearID as schoolyearID,assignmentanswer.status as ansstatus,assignmentanswer.uploaderID as userID,assignment.originalfile as originalfile');
		$this->db->from('assignment');
		$this->db->join('subject','subject.subjectID = assignment.subjectID AND subject.classesID = assignment.classesID', 'LEFT');
		$this->db->join('assignmentanswer','assignmentanswer.assignmentID = assignment.assignmentID AND assignmentanswer.uploaderID ='.$uID, 'LEFT');
		$this->db->where('assignment.schoolyearID', $schoolyearID);
		$this->db->where('assignment.classesID', $classesID);
		$query = $this->db->get();
		return $query->result();
	}
	function join_faculty($user_typeid=null,$userID=null,$classesID=null, $schoolyearID=null) {
		
		$where='';
		if($user_typeid!='' || $userID!='')
		{
			$where.='where';
			
			if($user_typeid!='')
			{
				$where.= " a.usertypeID = ".$user_typeid."";
			}
			if($user_typeid!='' && $userID!='')
			{
				$where.= " and ";
			}
			if($userID!='')
			{
				$where.= "a.userID = ".$userID."";
			}
			if(($userID!='' && $classesID!='') || ($user_typeid!='' && $classesID!=''))
			{
				$where.= " and ";
			}
			if($classesID!='')
			{
				$where.= "a.classesID = ".$classesID."";
			}
		}
			$query = $this->db->query("select a.assignmentID,s.subject,a.title,a.description,a.deadlinedate,a.usertypeID,a.sectionID,
			a.userID,a.originalfile,a.file,a.atype
			from assignment a
			left join subject s on (s.subjectID = a.subjectID)
			left join classes c on (c.classesID = a.classesID)
			left join teacher t on (t.teacherID = a.userID)
		 ".$where."");
		
		$result = $query->result();
		return $result;
	}
	/* function join_assignment($classesID, $schoolyearID) {
		$this->db->select('*');
		$this->db->from('assignment');
		$this->db->join('subject','subject.subjectID = assignment.subjectID AND subject.classesID = assignment.classesID', 'LEFT');
		$this->db->where('userid='.$userID.''and (usertypeID='.$usertypeID.');
		
		$query = $this->db->get();
		 return $query->result();
	}*/
	public function get_order_by_studentfeedback($array) {
        $usertypeID = $this->session->userdata('usertypeID');
        $userID = $this->session->userdata('loginuserID');
		
        $schoolyearID = $this->session->userdata('defaultschoolyearID');
		$loginusertypeID = $this->session->userdata('usertypeID');
		$this->db->select('*');
        $this->db->from('assignment');
		$this->db->where("schoolyearID",$array['schoolyearID']);
		
		if($usertypeID !=1 && isset($userID) && $usertypeID !=12){
			
			$where = '(userid='.$userID.' or (usertypeID='.$usertypeID.' and useriD=0))';
			
			$this->db->where($where);
		}
		
		$query = $this->db->get();
		
       return $query->result();
	    }
	public function get_comments_studentfeedback($id)
	{
		
		$this->db->select('comment');
        $this->db->from('assignment');
		$this->db->where("assignmentID",$id);
		$query = $this->db->get();
		return $query->result();
	}
	function get_assignment($array=NULL, $signal=FALSE) {
		$query = parent::get($array, $signal);
		return $query;
	}
	
	function get_assignment_answer($assignmentID,$studentID){
	//$query = $this->db->query("select * from assignmentanswer");
    
		$this->db->select('status');
        $this->db->from('assignmentanswer');
		$this->db->where('assignmentID',$assignmentID);
		$this->db->where('uploaderID', $studentID);
		$query = $this->db->get();
	//	print $this->db->last_query();
	//	exit;
		return $query->result();
	}
		
	function get_single_assignment($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}
	
	function get_all_assignment($array=NULL) {
		$query = parent::get_single($array);
		return $query;
	}
	public function get_comments($array=NULL) {
		
		$usertypeID = $this->session->userdata('usertypeID');
        $userID = $this->session->userdata('loginuserID');
        $schoolyearID = $this->session->userdata('defaultschoolyearID');
		$loginusertypeID = $this->session->userdata('usertypeID');
		$this->db->select('*');
        $this->db->from('comment');
		$this->db->where($array);
		$query = $this->db->get();
	//	print $this->db->last_query();
	//	exit;
        return $query->result();
	}
	function get_order_by_assignment($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}
	public function get_order_by_activities($array=NULL) {
		$query = parent::get_order_by($array);
		return $query;
	}
	function insert_assignment($array) {
		$error = parent::insert($array);
		return TRUE;
	}
	public function insert_comments($array) {
        $this->db->insert('comment',$array);
        return TRUE;
    }
	public function update_assignment($data, $id = NULL) {
		parent::update($data, $id);
		return $id;
	}

	public function delete_assignment($id){
		parent::delete($id);
	}
}

/* End of file assignment_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/assignment_m.php */