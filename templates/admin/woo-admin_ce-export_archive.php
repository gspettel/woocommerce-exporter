<ul class="subsubsub">
	<li><a href="<?php echo add_query_arg( 'filter', '' ); ?>"><?php _e( 'All', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'products' ); ?>"><?php _e( 'Products', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'categories' ); ?>"><?php _e( 'Categories', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'tags' ); ?>"><?php _e( 'Tags', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'orders' ); ?>"><?php _e( 'Orders', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'customers' ); ?>"><?php _e( 'Customers', 'woo_ce' ); ?></a> |</li>
	<li><a href="<?php echo add_query_arg( 'filter', 'coupons' ); ?>"><?php _e( 'Coupons', 'woo_ce' ); ?></a></li>
</ul>
<br class="clear" />
<form action="" method="GET">
	<table class="widefat fixed media" cellspacing="0">
		<thead>

			<tr>
				<th scope="col" id="icon" class="manage-column column-icon"></th>
				<th scope="col" id="title" class="manage-column column-title"><?php _e( 'Filename', 'woo_ce' ); ?></th>
				<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'woo_ce' ); ?></th>
				<th scope="col" class="manage-column column-author"><?php _e( 'Author', 'woo_ce' ); ?></th>
				<th scope="col" id="title" class="manage-column column-title"><?php _e( 'Date', 'woo_ce' ); ?></th>
			</tr>

		</thead>
		<tfoot>

			<tr>
				<th scope="col" class="manage-column column-icon"></th>
				<th scope="col" class="manage-column column-title"><?php _e( 'Filename', 'woo_ce' ); ?></th>
				<th scope="col" class="manage-column column-type"><?php _e( 'Type', 'woo_ce' ); ?></th>
				<th scope="col" class="manage-column column-author"><?php _e( 'Author', 'woo_ce' ); ?></th>
				<th scope="col" class="manage-column column-title"><?php _e( 'Date', 'woo_ce' ); ?></th>
			</tr>

		</tfoot>
		<tbody id="the-list">

<?php if( $files ) { ?>
	<?php foreach( $files as $file ) { ?>
			<tr id="post-<?php echo $file->ID; ?>" class="author-self status-<?php echo $file->post_status; ?>" valign="top">
				<td class="column-icon media-icon">
					<?php echo $file->media_icon; ?>
				</td>
				<td class="title column-title">
					<a href="<?php echo $file->guid; ?>"><strong><?php echo $file->post_title; ?></strong></a>
					<p><?php echo $file->post_mime_type; ?></p>
					<div class="row-actions">
						<!-- ... -->
					</div>
				</td>
				<td class="title column-title">
					<a href="<?php echo add_query_arg( 'filter', $file->export_type ); ?>"><?php echo $file->export_type_label; ?></a>
				</td>
				<td class="author column-author"><?php echo $file->post_author_name; ?></td>
				<td class="date column-date"><?php echo $file->post_date; ?></td>
			</tr>
	<?php } ?>
<?php } else { ?>
			<tr id="post-<?php echo $file->ID; ?>" class="author-self" valign="top">
				<td colspan="3" class="colspanchange"><?php _e( 'No past exports found.', 'woo_ce' ); ?></td>
			</tr>
<?php } ?>

		</tbody>
	</table>
</form>