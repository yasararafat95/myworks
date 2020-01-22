
<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-assignment"></i> <?=$this->lang->line('panel_title')?></h3>
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("assignment/index/".$viewclass)?>"></i> <?=$this->lang->line('menu_assignment')?></a></li>
            <li class="active">
            	<?=$this->lang->line('menu_assignment').' '.$this->lang->line('assignment_ans_list')?>
            </li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
        	<div class="col-lg-12">
				<div id="hide-table">
	                <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">
	                    <thead>
	                        <tr>
	                            <th><?=$this->lang->line('slno')?></th>	                           
	                            <th><?=$this->lang->line('assignment_student')?></th>
	                            <th><?=$this->lang->line('assignment_roll')?></th>
	                            <th><?=$this->lang->line('assignment_section')?></th>
	                            <th><?=$this->lang->line('assignment_submission')?></th>
								<th><?=$this->lang->line('assignment_status')?></th>
								
	                            <th><?=$this->lang->line('action')?></th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php if(count($assignmentanswers)) {
								$i = 1; 
								//print_r($assignmentanswers);
								foreach($assignmentanswers as $assignmentanswer) {
									if($assignmentanswer->username !=""){
							?>
	                            <tr>
	                                <td data-title="<?=$this->lang->line('slno')?>">
	                                    <?=$i?>
	                                </td>
	                                
	                                <td data-title="<?=$this->lang->line('assignment_student')?>">
	                                    <?=$assignmentanswer->name?>
	                                </td>
	                                <td data-title="<?=$this->lang->line('assignment_roll')?>">
	                                    <?=$assignmentanswer->username?>
	                                </td>
	                                <td data-title="<?=$this->lang->line('assignment_section')?>">
	                                    <?=$assignmentanswer->srsection?>
	                                </td>
	                                <td data-title="<?=$this->lang->line('assignment_submission')?>">
									<?php
									/* $datee=date('d M Y', strtotime($assignmentanswer->answerdate));
									echo "ag" .$datee;
									print_r($datee); */
									if($assignmentanswer->answerdate==null){
										/* print_r(); */
										echo '-';
										}
									else{
										$datee=date('d M Y', strtotime($assignmentanswer->answerdate));
									echo "" .$datee;
									
									
									}?>
	                                </td>
									<td data-title="<?=$this->lang->line('assignment_submission')?>">
	                                    <?php  if($assignmentanswer->assignmentanswerID !="" ) { ?>
												<button type="button" class="btn btn-warning btn-xs"><?=$this->lang->line('submitted')?></button>
											<?php } elseif($assignmentanswer->assignmentanswerID == "") { ?>
												<button type="button" class="btn btn-success btn-xs"><?=$this->lang->line('pending')?></button>
											<?php } else { ?>
												<button type="button" class="btn btn-danger btn-xs"><?=$this->lang->line('leaveapply_declined')?></button>
											<?php } ?>
	                                </td>
									
	                                <td data-title="<?=$this->lang->line('action')?>">
									  <?php  if($assignmentanswer->assignmentanswerID !="" ) { 
	                                    echo btn_download('assignment/answer'."/".$asID."/".$clasID."/".$assignmentanswer->studentID, $this->lang->line('download'));
									  }else
									  {
										 echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
									  }?>
										<a href="<?=base_url('assignment/comment')."/".$asID."/".$clasID."/".$assignmentanswer->studentID?>"><button type="button" class="btn btn-success btn-xs"><?=$this->lang->line('comment')?></button></a>
	                                </td>
	                            </tr>
	                        <?php $i++; }
							}
							} ?>
	                    </tbody>
	                </table>
	            </div>
        	</div>
        </div>
    </div>
	<form class="form-horizontal" role="form" action="<?=base_url('assignment/view')."/".$asID."/".$clasID;?>" method="post">
			 <div class="col-sm-12 no-padding">
                <div class="box box-primary">
						<?php
						if($this->session->userdata('loginuserID')==1 || $this->session->userdata('usertypeID')==13 || $this->session->userdata('usertypeID')==7){
						?>
						
							<?php
							}
							else 
							{
								
							?>
							<div class="box-body box-profile" style="height: 50px;">
								<div class="single_box">
									<div class="col-sm-1 no-padding" style="font-weight: bold;">
										<?=$this->lang->line("to").' :';?>
									</div>
									<div class="col-sm-11 no-padding">
										<?php echo $get_comments[0]->comment; ?>
									</div> 
								</div>
							</div>
							<?php
							}
							?>
                </div>
            </div>
	</form>
</div>
