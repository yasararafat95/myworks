<style>

.container1{
	
	border-bottom: 1px solid #ddd;
    width: 98%;
    margin-bottom: 15px;
}
</style>

 


<div class="row col-lg-6 col-md-6 col-sm-12 col-xs-12" style="margin:0">
			
			  <div style="padding:0;" class="<?php if(count($user)) { echo 'col-lg-12 col-md-12 col-sm-12 col-xs-12'; } else { echo 'col-sm-9'; } ?>">
					<div class="box box-primary box-height" style="float:left;">
						
						<div class="hyperlink linkDesign">
						
						<br>


				<div class="overflowDown" style="margin-top:10px;margin-left:20px;">	 
					
					<h4 class="increaseFont" style="margin-left:10px;margin-bottom:20px;">Notes Summary</h4>	
					 
					 
					 
					<div id="about" class="box-body box-profile" style="padding:0px;min-height: 150px; max-height: 350px;overflow: hidden;">
						<?php 
						if($ticket_comments){
							$i=1;
							foreach($ticket_comments as $ticket_comment)
							{
								$loginuserID = $this->session->userdata('loginuserID');
								$loginusertypeID = $this->session->userdata('usertypeID');
								if($ticket_comment->usertypeID == $loginusertypeID && $ticket_comment->created_by == $loginuserID){
									$name = $this->session->userdata('name');
								}else{
									if($ticket_comment->usertypeID == 3){
										$name= $this->student_m->get_single_student_name(array('studentID'=>$ticket_comment->created_by));
									}
									else if($ticket_comment->usertypeID == 2){
										$name= $this->teacher_m->get_single_teacher_name(array('teacherID'=>$ticket_comment->created_by));
									}
									else{
										$name= $this->user_m->get_single_user(array('userID'=>$ticket_comment->created_by));
									}
									$name= $name->name;
								}
								echo '
								<div class="container1 col-sm-12">
									<h5 class="time-right-name">Note: '.$i.' Added By: '.$name.':On: '.$ticket_comment->created_date.' </h5>
									<p>'.$ticket_comment->comments.'</p>
								</div>';
							$i=$i+1;	
							}
						}
						?>
				 
								</div>
							</div>
							
							</div>
				   </div>	
				</div>	
			</div>		
							
							<?php
	$link = $_SERVER['PHP_SELF'];
	$link_array = explode('/',$link);
	$ids = end($link_array);
	 $id = htmlentities(escapeString($this->uri->segment(3)));
        $url = htmlentities(escapeString($this->uri->segment(4)));
	//	 $stu = htmlentities(escapeString($this->uri->segment(5)));
	?>
							
							<form class="form-horizontal col-lg-6 col-md-6 col-sm-12 col-xs-12" role="form" action="<?=base_url('assignment/comment');?>/<?php echo $id;?>/<?php echo $url;?>/<?php echo $ids;?>" method="post" style="float:left;padding:0;">
			 <div class="col-lg-12">
                <div class="box box-primary" style="float:left;">
						<div class="box-body box-profile" style="">
							<div class="single_box ">
								<label for="to" class="col-sm-12 col-xs-12 increaseFont control-label">
									<?=$this->lang->line("add_notes")?>
								</label>
								<div class="col-sm-12 col-xs-12" style="margin:25px 0px">
									<textarea class="form-control" id="comments" name="to" style="height:40px;"></textarea>
									<input type="hidden" name="ids" value="<?php echo $ids;?>">
								</div> 
							</div>
							<button type="submit" class="btn btn-default" style="margin-bottom:0px;height:40px;margin-left: 20px;" data-dismiss="modal">Submit</button>
						</div>
                </div>
            </div>
	</form>
	
	

	<script type="text/javascript">
	$(document).ready(function() {
		 $('#comments').jqte();
		 
		 
		 
		  $('#about').slimscroll({
		
		height: '350px'
        
  
  
  
	});
	
	
	});
</script>