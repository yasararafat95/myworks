<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class assignment extends Admin_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	function __construct() {
		parent::__construct();
		$this->load->model("assignment_m");
		$this->load->model("activities_m");
		$this->load->model("activitiesmedia_m");
		$this->load->model("activitiescomment_m");
		$this->load->model("assignmentanswer_m");
		$this->load->model("section_m");
		$this->load->model("subject_m");
		$this->load->model("parents_m");
		$this->load->model("student_m");
		$this->load->model('studentrelation_m');
		$language = $this->session->userdata('lang');
		$this->lang->load('assignment', $language);	
	}

	protected function rules() {
		$rules = array(
			array(
				'field' => 'title', 
				'label' => $this->lang->line("assignment_title"), 
				'rules' => 'trim|required|xss_clean|max_length[128]'
			), 
			array(
				'field' => 'description', 
				'label' => $this->lang->line("assignment_description"),
				'rules' => 'trim|required|xss_clean'
			), 
			array(
				'field' => 'classesID', 
				'label' => $this->lang->line("assignment_classes"),
				'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_classes'
			),
			array(
				'field' => 'deadlinedate', 
				'label' => $this->lang->line("assignment_deadlinedate"),
				'rules' => 'trim|required|xss_clean|max_length[10]|callback_date_valid|callback_pastdate_check'
			),
			array(
				'field' => 'subjectID', 
				'label' => $this->lang->line("assignment_subject"),
				'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_subject'
			),
			array(
				'field' => 'sectionID', 
				'label' => $this->lang->line("assignment_section"),
				'rules' => 'xss_clean|callback_unique_section'
			),
			array(
				'field' => 'file', 
				'label' => $this->lang->line("assignment_file"), 
				'rules' => 'trim|max_length[512]|xss_clean|callback_fileupload'
			)
		);
		return $rules;
	}

	protected function rules_fileupload() {
		$rules = array(
			array(
				'field' => 'file', 
				'label' => $this->lang->line("assignment_file"), 
				'rules' => 'trim|xss_clean|max_length[512]|callback_fileuploadans'
			)
		);
		return $rules;
	}

	public function fileuploadans() {
		$new_file = "";
		$original_file_name = '';
		if($_FILES["file"]['name'] !="") {
			$file_name = $_FILES["file"]['name'];
			$original_file_name = $file_name;
			$random = random19();
	    	$makeRandom = hash('sha512', $random.$this->input->post('title') . config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
			//print_r($explode);
			//exit;
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				print_r($new_file);
				$config['upload_path'] = "./uploads/attach";
				$config['allowed_types'] = "gif|jpg|png|jpeg|pdf|doc|xml|docx|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|txt|ppt|csv|XLS|XLSX|TXT|PPT|CSV";
				$config['file_name'] = $new_file;
				$config['max_size'] = '100024';
			$config['max_width'] = '3000';
			$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				//print_r($this->upload->do_upload("file"));
			//	exit;
				if(!$this->upload->do_upload("file")) {
					print_r($new_file);
					$this->form_validation->set_message("fileupload", $this->upload->display_errors());
					//exit;
	     			return FALSE;
				} else {
					$this->upload_data['file'] =  $this->upload->data();
					$this->upload_data['file']['original_file_name'] = $original_file_name;
					return TRUE;
				}
			} else {
				
				$this->form_validation->set_message("fileupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			$this->form_validation->set_message("fileuploadans", "The %s field is required");
	     	return FALSE;
		}
	}

	public function fileupload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$assignment = [];
		if((int)$id) {
			$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id));	
		}
		
		$new_file = "";
		$original_file_name = '';
		if($_FILES["file"]['name'] !="") {
			$file_name = $_FILES["file"]['name'];
			$original_file_name = $file_name;
			$random = random19();
	    	$makeRandom = hash('sha512', $random.$this->input->post('title') . config_item("encryption_key"));
			$file_name_rename = $makeRandom;
            $explode = explode('.', $file_name);
            if(count($explode) >= 2) {
	            $new_file = $file_name_rename.'.'.end($explode);
				$config['upload_path'] = "./uploads/images";
				$config['allowed_types'] = "gif|jpg|png|jpeg|pdf|doc|xml|docx|GIF|JPG|PNG|JPEG|PDF|DOC|XML|DOCX|xls|xlsx|txt|ppt|csv";
				$config['file_name'] = $new_file;
				$config['max_size'] = '100024';
				$config['max_width'] = '3000';
				$config['max_height'] = '3000';
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload("file")) {
					$this->form_validation->set_message("fileupload", $this->upload->display_errors());
	     			return FALSE;
				} else {
					$this->upload_data['file'] =  $this->upload->data();
					$this->upload_data['file']['original_file_name'] = $original_file_name;
					return TRUE;
				}
			} else {
				$this->form_validation->set_message("fileupload", "Invalid file");
	     		return FALSE;
			}
		} else {
			if(count($assignment)) {
				$this->upload_data['file'] = array('file_name' => $assignment->file);
				$this->upload_data['file']['original_file_name'] = $assignment->originalfile;
				return TRUE;
			} else {
				$this->upload_data['file'] = array('file_name' => $new_file);
				$this->upload_data['file']['original_file_name'] = $original_file_name;
				return TRUE;
			}
		}
	}

	public function index() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/select2/select2.js'
			)
		);
            $usertypeID = $this->session->userdata('usertypeID');
            $userID = $this->session->userdata('loginuserID');
			$loginuserID = $this->session->userdata('loginuserID');
            $loginusertypeID = $this->session->userdata('usertypeID');
		if($this->session->userdata('usertypeID') == 3) {
			$usertypeID = $this->session->userdata('usertypeID');
            $userID = $this->session->userdata('loginuserID');
			$loginuserID = $this->session->userdata('loginuserID');
            $loginusertypeID = $this->session->userdata('usertypeID');
			$id = $this->data['myclass'];
			$mysection = $this->student_m->get_single_student(array('studentID'=>$loginuserID));
		    $usersecid = $mysection->sectionID;
		
		//print_r("secid=". $usersecid);
		} else {
			$id = htmlentities(escapeString($this->uri->segment(3)));	
			
		}
		print_r("usertypeId=".$usertypeID);
		$this->data['classes'] = $this->classes_m->get_classes();
		$fetchClasses = pluck($this->data['classes'], 'classesID', 'classesID');
		if((int)$id) {
			echo "in";
			//print_r($this->session->userdata('loginuserID'));
			if(isset($fetchClasses[$id])) {
				$this->data['set'] = $id;
				$sections = $this->section_m->general_get_order_by_section(array('classesID' => $id));
				$this->data['sections'] = pluck($sections, 'section', 'sectionID');
				$schoolyearID = $this->session->userdata('defaultschoolyearID');
				
				//print_r("usertypeId=".$usertypeID);
				if($this->session->userdata('usertypeID') ==3){
					
				$this->data['assignments'] = $this->assignment_m->join_get_assignment_with_answer($id, $schoolyearID,$usersecid,$this->session->userdata('loginuserID'));
				$this->data['teachers'] = pluck($this->subject_m->get_subject(), 'subject', 'subjectID');				
				$section=$this->data['assignments'];			
				$get_assignment = array();				
				foreach($section as $sec)
				{
				//	print_r($sec);
					//$this->data['assignmentanswers'] = $this->assignmentanswer_m->get_single_assignmentanswer(array('assignmentID' => $sec->assignmentID,'uploaderID'=> $loginuserID));
					//$ans = $this->data["assignmentanswers"];
				//	print_r("<br>".$loginuserID);
					//print_r($ans);
					
					if(!empty($sec->sectionID!='') && $sec->sectionID!='null' )
					{
						
						$strs = json_decode($sec->sectionID);
						/* $strs = str_replace('[','',$sec->sectionID);
						$strs = str_replace(']','',$strs);
						$strs = str_replace('"','',$strs);
						$strs = explode(',',$strs); */
						$i=0;
						
						foreach($strs as $ss)
						{
							if($usersecid == $strs[$i])
							{
								array_push($get_assignment,$sec);
							}
							$i++;
						} 
					}
					
					else{
                        //    $strs = json_decode($sec->classesID);
						/* $strs = str_replace('[','',$sec->sectionID);
						$strs = str_replace(']','',$strs);
						$strs = str_replace('"','',$strs);
						$strs = explode(',',$strs); */
					//	$i=0;
						
//foreach($strs as $ss)
//{
//if($usersecid == $strs[$i])
						//	{
								array_push($get_assignment,$sec);
//}
						//	$i++;
						//}
					}
				}
				$this->data['section_assignment_data']  = $get_assignment;
				$this->data['usection']  = $usersecid;
				
				}
				else if($usertypeID==2)
				{
					$this->data['assignments'] = $this->assignment_m->join_faculty($usertypeID,$userID,$id, $schoolyearID);					
				}
				else if($usertypeID==7)
				{
					$this->data['assignments'] = $this->assignment_m->join_get_assignment($id, $schoolyearID);	
//print_r($this->data['assignments']);					
				}
				else
				{
					
					$this->data['assignments'] = $this->assignment_m->join_get_assignment($id, $schoolyearID);
					//print_r($this->data['assignments']);
				}
				//$this->data['get_comments'] = $this->assignment_m->get_comments_studentfeedback($id);
					
				$this->data["subview"] = "assignment/index";
				$this->load->view('_layout_main', $this->data);
			} else {

				$this->data['set'] = 0;
				$this->data['assignments'] = [];
				$this->data["subview"] = "assignment/index";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data['set'] = 0;
			$this->data['assignments'] = []; 
			$this->data["subview"] = "assignment/index";
			$this->load->view('_layout_main', $this->data);
		}
		
	}
	 
	public function add() {
		if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
			$this->data['headerassets'] = array(
				'css' => array(
					'assets/datepicker/datepicker.css',
					'assets/select2/css/select2.css',
					'assets/select2/css/select2-bootstrap.css'
				),
				'js' => array(
					'assets/datepicker/datepicker.js',
					'assets/select2/select2.js'
				)
			);

			$this->data['classes'] = $this->classes_m->get_classes();
			$classesID = $this->input->post("classesID");
			
			if($classesID != 0) {
				$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
				$this->data['sections'] = $this->section_m->general_get_order_by_section(array("classesID" => $classesID));
			} else {
				$this->data['subjects'] = [];
				$this->data['sections'] = [];
			}

			if($_POST) {
				$rules = $this->rules();
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run() == FALSE) { 
					$this->data["subview"] = "assignment/add";
					$this->load->view('_layout_main', $this->data);			
				} else {
					$array = array(
						"title" => $this->input->post("title"),
						"description" => $this->input->post("description"),
						
						"deadlinedate" => date("Y-m-d", strtotime($this->input->post("deadlinedate"))),
						'subjectID' => $this->input->post('subjectID'),
						"usertypeID" => $this->session->userdata('usertypeID'),
						"userID" => $this->session->userdata('loginuserID'),
						"classesID" => $this->input->post("classesID"),
						"schoolyearID" => $this->session->userdata('defaultschoolyearID'),
						'assignusertypeID' => 0,
						'assignuserID' => 0
					);
					
					$array['originalfile'] = $this->upload_data['file']['original_file_name'];
					$array['file'] = $this->upload_data['file']['file_name'];
					$array['sectionID'] = json_encode($this->input->post('sectionID'));
                    $array["atype"] = $this->input->post("atype"); 
					$this->assignment_m->insert_assignment($array);
					$this->session->set_flashdata('success', $this->lang->line('menu_success'));
					redirect(base_url("assignment/index"));
				}
			} else {
				$this->data["subview"] = "assignment/add";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}

	public function edit() {
		$this->data['headerassets'] = array(
			'css' => array(
				'assets/datepicker/datepicker.css',
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css'
			),
			'js' => array(
				'assets/datepicker/datepicker.js',
				'assets/select2/select2.js'
			)
		);

		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		if((int)$id && (int)$url) {
			if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
				$this->data['classes'] = $this->classes_m->get_classes();

				$fetchClasses = pluck($this->data['classes'], 'classesID', 'classesID');
				if(isset($fetchClasses[$url])) {
					$this->data['assignment'] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
					if($this->data['assignment']) {
						$this->data['sectionID'] = json_decode($this->data['assignment']->sectionID);

						if($this->input->post('classesID')) {
							$classesID = $this->input->post('classesID');
						} else {
							$classesID = $this->data['assignment']->classesID;
						}
						
						$this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
						$this->data['sections'] = $this->section_m->general_get_order_by_section(array("classesID" => $classesID));

						if($_POST) {
							$rules = $this->rules();
							$this->form_validation->set_rules($rules);
							if ($this->form_validation->run() == FALSE) {
								$this->data["subview"] = "assignment/edit";
								$this->load->view('_layout_main', $this->data);			
							} else {
								$array = array(
									"title" => $this->input->post("title"),
									"description" => $this->input->post("description"),
									"deadlinedate" => date("Y-m-d", strtotime($this->input->post("deadlinedate"))),
									'subjectID' => $this->input->post('subjectID'),
									"usertypeID" => $this->session->userdata('usertypeID'),
									"userID" => $this->session->userdata('loginuserID'),
									"classesID" => $this->input->post("classesID"),
									'assignusertypeID' => 0,
									'assignuserID' => 0
								);
								
								$array['originalfile'] = $this->upload_data['file']['original_file_name'];
								$array['file'] = $this->upload_data['file']['file_name'];
                                $array["atype"] = $this->input->post("atype");
								$array['sectionID'] = json_encode($this->input->post('sectionID'));
								$this->assignment_m->update_assignment($array, $id);	
								$this->session->set_flashdata('success', $this->lang->line('menu_success'));
								redirect(base_url("assignment/index/$url"));
							}
						} else {
							$this->data["subview"] = "assignment/edit";
							$this->load->view('_layout_main', $this->data);
						}
					} else {
						$this->data["subview"] = "error";
						$this->load->view('_layout_main', $this->data);
					}
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);	
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}
public function getassignmentstatus($assignid)
{
	$answersubmit = $this->assignmentanswer_m->get_single_assignmentanswer(array('assignmentID' => $assignid,'uploaderID'=> $this->session->userdata('loginuserID')));
	return $answersubmit;
}
	public function delete() {
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		if((int)$id && (int)$url) {
			if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
				$fetchClasses = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
				if(isset($fetchClasses[$url])) {
					$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'classesID' => $url, 'schoolyearID' => $schoolyearID));
					if(count($assignment)) {
						if(config_item('demo') == FALSE) {
							if($assignment->file != '') {
								if(file_exists(FCPATH.'uploads/images/'.$assignment->file)) {
									unlink(FCPATH.'uploads/images/'.$assignment->file);
								}
							}
						}
						$this->assignment_m->delete_assignment($id);
						$this->session->set_flashdata('success', $this->lang->line('menu_success'));
						redirect(base_url("assignment/index/$url"));
					} else {
						redirect(base_url("assignment/index"));	
					}
				} else {
					redirect(base_url("assignment/index"));	
				}
			} else {
				redirect(base_url("assignment/index"));
			}
		} else {
			redirect(base_url("assignment/index"));
		}
	}
	
	public function delete_comment() {
        if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
    		$id = htmlentities(escapeString($this->uri->segment(3)));
            $usertypeID = $this->session->userdata('usertypeID');
            $userID = $this->session->userdata('loginuserID');

            if((int)$id) {
                $comment = $this->assignment_m->get_assignment($id);
                $activities = $this->assignment_m->get_activities($comment->comment);
                if(($usertypeID == $activities->usertypeID && $userID == $activities->userID) || ($usertypeID == 1)) {
                    $this->assignment_m->delete_assignment($id);
                    $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                }
    			redirect(base_url("assignment/comment"));
    		} else {
    			redirect(base_url("assignment/comment"));
    		}
        } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
	}
	
	public function comment() {
        $this->data['headerassets'] = array(
			'css' => array(
				'assets/select2/css/select2.css',
				'assets/select2/css/select2-bootstrap.css',
				'assets/editor/jquery-te-1.4.0.css'
			),
			'js' => array(
				'assets/select2/select2.js',
				'assets/editor/jquery-te-1.4.0.min.js'
			)
		);
        $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
		 $stu = htmlentities(escapeString($this->uri->segment(5)));
        $schoolyearID = $this->session->userdata('defaultschoolyearID');
        $loginuserID = $this->session->userdata('loginuserID');
        $loginusertypeID = $this->session->userdata('usertypeID');
	//	print_r($stu);
		//ticket_raising
		if($_POST){
			//print_r($_POST);
			
			$array = array('schoolyearID'=>$schoolyearID,
			'created_by'=>$loginuserID,
			'created_date'=>date('Y-m-d H:i:s'),
			'comments'=>$_POST['to'],
			'commentid'=>$id,
			'studentID'=>$_POST['ids'],
			'assignmentID' => $id,
			'usertypeID'=>$loginusertypeID);
			
			$this->assignment_m->insert_comments($array);
			$this->session->set_flashdata('success', $this->lang->line('menu_success'));
			redirect(base_url("assignment/comment").'/'.$id.'/'.$url.'/'.$stu);
		}
        if((int)$id && (int)($url)) {
			$this->data['url']=$id;
            if($loginusertypeID == 1) {
                $this->data['ticket_raising'] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
				
          } else {
				
              $this->data['ticket_raising'] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id,  'schoolyearID' => $schoolyearID));
           }
			$this->data['ticket_comments']  = $this->assignment_m->get_comments(array('assignmentID' => $id,'studentID' => $stu, 'schoolyearID' => $schoolyearID));
			//print_r($this->data['ticket_raising']);
			//print_r($this->data['ticket_comments']);
            if(count($this->data['ticket_raising'])) {
                $usertypeID = $this->data['ticket_raising']->usertypeID;
                $userID     = $this->data['ticket_raising']->userID;
                $this->data['createinfo'] = getObjectByUserTypeIDAndUserID($this->data['ticket_raising']->usertypeID, $this->data['ticket_raising']->userID, $schoolyearID);
				
                if($usertypeID > 0 && $userID > 0) {
                    $this->data['usertypes'] = pluck($this->usertype_m->get_usertype(),'usertype','usertypeID');
                    if((int)$usertypeID) {
                        if($usertypeID == 1) {
                            $this->data['user'] = $this->systemadmin_m->get_single_systemadmin(array('systemadminID'=> $userID));
                        }
                    //    elseif($usertypeID == 7) {
                 //           $this->data['user'] = $this->systemadmin_m->get_single_systemadmin(array('systemadminID'=> $userID));
                  //      }						
						elseif($usertypeID == 2) {
                            $this->data['user'] = $this->teacher_m->get_single_teacher(array('teacherID'=> $userID));
                        } elseif($usertypeID == 3) {
                            $this->data['user'] = $this->studentrelation_m->general_get_single_student(array('srstudentID'=> $userID, 'srschoolyearID' => $schoolyearID));
                            $this->data['classes'] = $this->classes_m->general_get_single_classes(array('classesID'=>$this->data['user']->srclassesID));
                            $this->data['section'] = $this->section_m->general_get_single_section(array('sectionID'=>$this->data['user']->srsectionID));
                        } elseif($usertypeID == 4) {
                            $this->data['user'] = $this->parents_m->get_single_parents(array('parentsID'=> $userID));
                        } else {
                            $this->data['user'] = $this->user_m->get_single_user(array('usertypeID' => $usertypeID, 'userID'=> $userID));
                        }
                    } else {
						
                        $this->data['user'] = [];
                        $this->data['classes'] = [];
                        $this->data['section'] = [];
                    }
                } else {
                    $this->data['user'] = [];
                    $this->data['classes'] = [];
                    $this->data['section'] = [];
                }
//print_r("$usertypeID2=".$usertypeID);
	//		exit;
                $this->data["subview"] = "assignment/comment";
                $this->load->view('_layout_main', $this->data);
            } else {
//$this->data["subview"] = "error";
             //   $this->load->view('_layout_main', $this->data);
		//	 print_r("$usertypeID1=".$usertypeID);
		//	exit;
			  $this->data["subview"] = "assignment/comment";
                $this->load->view('_layout_main', $this->data);
            }
        } else {
		//	print_r("$usertypeID=".$usertypeID);
		//	exit;
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
        }
	}
	
	public function view() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$loginuserID = $this->session->userdata('loginuserID');
        $loginusertypeID = $this->session->userdata('usertypeID');
		
		$this->data['asID'] = $id;
		$this->data['clasID'] = $url;
		$this->data['set'] = $id;
		/*if($_POST) {
				
				$array = array(
                        "comment" => $this->input->post("to"),
                    );
				 $this->assignment_m->update_assignment($array, $id);    
				 $this->data['studentfeedback'] = $this->assignment_m->get_order_by_studentfeedback(array('schoolyearID' => $schoolyearID));
        $this->data["subview"] = "assignment/index";
		redirect(base_url("assignment/index"));
		}*/
   
		if((int)$id && (int)($url)) {
			$fetchClasses = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
			//$this->data['students'] = $this->student_m->get_student();
			if(isset($fetchClasses[$url])) {
				$this->data['viewclass'] = $url;
				
				$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'classesID' => $url, 'schoolyearID' => $schoolyearID));
				
				//print_r($assignment);
				//print_r($assignment->assignmentID);
				//$sections = $this->section_m->general_get_order_by_section(array("classesID" => $id));
				//$this->data['get_comments'] = $this->assignment_m->get_comments_studentfeedback($id);
				if(count($assignment)) {
					
				if($loginusertypeID == 3)
				{
					$this->data['assignmentanswers'] = $this->assignmentanswer_m->join_assign($assignment, $schoolyearID,$loginuserID);
				}
				else
				{
					
					
					$this->data['assignmentanswers'] = $this->assignmentanswer_m->join_assign($assignment,$schoolyearID);
					//print_r($this->data['assignmentanswers']);
				}
				//	print_r($this->data['assignmentanswers']);
					//$this->data['students'] = $this->studentrelation_m->get_order_by_student(array('srschoolyearID' => $schoolyearID));
					$this->data['get_comments'] = $this->assignment_m->get_comments_studentfeedback($id);
					
					/* $array = array(
                        "comment" => $this->input->post("to"),
                    ); */
					//$this->assignment_m->insert_assignment($array);
					$this->data["subview"] = "assignment/view";
					$this->load->view('_layout_main', $this->data);
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);
				}
			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);	
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}
	public function videoassignmentanswer() {
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		$usertypeID = $this->session->userdata('usertypeID');
		$userID = $this->session->userdata('loginuserID');
		//print_r($id);
		if($usertypeID == 3) {
			if((int)$id && (int)($url)) {
				$fetchClasses = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
				if(isset($fetchClasses[$url])) {
					if($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) {
						$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
						
						if(count($assignment)) {
							if(strtotime($assignment->deadlinedate) >= strtotime(date('Y-m-d'))) {
								
								
										//$array['answerfileoriginal'] = $this->upload_data['file']['original_file_name'];
										//$array['answerfile'] = $this->upload_data['file']['file_name'];
										$array['assignmentID'] = $id;
										$array['classesID'] = $url;
										$array['schoolyearID'] = $this->data['siteinfos']->school_year;
										$array['uploaderID'] =  $this->session->userdata('loginuserID');
										$array['uploadertypeID'] = $usertypeID;
										$array['answerdate'] = date('Y-m-d');
										$array['status']=1;

										$assignmentanswer = $this->assignmentanswer_m->get_single_assignmentanswer(array('uploaderID' => $userID, 'uploadertypeID' => $usertypeID, 'schoolyearID' => $schoolyearID, 'assignmentID' => $id));
										//print_r($assignmentanswer);
										
										if(count($assignmentanswer)) {
											
											//print_r($assignmentanswer);
											//exit;
											$this->assignmentanswer_m->update_assignmentanswer($array, $assignmentanswer->assignmentanswerID);
											$this->session->set_flashdata('success', $this->lang->line('menu_success'));
											redirect(base_url("assignment/index/$url"));
										} else {
											
											$this->assignmentanswer_m->insert_assignmentanswer($array);	
											$this->session->set_flashdata('success', $this->lang->line('menu_success'));
											redirect(base_url("assignment/index/$url"));
										}
									
								 
							} else {
								$this->session->set_flashdata('error', 'Submition close');
								redirect(base_url("assignment/index"));
							}
						} else {
							$this->data["subview"] = "error";
							$this->load->view('_layout_main', $this->data);
						}
					} else {
						$this->data["subview"] = "error";
						$this->load->view('_layout_main', $this->data);	
					}
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);
				}

			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}
	public function assignmentanswer() {
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		$stuid = htmlentities(escapeString($this->uri->segment(5)));
		$usertypeID = $this->session->userdata('usertypeID');
		$this->data["usertypeID"] = $this->session->userdata('usertypeID');
		$userID = $this->session->userdata('loginuserID');
		
		$this->data["assignment"] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
		$this->data["assignment_ans"] = $this->assignment_m->get_assignment_answer($id,$userID);
		//print_r($id);
		if($usertypeID == 3) {
				
			if((int)$id && (int)($url)) {
				$fetchClasses = pluck($this->classes_m->get_classes(), 'classesID', 'classesID');
				if(isset($fetchClasses[$url])) {
					if($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) {
						$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
						
						if(count($assignment)) {
							if(strtotime($assignment->deadlinedate) >= strtotime(date('Y-m-d'))) {
								if($_POST) {
									
									$rules = $this->rules_fileupload();
									
									$this->form_validation->set_rules($rules);
									//print_r($this->upload_data['file']['original_file_name']);
									if ($this->form_validation->run() == FALSE) { 
									//print_r("error");
									//exit;
										$this->data["subview"] = "assignment/addanswer";
										$this->load->view('_layout_main', $this->data);			
									} else {
										$array['answerfileoriginal'] = $this->upload_data['file']['original_file_name'];
										$array['answerfile'] = $this->upload_data['file']['file_name'];
										$array['assignmentID'] = $id;
										$array['classesID'] = $url;
										$array['schoolyearID'] = $this->data['siteinfos']->school_year;
										$array['uploaderID'] =  $this->session->userdata('loginuserID');
										$array['uploadertypeID'] = $usertypeID;
										$array['answerdate'] = date('Y-m-d');
										$array['status']=1;

										$assignmentanswer = $this->assignmentanswer_m->get_single_assignmentanswer(array('uploaderID' => $userID, 'uploadertypeID' => $usertypeID, 'schoolyearID' => $schoolyearID, 'assignmentID' => $id));
										//print_r($assignmentanswer);
										//exit;
										if(count($assignmentanswer)) {
											
											/* print_r($assignmentanswer);
											exit; */
											$this->assignmentanswer_m->update_assignmentanswer($array, $assignmentanswer->assignmentanswerID);
											$this->session->set_flashdata('success', $this->lang->line('menu_success'));
											redirect(base_url("assignment/index/$url"));
										} else {
											
											$this->assignmentanswer_m->insert_assignmentanswer($array);	
											$this->session->set_flashdata('success', $this->lang->line('menu_success'));
											redirect(base_url("assignment/index/$url"));
										}
									}
								} else {
									$this->data["assignment"] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
									//print_r($this->data["assignment"] );
									
									
									$this->data["subview"] = "assignment/addanswer";
									$this->load->view('_layout_main', $this->data);
								}
							} else {
								$this->session->set_flashdata('error', 'Submition close');
								redirect(base_url("assignment/index"));
							}
						} else {
							$this->data["subview"] = "error";
							$this->load->view('_layout_main', $this->data);
						}
					} else {
						$this->data["subview"] = "error";
						$this->load->view('_layout_main', $this->data);	
					}
				} else {
					$this->data["subview"] = "error";
					$this->load->view('_layout_main', $this->data);
				}

			} else {
				$this->data["subview"] = "error";
				$this->load->view('_layout_main', $this->data);
			}
		} else {
			$this->data["subview"] = "error";
			$this->load->view('_layout_main', $this->data);
		}
	}
	public function answer() {
	
		$schoolyearID = $this->session->userdata('defaultschoolyearID');
		$id = htmlentities(escapeString($this->uri->segment(3)));
		$url = htmlentities(escapeString($this->uri->segment(4)));
		$stuid = htmlentities(escapeString($this->uri->segment(5)));
		$usertypeID = $this->session->userdata('usertypeID');
		$userID = $this->session->userdata('loginuserID');
		//print_r($id);
		$this->data["assignment"] = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
		
		$this->data["assignmentanswer"] = $this->assignmentanswer_m->get_single_assignmentanswer(array('assignmentID' => $id,'uploaderID'=>$stuid));
		$this->data["assignment_ans"] = $this->assignment_m->get_assignment_answer($id,$userID);
		//print_r($this->data["assignmentanswer"] );
		
		$this->data["subview"] = "assignment/answer";
	   $this->load->view('_layout_main', $this->data);
		
		
	}

	public function unique_classes() {
		if($this->input->post('classesID') == 0) {
			$this->form_validation->set_message("unique_classes", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function unique_section() {
		$count = 0;
		$sections = $this->input->post('sectionID');
		$classesID = $this->input->post('classesID');
		if(count($sections) && $sections != FALSE && $classesID) {
			foreach($sections as $sectionkey => $section) {
				$setSection = $section;
				$getDBSection = $this->section_m->general_get_single_section(array('sectionID' => $section, 'classesID' => $classesID));
				if(!count($getDBSection)) {
					$count++;
				}
			}

			if($count == 0) {
				return TRUE;
			} else {
				$this->form_validation->set_message("unique_section", "The %s is not match in class");
	     		return FALSE;
			}
		}
		return TRUE;
	}

	public function date_valid($date) {
		if(strlen($date) <10) {
			$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");
	     	return FALSE;
		} else {
	   		$arr = explode("-", $date);   
	        $dd = $arr[0];            
	        $mm = $arr[1];              
	        $yyyy = $arr[2];
	      	if(checkdate($mm, $dd, $yyyy)) {
	      		return TRUE;
	      	} else {
	      		$this->form_validation->set_message("date_valid", "%s is not valid dd-mm-yyyy");
	     		return FALSE;
	      	}
	    } 
	} 

	public function pastdate_check() {
		$date = strtotime($this->input->post("deadlinedate"));
		$now_date = strtotime(date("d-m-Y"));
		if($date) {
			if($date < $now_date) {
				$this->form_validation->set_message("pastdate_check", "The %s field is past date");
		     	return FALSE;
			}
			return TRUE;
		}
		return TRUE;
	}

	public function unique_subject() {
		if($this->input->post('subjectID') == 0) {
			$this->form_validation->set_message("unique_subject", "The %s field is required");
	     	return FALSE;
		}
		return TRUE;
	}

	public function subjectcall() {
		$classID = $this->input->post('id');
		if((int)$classID) {
			$allclasses = $this->subject_m->general_get_order_by_subject(array('classesID' => $classID));
			echo "<option value='0'>", $this->lang->line("assignment_select_subject"),"</option>";
			foreach ($allclasses as $value) {
				echo "<option value=\"$value->subjectID\">",$value->subject,"</option>";
			}
		} 
	}

	public function sectioncall() {
		$classID = $this->input->post('id');
		if((int)$classID) {
			$allsection = $this->section_m->general_get_order_by_section(array("classesID" => $classID));
			foreach ($allsection as $value) {
				echo "<option value=\"$value->sectionID\">",$value->section,"</option>";
			}
		}
	}

	public function student_list() {
		$classID = $this->input->post('id');
		if((int)$classID) {
			$string = base_url("assignment/index/$classID");
			echo $string;
		} else {
			redirect(base_url("assignment/index"));
		}
	}

	public function download() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$assignment = $this->assignment_m->get_single_assignment(array('assignmentID' => $id, 'schoolyearID' => $schoolyearID));
			if(count($assignment)) {
				$file = realpath('uploads/images/'.$assignment->file);
				$originalname = $assignment->originalfile;
			    if (file_exists($file)) {
			    	header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.basename($originalname).'"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($file));
				    readfile($file);
				    exit;
			    } else {
			    	redirect(base_url('assignment/index'));
			    }
			} else {
				redirect(base_url('assignment/index'));
			}
		} else {
			redirect(base_url('assignment/index'));
		}
	}

	public function answerdownload() {
		$id = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$id) {
			$schoolyearID = $this->session->userdata('defaultschoolyearID');
			$assignmentanswer = $this->assignmentanswer_m->get_single_assignmentanswer(array('assignmentanswerID' => $id, 'schoolyearID' => $schoolyearID));
			if(count($assignmentanswer)) {
				$file = realpath('uploads/images/'.$assignmentanswer->answerfile);
				$originalname = $assignmentanswer->answerfileoriginal;
			    if (file_exists($file)) {
			    	header('Content-Description: File Transfer');
				    header('Content-Type: application/octet-stream');
				    header('Content-Disposition: attachment; filename="'.basename($originalname).'"');
				    header('Expires: 0');
				    header('Cache-Control: must-revalidate');
				    header('Pragma: public');
				    header('Content-Length: ' . filesize($file));
				    readfile($file);
				    exit;
			    } else {
			    	redirect(base_url('assignment/index'));
			    }
			} else {
				redirect(base_url('assignment/index'));
			}
		} else {
			redirect(base_url('assignment/index'));
		}
	}
}
