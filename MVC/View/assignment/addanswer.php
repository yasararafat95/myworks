<style>
	.hyper{
		cursor:pointer; 
	}
	
	.container {
    padding-right: 15px;
    padding-left: 15px;
    margin-right: 0px;
    margin-left: 0px;
	}
	
	 .submitVideo{
		position:absolute;
		top: 59px;
		right: 25px;
	} 
	
	#menu1{
		margin:0px !important;
	}
	.btn.btn-success{
		background-color:#00acac;
		border-color:#00acac;
	}
	
.iframeQuit{
	display: block; width: 100%; height: 1068px; 
}
 
 @media only screen and (max-width: 1414px) {

	.iframeQuit{
		display: block; width: 80%; height: 1068px; 
	}

}

 @media only screen and (max-width: 1020px) {

	.iframeQuit{
		display: block; width: 75%; height: 1068px; 
	}
	 
}
 @media only screen and (max-width: 992px) {

.iframeQuit{
	display: block; width: 100%; height: 1068px; 
}

 
}
</style>

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><i class="fa icon-assignment"></i> <?=$this->lang->line('panel_title')?> - <span><?=$assignment->title?></span></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            <li><a href="<?=base_url("assignment/index")?>"></i> <?=$this->lang->line('menu_assignment')?></a></li>
            <li class="active">
            	<?php 
            		if($this->session->userdata('usertypeID') != 3) { 
	            		echo $this->lang->line('menu_add').' '; 
	            		echo $this->lang->line('menu_assignment');
	            	} else {
	            		echo $this->lang->line('menu_assignment').' ';
	            		echo $this->lang->line('assignment_ans'); 
	            	}
            	?>
            	
            </li>
        </ol>
    </div><!-- /.box-header -->
    <!-- form start -->
    <div class="box-body">
        <div class="row">
        	<?php $usertypeID = $this->session->userdata('usertypeID'); ?>
			<?php $status = $assignment_ans;
	
			foreach($status as $s=> $r)
			{
				$row=$r->status;
				 // if($r->status==4)
				// print_r($r->description);	
			}  
			?>
	
            <?php if($usertypeID == 3 ) { ?>
				
				<ul class="nav nav-tabs" role="tablist" style="padding-left: 5px;">
					<?php $this->data['loginuserID'] = $this->session->userdata('loginuserID');?>
					<li class="nav-item active">
						<a class="nav-link" data-toggle="tab"  href="#home">Upload File</a>
												
					</li>
					<li class="nav-item hyper">
					<a class="nav-link switch" data-toggle="tab" data-url="https://demo.eaceprep.com/acfmvideo/wp-login.php?studentID=<?php echo $this->data['loginuserID'];?>&asmntId=<?php echo htmlentities(escapeString($this->uri->segment(3)));?>&usertype=<?php echo $usertypeID?>&status=<?php if(empty($row)){ echo "0";}else{echo $row;}?>"href="#menu1">Upload Video</a>
					</li>

				</ul>
			
			
			 
	<div class="tab-content">
		<div id="home" class="col-sm-10 tab-pane container active" style="margin-top:30px;">
			<form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" >
				
				
				<div class="form-group <?php if(form_error('file')) { echo 'has-error'; } ?>" >
					<label for="file" class="col-sm-2 control-label">
						<?=$this->lang->line("assignment_file")?><span class="text-red">*</span>
					</label>
					<div class="col-sm-6">
						<div class="input-group image-preview">
							<input type="text" class="form-control image-preview-filename" disabled="disabled">
							<span class="input-group-btn">
								<button type="button" class="btn btn-default image-preview-clear" style="display:none;">
									<span class="fa fa-remove"></span>
									<?=$this->lang->line('assignment_clear')?>
								</button>
								<div class="btn btn-success image-preview-input">
									<span class="fa fa-repeat"></span>
									<span class="image-preview-input-title">
									<?=$this->lang->line('assignment_file_browse')?></span>
									<input type="file" accept="image/png, image/jpeg, image/gif, application/pdf, application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint, text/plain, application/pdf" name="file"/>
								</div>
							</span>
						</div>
					</div>

					<span class="col-sm-4 control-label">
						<?php echo form_error('file'); ?>
					</span>
				</div>
				<input type="hidden" class="form-control" id="teacherID" name="teacherID" value="1">
				
				 
				 
				 
			 
				 

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-8">
						<input type="submit" class="btn btn-success" value="<?=$this->lang->line("add_assignment_ans")?>" name="submit" >
					</div>
				</div>
			</form>
		</div>
			<?php }
		?>

		<div id="menu1" class="tab-pane container fade">

			<div  class="iframeN" style="margin-top:30px;">
				<iframe class="demoeaceprep iframeQuit" frameborder="0" allowfullscreen="allowfullscreen" src="" style="border: none; z-index: 101; top: 0px; left: 0px;">
				</iframe>
			</div>
			<div class="submitVideo">
				<button type="button" class="btn btn-success" onclick='location.href="https://demo.eaceprep.com/insmgmt/assignment/videoassignmentanswer/<?php echo htmlentities(escapeString($this->uri->segment(3))); ?>/<?php echo htmlentities(escapeString($this->uri->segment(4))); ?>"'>Click Here To Submit</button>
			</div>
		</div>
	
		
	</div>
	</div>
</div>

<script>


$(document).on('click', '.switch', function(){
	var dataurl = $(this).attr('data-url');
	$('.iframeN').find('iframe:eq(0)').attr('src',dataurl);
	
});

$(document).on('click', '#close-preview', function(){ 
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
        function () {
           $('.image-preview').popover('show');
           $('.content').css('padding-bottom', '100px');
        }, 
         function () {
           $('.image-preview').popover('hide');
           $('.content').css('padding-bottom', '20px');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no image",
        placement:'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function(){
        $('.image-preview').attr("data-content","").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("<?=$this->lang->line('assignment_file_browse')?>"); 
    }); 
    // Create the preview image
    $(".image-preview-input input:file").change(function (){     
        var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200,
            overflow:'hidden'
        });      
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("<?=$this->lang->line('assignment_file_browse')?>");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
        }        
        reader.readAsDataURL(file);
    });  
});


</script>