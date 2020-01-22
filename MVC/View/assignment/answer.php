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
	
	.noFile{
	font-size: 14px;
	margin-left: 5px;
	}
	
	#menu1{
		margin:0px !important;
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
			
			
				<ul class="nav nav-tabs" role="tablist" style="padding-left: 5px;">
					<?php $this->data['loginuserID'] = $this->session->userdata('loginuserID');?>
					<li class="nav-item active">
						<a class="nav-link" data-toggle="tab"  href="#home">Uploaded File</a>
												
					</li>
					<li class="nav-item hyper">
						<a class="nav-link switch" data-toggle="tab" data-url="https://demo.eaceprep.com/acfmvideo/wp-login.php?studentID=<?php echo htmlentities(escapeString($this->uri->segment(5)));?>&asmntId=<?php echo htmlentities(escapeString($this->uri->segment(3)));?>&usertype=<?php echo $usertypeID?>&status=<?php if(empty($row)){ echo "0";}else{echo $row;}?>" href="#menu1">Uploaded Video</a>
					</li>

				</ul>
			
			
			 <div class="tab-content" style="margin-bottom:40px;">
				<?php if(!empty($assignmentanswer->answerfile)){
				?>
				<div id="home" class="col-sm-10 tab-pane container active" style="padding:30px;">
					<a href="<?=base_url('uploads/attach/'.$assignmentanswer->answerfile)?>" target="_blank" ><button type="button" class="btn btn-success">Click here to view uploaded file</button></a>
			
				</div>
				<?php
				}
				else
				{
				?>
				<div id="home" class="col-sm-10 tab-pane container active" style="padding:30px;">
					<p class="noFile">No file uploaded<p>
				</div>
				<?php
				}
				?>
				
				<div id="menu1" class="tab-pane fade" style="padding: 0 13px">
					<div  class="iframeN" style="margin-top:30px;">
						<iframe class="demoeaceprep iframeQuit" frameborder="0" allowfullscreen="allowfullscreen" src="" style="border: none; z-index: 101; top: 0px; left: 0px;">
						</iframe>
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