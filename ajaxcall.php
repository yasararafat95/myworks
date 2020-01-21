<?php 
/*
Template Name:table
*/
//get_header();
global $wpdb;
global $current_user;
get_currentuserinfo();
$user_roles = $current_user->roles;
$role = $current_user->roles;
$user_id = get_current_user_id();
$user_role = array_shift($user_roles);	

$tableList = $wpdb->get_results("SELECT wp_h5p_contents.id,wp_h5p_contents.title,wp_users.display_name,wp_h5p_contents.updated_at,wp_h5p_contents.created_at FROM wp_h5p_contents INNER JOIN wp_users ON wp_h5p_contents.user_id=wp_users.ID where user_id='".$current_user->ID."'");

$tableListAdmin = $wpdb->get_results("SELECT wp_h5p_contents.id,wp_h5p_contents.title,wp_users.display_name,wp_h5p_contents.updated_at,wp_h5p_contents.created_at FROM wp_h5p_contents INNER JOIN wp_users ON wp_h5p_contents.user_id=wp_users.ID");

?>

<div class="logTable">
	<table id="dataT" class="table table-responsive table-bordered display" style="width:100%">
	
		<thead class="forap">
			<tr>
				<th>Title</th>
				<?php
					if($role[0]=='administrator' || $role[0]=='gpadmin')
					{
				?>
				<th>User</th>
				<?php
					}
				?>
				<th>Last Modified</th>
				<th>Created Date</th>
				<th>Results</th>
			</tr>
		</thead>
		<tbody>
		<?php
			if($role[0]=='administrator' || $role[0]=='gpadmin')
			{
				$tableListCom= $tableListAdmin;
			}
			else
			{
				$tableListCom=$tableList;
			}					
			foreach($tableListCom as $list){
		?>
			<tr>
				<td><?php echo $list->title ?></td>
				<?php
				if($role[0]=='administrator' || $role[0]=='gpadmin')
				{
				?>
				<td><?php echo $list->display_name ?></td>
				<?php
					}
				?>
				<td><?php echo $list->updated_at ?></td>
				<td><?php echo $list->created_at ?></td>
				<td><a class="result-link" result-url="<?php echo site_url();?>/wp-admin/admin.php?page=h5p&task=results&id=<?php echo $list->id;?>">Result</a></td>
			</tr>
		<?php
			}
		?>
			
		</tbody>
		<?php
			if($role[0]=='administrator' || $role[0]=='gpadmin')
				{
		?>
		<tfoot>
			<tr>
				<th>By Title</th>
				<th>By User</th>
				<th>Last Modified</th>
				<th>Created Date</th>
				<th>Result</th>
			</tr>
		</tfoot>
		<?php
			}
		?>
	</table>
</div>

<script>
	$(document).ready(function() {
	$('#dataT').DataTable( {
	  "sScrollx": '100%',
	  
		initComplete: function () {
			this.api().columns().every( function () {
				var column = this;
				var select = $('<select><option value=""></option></select>')
					.appendTo( $(column.footer()).empty() )
					.on( 'change', function () {
						var val = $.fn.dataTable.util.escapeRegex(
							$(this).val()
						);

						column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
					} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		}
	} );
	} );

	$(document).ready(function() {
	jQuery('.dataTable').wrap('<div class="dataTables_scroll" />');
	jQuery('#dataT').find('tfoot tr').appendTo('.forap');
	var d = 0;
	jQuery('#dataT').find('thead tr:eq(0)').find('th').each(function(){
		jQuery('#dataT').find('thead tr:eq(1)').find('th').eq(d).find('select option:eq(0)').html('Select '+jQuery(this).text());
		d++;
	});
	} );

</script>