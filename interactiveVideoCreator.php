
<?php
/**
Template Name:Video List
*/

//get_header();
global $wpdb;
global $current_user;
get_currentuserinfo();
$user_roles = $current_user->roles;
$role = $current_user->roles;
$user_id = get_current_user_id();
$user_role = array_shift($user_roles);

if ($current_user->ID == '') { 
    //show nothing to user 
  //  echo "You must login to access this page.";
  //wp_redirect( wp_login_url() );
 
 // site_url().'/login'
 //echo  site_url().'/admin';
 header("Location: https://eaceprep.com/gpvideo/admin"); 
?> 
<script>window.location.href="https://eaceprep.com/gpvideo/admin";</script>



<?php 
}
else { 
    //write code to show menu here
    //echo $current_user->ID;
    //echo $user_role;
?>
<head>
	<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script> 
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	
</head>
<script>
	
	window.onload = function(){
		jQuery('.tab_video').click(function(){
			jQuery('.editinteractivitytab').hide();
			jQuery('.addinteractivitytab').show();
			jQuery('.tab-2').trigger('click');
		});
		jQuery('.t2C').hide();
		jQuery('.t3C').hide();
		jQuery('.t4C').hide();
		jQuery('.t5C').hide();
		jQuery('.t3').hide();
		

	}


jQuery(document).on('click','.editinteractivitytab',function(){
	setInterval(function(){
			jQuery('iframe:eq(2)').contents().find('.wrap').find('.postbox:eq(0)').find('#major-publishing-actions').find('.submitdelete').click(function(){
			  location.reload();
			});
			},2000);
});


jQuery(document).on('click','.refresh',function(){
	location.reload();
});

jQuery(document).on('click','.admin',function(){
    jQuery("#logreports").load('<?php echo site_url()?>/videolist/table');
});

jQuery(document).on('click','.stretched-link',function(){
	jQuery('.addinteractivitytab').hide();
	jQuery('.editinteractivitytab').show();
	var dataurl = jQuery(this).attr('data-url');
	jQuery('.editinteractivity').find('iframe:eq(0)').attr('src',dataurl);
	//jQuery('.editinteractivitytab').show();
	jQuery('.editinteractivitytab').trigger('click');
	jQuery('.editinteractivity iframe').contents().find('.h5p-action-bar-settings').parent().hide();
	
});

jQuery(document).on('click','.result-link',function(){
	jQuery('.t3').show();
	jQuery('.t1C').hide();
	jQuery('.t4C').hide();
	jQuery('.t3C').show();
	var result_url = jQuery(this).attr('result-url');
	jQuery('.t3C').find('iframe:eq(0)').attr('src',result_url);
	jQuery('.marginForTab li').removeClass('active');
	jQuery('.t3').addClass('active');
	setInterval(function(){
	jQuery('iframe:eq(3)').contents().find('#wpwrap').find('.wrap').find('h2').find('a').hide();
	jQuery('iframe:eq(3)').contents().find('body').css({'background':'#fff'});
	jQuery('iframe:eq(3)').contents().find('html.wp-toolbar').css({'padding':'0px'});
	jQuery('iframe:eq(3)').contents().find('#wpwrap').find('#wpcontent').css({'margin-left':'0px'});},1000);

});


jQuery(document).on('click','.stretched-linkN',function(){
	var link = jQuery(this).attr('data-link');
	var creator = jQuery(this).attr('displayname');
	jQuery('.target-url').find('iframe:eq(0)').attr('src',link);
	jQuery('.creator').text(creator);
	
});

jQuery(document).on('click','.removeSrc',function(){
	jQuery('.target-url').find('iframe:eq(0)').attr('src',' ');
	jQuery('.creator').text('');	
});

jQuery(document).on('click','.admin, .addinteractivitytab, .editinteractivitytab',function(){
	jQuery('.search').hide();
	
});

jQuery(document).on('click','.video',function(){
	jQuery('.search').show();
	
});

jQuery(document).on('click','.t1',function(){
	jQuery('.t2C').hide();
	jQuery('.t3C').hide();
	jQuery('.t4C').hide();
	jQuery('.t1C').show();
	jQuery('.t5C').hide();
	
});


jQuery(document).on('click','.t3',function(){
	jQuery('.t1C').hide();
	jQuery('.t2C').hide();
	jQuery('.t4C').hide();
	jQuery('.t3C').show();
	jQuery('.t5C').hide();
});

jQuery(document).on('click','.t4',function(){
	jQuery('.t1C').hide();
	jQuery('.t2C').hide();
	jQuery('.t3C').hide();
	jQuery('.t4C').show();
	jQuery('.t5C').hide();
});

jQuery(document).on('click','.t5',function(){
	jQuery('.t1C').hide();
	jQuery('.t2C').hide();
	jQuery('.t3C').hide();
	jQuery('.t4C').hide();
	jQuery('.t5C').show();
});

function resizeIframe(obj) {
   obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}


</script>



<script>

$(document).on('click','.admin',function(){
  $.ajax({
    url: "<?php echo site_url(); ?>/videolist/graph",
    method: "GET",
    success: function(data) {
	  var datas = JSON.parse(data);
      console.log(datas);
      var users = [];
      var noOfVds = [];
      for(var i=0; i<datas.length; i++) {
        users.push(datas[i].display_name);
        noOfVds.push(datas[i].countof);
      }
      var chartdata = {
        labels: users,
        datasets : [
          {
            label: 'Videos',
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            hoverBackgroundColor: 'rgba(54, 162, 235, 0.9)',
            hoverBorderColor: 'rgba(54, 162, 235, 1)',
            data: noOfVds
          }
        ]
      };
	  
	  var ctx = document.getElementById('myChart').getContext('2d');

      var barGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata,
		options: {
		responsive: true,
		scales: {
		yAxes: [{
			ticks: {
				
				min: 0,
				stepSize: 1
			},
			scaleLabel: {
			display: true,
			labelString: 'No.  Of   videos'
		  }
		}],
		xAxes: [{
			barPercentage: 0.8,
		}]
	}
	}
		
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
});

</script>


<div class="wrap">
 
  <div id="h5p-contents">
    <div class="nw-video-ttl">
    	
	<?php 

		$customers = $wpdb->get_results("SELECT id,title,parameters FROM wp_h5p_contents where user_id='".$current_user->ID."'");
	
		$customersN = $wpdb->get_results("SELECT id,title,parameters FROM wp_h5p_contents where user_id!='".$current_user->ID."'");
		
		$a_users = $wpdb->get_results("SELECT wp_fa_user_logins.user_id, wp_fa_user_logins.login_status, wp_users.display_name from wp_fa_user_logins RIGHT JOIN wp_users ON wp_fa_user_logins.user_id=wp_users.ID where login_status='login' and user_id!='".$current_user->ID."' GROUP BY wp_fa_user_logins.user_id");
		
		$tot_users = $wpdb->get_results("select u.id,u.display_name,(select max(time_last_seen) as lastseen from wp_fa_user_logins where user_id = u.id) as last_seen,(select count(id) from wp_h5p_contents where user_id = u.id) as video_count from wp_users u");
		
	?>

	<div class="log-bar">
		<div class="col-xs-10 col-md-10 col-sm-10">	<h2>INTERACTIVE VIDEO CREATOR </h2></div>
		<div class="col-xs-2 col-md-2 col-sm-2 userLogo">
			<div class="wrapper-demo">
			<div id="dd" class="wrapper-dropdown-5" tabindex="1">
			<span class="glyphicon glyphicon-user ctrusr"></span> 
			<div class="ctrn-user">
					<?php if ( is_user_logged_in() ) { 
					 echo  $current_user->display_name; } 
					else { wp_loginout(); } ?>
			</div>
			<ul class="dropdown">
			<li><a href="<?php echo wp_logout_url(); ?>"><span class="glyphicon glyphicon-off"></span> Log out</a></li>
			</ul>
			</div>
			</div> 
		</div>      
	</div>
	<nav class="navbar navbar-inverse">
		<div class="tb-bg">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			</button>
			<div class="collapse navbar-collapse" id="myNavbar">
				<ul class="nav navbar-nav tabs">
					<li class="tab-link nav-item current video refresh" data-tab="tab-1">Video List</li>
					<li class="tab-link nav-item tab-2 addinteractivitytab" data-tab="tab-2">Add Interactivity</li>
					<li class="tab-link nav-item tab-3 editinteractivitytab" style="display:none;" data-tab="tab-3">Add Interactivity</li>
					<li class="tab-link nav-item admin" data-tab="tab-4">Admin portal
					</li>
					
					<div class="search">
						 <i class="glyphicon glyphicon-search sIcon"></i>
						<input type="text" id="myInput"  placeholder="Search" title="Type in a name">
					</div>
				</ul>
				
			</div>
			
		</div>
	</nav>
	<div id="tab-1" class="tab-content current">
		<div class="myVideos">
			<span class="glyphicon glyphicon-facetime-video vdicn"></span>  <p class="h3">MY VIDEOS</p>
		</div>
		<div class="row1 flt-lft">
			
			<div class="col-sm-3 col-md-2 comn tab_video">
				<a href="#">
					<div class="upload-bx-tl">
						<label class="upload-bx">
						
						<span class="glyphicon glyphicon-plus"></span>
						</label>
						<p>Upload Video</p>
						
					</div>
				</a>
			</div>
			<div id="searchName">
				   <?php

				   foreach($customers as $customer){
							
						 $strjson = json_decode($customer->parameters, true);
				   ?>
				 
					 <div class="col-sm-3 col-md-2 comn">
						 <div class="video-bx">
								<p class="searchRoot"><a class="stretched-link" data-url="<?php echo site_url();?>/wp-admin/admin.php?page=h5p_new&id=<?php echo $customer->id;?>">
								
								<?php 
								if(strpos($strjson['interactiveVideo']['video']['files'][0]['path'],"https://youtu")!== false)
								{
									
									$web=$strjson['interactiveVideo']['video']['files'][0]['path'];	
									$web1=explode("/",$web);
								
								?>  
									<img style="max-width:100%" class="img-thumbnail" src="https://img.youtube.com/vi/<?php echo $web1[3]; ?>/mqdefault.jpg" type="jpg">
									
								<?php 
								}
								else if(strpos($strjson['interactiveVideo']['video']['files'][0]['path'],"videos/files-")!== false)
								{
								?>
									<video class="img-thumbnail" playsinline="playsinline" muted loop>
									<source src="<?php echo site_url();?>/wp-content/uploads/h5p/content/<?php echo $customer->id;?>/<?php echo $strjson['interactiveVideo']['video']['files'][0]['path'];?>#t=2">
									</video>
								<?php 
								} 
								else if(strpos($strjson['interactiveVideo']['video']['files'][0]['path'],"https://www.youtube.com")!== false)
								{		
									$web=$strjson['interactiveVideo']['video']['files'][0]['path'];	
									$web1=explode("=",$web);							
								?>  
									<img style="max-width:100%" class="img-thumbnail" src="https://img.youtube.com/vi/<?php echo $web1[1]; ?>/mqdefault.jpg" type="jpg">
									
								<?php 
								}
								else
								{
								?>
								<img style="max-width:100%" class="img-thumbnail" src="<?php echo site_url();?>/wp-content/themes/twentynineteen/images/nopreview.jpg" type="jpg">
								<?php
								}
								?>
								
								<span class="title">					
								<?php echo $customer->title; ?>
								</span>
								<div class="round_editbt">
								<button class="bts-profile" type="submit"><span><i class="fa fa-pencil"></i></span>
								</button>
								</div>
								</a> </p>
							
						 </div>
					</div>
				<?php }?>
			</div>
		</div>
		
		<div class="otherVideos">
			<span class="glyphicon glyphicon-facetime-video vdicn"></span> <p class="h3">OTHER VIDEOS</p>
		</div>
		<div class="row2">
			<div id="searchName">
				   <?php
				   foreach($customersN as $customerN){
							
						 $strjsonN = json_decode($customerN->parameters, true);
				   ?>
					
					 <div class="col-sm-3 col-md-2 comn">
						 <div class="video-bx">
								<?php
								$query = 'select u.display_name from wp_users u left join wp_h5p_contents c on (u.id = c.user_id) where c.id ='.$customerN->id.'';
								$createdname = $wpdb->get_results($query);
								$createdname = reset($createdname)->display_name;
							
								if($role[0]=='administrator' || $role[0]=='gpadmin')
								{
								?>
								<p class="searchRoot"><a class="stretched-link" data-url="<?php echo site_url();?>/wp-admin/admin.php?page=h5p_new&id=<?php echo $customerN->id;?>">
								<?php
								}
								else{
									
								?>
								<p class="searchRoot"><a class="stretched-linkN" data-link="<?php echo admin_url();?>/admin-ajax.php?action=h5p_embed&id=<?php echo $customerN->id;?>" data-toggle="modal" href="#myModal" data-backdrop="static" data-keyboard="false" displayname="<?php echo $createdname;?>">
								<?php 
								}
								?>
								<?php 
								if(strpos($strjsonN['interactiveVideo']['video']['files'][0]['path'],"https://youtu")!== false)
								{
									
									$webN=$strjsonN['interactiveVideo']['video']['files'][0]['path'];	
									$web1N=explode("/",$webN);
								
								?>
									<img style="max-width:100%" class="img-thumbnail" src="https://img.youtube.com/vi/<?php echo $web1N[3]; ?>/mqdefault.jpg" type="jpg">
								<?php 
								}
								else if(strpos($strjsonN['interactiveVideo']['video']['files'][0]['path'],"videos/files-")!== false)
								{
								?>
									<video class="img-thumbnail" playsinline="playsinline" muted loop>
									<source src="<?php echo site_url();?>/wp-content/uploads/h5p/content/<?php echo $customerN->id;?>/<?php echo $strjsonN['interactiveVideo']['video']['files'][0]['path'];?>#t=2">
									</video>
								<?php 
								}
								else if(strpos($strjsonN['interactiveVideo']['video']['files'][0]['path'],"https://www.youtube.com")!== false)
								{	
									$webN=$strjsonN['interactiveVideo']['video']['files'][0]['path'];	
									$web1N=explode("=",$webN);									
								?>
									<img style="max-width:100%" class="img-thumbnail" src="https://img.youtube.com/vi/<?php echo $web1N[1]; ?>/mqdefault.jpg" type="jpg">
									
								<?php 
								}
								else
								{
								?>
								<img style="max-width:100%" class="img-thumbnail" src="<?php echo site_url();?>/wp-content/themes/twentynineteen/images/nopreview.jpg" type="jpg">
								<?php
								}
								?>
								<span  class="title">					
								<?php echo $customerN->title; ?>
								</span>
								<?php
								if($role[0]=='administrator' || $role[0]=='gpadmin')
								{
								?>
								<div class="round_editbt">
									<button class="bts-profile" type="submit"><span><i class="fa fa-pencil"></i></span>
									</button>
								</div>
								<?php
								}
								?>
								
								</a></p>
						 </div>
						 
					</div>
					
				<?php }?>
				
				<div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close removeSrc" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body target-url">
							 <iframe class="toGiveHW" src="" frameborder="0" scrolling="no" onload="resizeIframe(this)" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
							<div class="modal-footer">
							  <p><span>Created By :<span><span class="creator"></span> </p>
							</div>
						  </div>
						  
						</div>
				</div>
			</div>
		</div>

	</div>
	<div id="tab-2" class="tab-content noPadding addinteractivity">
		<iframe class="h5p-editor-iframe" frameborder="0" allowfullscreen="allowfullscreen" src="<?php echo admin_url();?>/admin.php?page=h5p_new" style="display: block; width: 100%; height: 1024px; border: none; z-index: 101; top: 0px; left: 0px;"></iframe>
	</div>
	<div id="tab-3" class="tab-content noPadding editinteractivity">
		<iframe class="h5p-editor-iframe" frameborder="0" allowfullscreen="allowfullscreen" src="" style="display: block; width: 100%; height: 1140px; border: none; z-index: 101; top: 0px; left: 0px;"></iframe>
	</div>
	<div id="tab-4" class="tab-content">
		<div class="logAndReport">
			<ul class="nav nav-tabs marginForTab" role="tablist">
			  <li class="active t1">
				  <a href="#logreports" role="tab" data-toggle="tab">
					  <i class="fa fa-table"></i> Log Reports
				  </a>
			  </li>
			  <li class="t3">
				  <a href="#results" role="tab" data-toggle="tab">
					  <i class="fa fa-tasks"></i> Results
				  </a>
			  </li>
			  <?php
				/* if($role[0]=='administrator' || $role[0]=='gpadmin')
					{
				?>
			  <li class="t2">
				<a href="#danlysis" role="tab" data-toggle="tab">
				  <i class="fa fa-bar-chart"></i> Detailed Analysis
				</a>
			  </li> 
			  <?php
					}*/
			  ?>
			  <?php
				 if($role[0]=='administrator' || $role[0]=='gpadmin')
					{
			  ?>
			  <li class="t4">
				  <a href="#graph" role="tab" data-toggle="tab">
					  <i class="fa fa-bar-chart"></i> Graph
				  </a>
			  </li>
			  <li class="t5">
				  <a href="#userreports" role="tab" data-toggle="tab">
					  <i class="fa fa-user"></i> User Reports
				  </a>
			  </li>
			  <?php
					}
			  ?>
			  
			  
			</ul>
			<div class="tab-content1">
				<div class="tab-pane t1C" id="logreports">
					
					
				</div>
				<!--<div class="tab-pane fade t2C" id="danlysis">
					<iframe class="h5p-editor-iframe" frameborder="0" allowfullscreen="allowfullscreen" src="<?php echo site_url();?>/xapi/sentlink.php" style="display: block; width: 100%; height: 1400px; border: none; z-index: 101; top: 0px; left: 0px;"></iframe>
				</div>-->
				<div class="tab-pane t3C" id="results">
					<iframe class="h5p-editor-iframe" frameborder="0" allowfullscreen="allowfullscreen" src="" style="display: block; width: 100%; height: 400px; border: none; z-index: 101; top: 0px; left: 0px;"></iframe>
				</div>
				<div class="tab-pane t4C col-sm-12" id="graph">
					<div class="col-sm-6">
						<div class="chartSize">
							<canvas id="myChart" width="0" height="10px"></canvas>
						</div>
					</div>
					<div class="ausers col-sm-6">
						<h3>Active Users</h3>
						<?php
						if(!empty($a_users)){
							foreach($a_users as $acuser){
						?>
						<p class="anames"><i class="fa fa-circle online" aria-hidden="true"></i><?php echo $acuser->display_name; ?></p>
						<?php
						}
						}
						else{						
						?>
						<p class="noactive">No active users</p>
						<?php
						}
						?>
					</div>
				</div>
				<div class="tab-pane t5C" id="userreports">
					<div class="userTable">
						<table class="table table-responsive table-bordered table-hover table-striped" style="width:100%">
						
							<thead>
								<tr>
									<th>User</th>									
									<th>Time Last Seen</th>
									<th>Videos Count</th>
							</thead>
							<tbody>
								<?php
								foreach($tot_users as $tuser){
								?>
								<tr>
									<td><?php echo $tuser->display_name; ?></td>
									<td><?php echo $tuser->last_seen; ?></td>
									<td><?php echo $tuser->video_count ?></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>			
	</div>
		
	</div>

    	   	   	
    </div>
  </div>
</div>
<?php } ?>



<style>
	/*body{color: #9e9d9e;	}*/
	.table-bordered > thead > tr > th {border-bottom-width: 1px;}
	table.dataTable.no-footer {    border-bottom: 0px solid #111;}
	#example_filter label input{color: #767679;font-weight: 500;border-radius: 4px;border-color: #aaa8aa;padding: 3px 10px;margin-bottom: 10px;}
	iframe html body #wpwrap #wpcontent #wpbody #wpbody-content .update-nag{display:none !important;}
	
	.flt-lft{float:left;width: 100%;}
	.log-bar{width:100%; float: left;background-color:#00639e}
	.log-bar h2{font-size: 1.6em;    padding: 41px 29px;margin: 0px; text-align: left; color: #fff;}
	.ics{font-size: 14px;left: 3px;top: -2px !important;}
	.vdicn{float: left;margin-right: 10px;color: #fff;}
	
	.tb-bg{background: #0993d7;float:left; width:100%; float:left;}
	.nw-video-ttl{width:100%;float:left;padding: 0px; margin: 0px auto;background-color: #fff; border: 0px solid #ccc;}
	.upload-bx-tl{width:100%;float:left;text-align: center;min-height:210px; }
	.upload-bx-tl p{font-size: 1.3em;padding-top: 5px; color: #9e9d9e;text-transform: capitalize;}
	.upload-bx{width: 100%;height: auto;cursor: pointer;float: left;text-align: center;padding: 24% 0;border: 2px dotted #d7d7d7;}
	.upload-bx p{text-align:center;}
	
	.video-bx{width:100%;float:left;text-align: left;position: relative;min-height: 210px;}
	.video-bx p{font-size: 1.3em; color: #9e9d9e;text-transform: capitalize;}
		.video-bx p a{color: #9e9d9e;}
		.video-bx p a:hover{color: #7b7b79;}
	.video-bx iframe{height: 142px;    width: 100%;    float: left;}
	
	/* Graph */
	
	.chartSize{
		width:550px;
		height:440px;
	}
	
	.anames{
		text-transform:capitalize;
	}
	.online{
		color:#46ce57;
		margin-right:10px;
	}
	
	.container{
			width: 100%;
			margin: 0 auto;
		}
		
		.navbar-inverse{
			background-color:unset;
			border:unset;
		}
		
		.searchRoot:hover{
			cursor:pointer;
		}
		
		
		.navbar-inverse .navbar-toggle:focus, .navbar-inverse .navbar-toggle:hover {
			background:none;
		}
		.navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form {
			border:unset;
		}
		
		.navbar{
			margin-bottom:0px !important;
			border-radius:unset;
		}
		
		.navbar-inverse .navbar-toggle {
			border-color: #fff;
		}
		
       .video-bx .searchRoot a img {
		   width: 100%;
		   }


		video{
			max-width:100%;
		}
		
		.noPadding{
			padding:0px !important;
		}
		ul.tabs{
			padding: 0px;
			list-style: none;
			background: #0993d7;
			padding-top: 5px;float:left; margin-left: 16px;margin-bottom: 0px;
		}
		ul.tabs li{
			background: none;
			color: #fff;
			display: inline-block;
			padding: 10px 15px;
			cursor: pointer;
			font-size: 1.4em;
			margin-bottom:2px;
		}
	ul.tabs li:hover{background-color: rgba(255, 255, 255, 0.1);    border-radius: 0px;	}

		ul.tabs li.current{
			background: #0993d7;
			color: #fff;
			border-bottom: 5px solid #aac04d;
		}

		.tab-content{
			display: none;
			background: #ededed;
			padding: 40px 15px; float: left; width:100%;
		}

		.tab-content.current{display: inherit; width:100%;background-color: #fff;overflow:hidden;}
		
		.dataTables_scroll
		{
			position:relative;
			overflow:auto;
		}
		
		#dataT>thead>tr>th:last-child>select{
			display:none;
		}
		
	/* DEMO 5 */
	.wrapper-demo{margin: 18px 0 0 0;}
	.ctrusr{width: 100%; color: #fff; padding-top: 4px;    text-align: center;    font-size: 2em;}
	.ctrn-user{ text-align: center;    padding: 4px 0 12px 0;color: #fff;}
.wrapper-dropdown-5 {
    /* Size & position */
	float: right;
    position: relative;
    width: 120px;
    margin: 0 auto;
/*       padding: 19px 0px 5px;*/
	padding: 0px;
    z-index: 99999;
    /* Styles */
  /*  background: #fff;
    border-radius: 5px;
    box-shadow: 0 1px 0 rgba(0,0,0,0.2);*/
    cursor: pointer;
    outline: none;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
}

.wrapper-dropdown-5:after { /* Little arrow */
  /*  content: "";*/
    width: 0;
    height: 0;
    position: absolute;
    top: 50%;
    right: 15px;
    margin-top: -3px;
    border-width: 6px 6px 0 6px;
    border-style: solid;
    border-color: #4cbeff transparent;
}

.wrapper-dropdown-5 .dropdown {
    /* Size & position */
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;padding: 0px;margin: 0px;

    /* Styles */
    background: #fff;
    border-radius: 0 0 5px 5px;
    border: 1px solid rgba(0,0,0,0.2);
    border-top: none;
    border-bottom: none;
    list-style: none;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;

    /* Hiding */
    max-height: 0;
    overflow: hidden;
}

.wrapper-dropdown-5 .dropdown li {
    padding: 0 20px ;
}

.wrapper-dropdown-5 .dropdown li a {
    display: block;
    text-decoration: none;
    color: #333;
    padding: 10px 0;
    transition: all 0.3s ease-out;
    border-bottom: 1px solid #e6e8ea;
}

.wrapper-dropdown-5 .dropdown li:last-of-type a {
    border: none;
}

.wrapper-dropdown-5 .dropdown li i {
    margin-right: 5px;
    color: inherit;
    vertical-align: middle;
}

/* Hover state */

.wrapper-dropdown-5 .dropdown li:hover a {
    color: #57a9d9;
}

/* Active state */

.wrapper-dropdown-5.active {
    border-radius: 5px 5px 0 0;
    background: #0a93d7;
    box-shadow: none;
    border-bottom: none;
    color: white;
}

.wrapper-dropdown-5.active:after {
    border-color: #82d1ff transparent;
}

.wrapper-dropdown-5.active .dropdown {
    border-bottom: 1px solid rgba(0,0,0,0.2);
    max-height: 400px;
}

.ctrn-user{
	text-transform: capitalize;
}

.stretched-link{
	cursor:pointer;
}

.myVideos{float: left;width: 100%;background-color: #767679;padding: 8px 10px;margin-bottom: 20px;border-radius: 2px;}
	.myVideos p{ padding: 0px; margin: 0px;color: #fff;font-size: 15px;	font-weight: normal;}
.otherVideos{float: left;width: 100%;background-color: #767679;padding: 8px 10px;margin-bottom: 20px;border-radius: 2px;}
	.otherVideos p{padding: 0px; margin: 0px;color: #fff;font-size: 15px;font-weight: normal;}

.search{
	position:absolute !important;
	right:0px;
}

#myInput{
	float: right;
	padding: 5px 5px;
	margin: 8px;
	border: 1px solid #fff;
	border-radius: 5px;
	font-size:14px;
}

.sIcon{
	float:right;
	right:34px;
	top:18px;
	color:#0993d7;
	font-size:16px;
}

.fa-pencil:before {
	color:#000;
}

.h5p-interactive-video .h5p-control:focus {
    outline: unset;
}


/*roundbox*/
.round_editbt {
position: absolute;
top: 7px;
right: 7px;
background-color: rgba(255,255,255,0.8);
color: #000;
border-radius: 100px;
padding: 6px 0px 0px 2px;
-webkit-box-shadow: 1px 1px 7px 0 rgba(0,0,0,.35);
-moz-box-shadow: 1px 1px 7px 0 rgba(0,0,0,.35);
box-shadow: 1px 1px 7px 0 rgba(0,0,0,.35);
cursor: pointer;
height: 27px;
width: 27px;
}	
	.bts-profile {
    border: 0;
    background: transparent;
    outline: none!important;
    cursor: pointer;
}
	

.dataTables_filter>label>input{
	border:1px solid #75787B;
	border-radius:5px;
	padding:3px 2px;
}

.dataTables_length>label>select{
	border:1px solid #75787B;
}

.dataTables_length select{
	border-radius:5px;
	padding:3px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button{
	background:#0993d7;
	color:white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
	background:#00629e;
	color:white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover{
	background:#00629e;
	color:white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover{
	background:#00629e;
	color:white !important;
}

.dataTables_paginate.paging_simple_numbers{
	margin-top:10px;
}

.marginForTab{
	margin-bottom:25px;
}


#dataT{
	margin-top:15px;
}

table thead tr th select{
	width:100%;
	border-radius:5px;
	padding:5px;
	margin: 5px 0;
	border: 1px solid #dbdbdb;
	background-color: #f5f5f5;
}


table.dataTable {
	border-collapse: collapse;
}

table tbody tr td{
	text-transform:capitalize;
}

.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
	
    background-color: #fff;
    border: 1px solid #0061A0;
	border-bottom-color: transparent;
}

.nav-tabs>li>a:hover {
		background-color:#F2F2F2;
}

.nav-tabs {
    border-bottom: 1px solid #0061A0;
}

.comn{
	position:relative;
}

.icon-bar{
	color:white !important;
}


.result-link{
	cursor:pointer;
}

#myModal{
	position:fixed;
	top:15%;
}

.toGiveHW{
	width: 100%;
}

.modal-body{
	padding:0px;
}

.modal-footer{
	padding:10px;
}

@media(max-width: 500px) {
	.log-bar h2 {
		font-size: 1.2em;
		padding: 41px 0px;
	}
	
	ul.tabs li {
		font-size:1.2em;
	}
	
	.wrapper-dropdown-5 {
		width: 108px;
	}
	
	.comn{
	padding:0px;
	}
	
	
	
	.userLogo{
		padding-right:6px;
	}
	#dataT{
		font-size:14px;
	}
}

@media(max-width: 600px) {
	.chartSize{
		width:95%;
	}
}


@media(max-width: 766px) {
	ul.tabs{
		display:grid;
	}
	ul.tabs li.current {
    border:unset !important;
	}
	
	#myInput{
		width:90%;
	}
	
	.sIcon{
		display: none;
	}
	.search{
		width:90%;
		position:relative !important;
		right:unset;
		margin: 0px 0px 10px 3px;
	}
}


@media(max-width: 379px) {
	
	.log-bar h2 {
		font-size: 1em;
	}
	
}


@media only screen and (max-width: 900px) {
.upload-bx-tl p {   font-size: 1.4em;}
.video-bx p { font-size: 1.4em;}
.video-bx p .searchRoot a span{font-size: 2.5em;}
.otherVideos{    margin-top: 15px;}
.video-bx{    margin-bottom: 15px;}
}

/* No CSS3 support: none */
span.creator {
    text-transform: capitalize;
    font-weight: bold;
    margin: 0 5px;
}
</style>
  
  
  
   
  
 
<script>

$(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})
</script>
		<script type="text/javascript">

			function DropDown(el) {
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						event.stopPropagation();
					});	
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-5').removeClass('active');
				});

			});

		</script>			
<script>

jQuery('#myInput').on('keyup',function()
{
    var value = $(this).val().toUpperCase();
    var $rows = $(".searchRoot").parent().parent();
    
    if(value === ''){
        $rows.show(100);
        return false;
    }
    $rows.each(function(index) {
        if (index !== -1) {
            $row = $(this);
            $row1 = $(this).find('span');
			console.log($.trim($row1.html().toUpperCase()));
            var column1 = $.trim($row1.html().toUpperCase());
            if ((column1.indexOf(value) > -1)) {
                $row.show(100);
            }
            else {
                $row.hide(100);
            }
        }
    });
});


</script>		
			

		