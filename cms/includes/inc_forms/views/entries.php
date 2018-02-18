<?php

$entries_content = '';

$form_entries = fetch_all("SELECT `id`, `full_name`, `email_address`,
	DATE_FORMAT(`date_added`, '%d %b %Y %h:%i %p') AS added_date
	FROM `form_entry`
	WHERE `form_id` = '{$id}'
	ORDER BY `date_added` DESC");


if( !empty($form_entries) )
{

	foreach ($form_entries as $form_entry)
	{

		$entries_content .= '<tr>
            <td width="60">#'.str_pad($form_entry['id'], 5, '0', STR_PAD_LEFT).'</td>
            <td width="250"><a href="#" data-index="'.$form_entry['id'].'" class="show-entry-modal">'.$form_entry['full_name'].'</a></td>
            <td width="200">'.mail_to($form_entry['email_address']).'</td>
            <td width="150">'.$form_entry['added_date'].'</td>
        </tr>';
	}


	$entries_content = '
	<div style="margin-bottom:20px;"><a href="'.$htmladmin.'?do='.$do.'&action=export&id='.$id.'" class="btn btn-primary" style="color:#fff;font-size:14px;"><i class="fa fa-download"></i> Export Entries</a></div>
	<table width="100%" class="bordered tbl-padded">
        <thead>
            <tr>
                <th width="60">Entry ID</th>
                <th width="250">Name</th>
                <th width="200">Email Address</th>
                <th width="150">Entry Date</th>
            </tr>
        </thead>
        <tbody>'.$entries_content.'</tbody>
    </table>';

    $entries_content .= <<< _TMPL
		
	<script id="modal-tmpl" type="text/html">
		<div class="modal fade" id="entry-modal" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4>Entry Details</h4>
					</div>
					<div class="modal-body">
						<% if( fields.length > 0 ) { %>
						<table width="100%" border="0" cellspacing="0" cellpadding="8">
							<tbody>
								<% _.each(fields, function(field){ %>
								<tr>
									<td valign="top" width="130"><strong><%= field.label %></strong></td>
									<td valign="top"><%= field.value %></td>
								</tr>
								<% }) %>
							</tbody>
						</table>
						<% } %>
					</div>
				</div>
			</div>
		</div>
	</script>

_TMPL;


    $entries_content .= <<< JS
	
	<script>
		
		$(document).on('click', '.show-entry-modal', function(e){
			e.preventDefault();

			var self = $(this),
				ind  = self.data('index'),
				modalSelector = '#entry-modal',
				_modalTmpl = _.template( $('#modal-tmpl').html() );

			if( ind && _modalTmpl ) {
				
				$.post('{$htmladmin}/ajax/service.php', 'action=fetch-form-entry-data&ind='+ind, function( fields ){
					var compiledModalTmpl = _modalTmpl({fields: fields});
					
					$('body').append(compiledModalTmpl);

					$(modalSelector).on('hidden.bs.modal', function(){
						$(modalSelector).remove();
					}).modal({backdrop: 'static', show: true});

				}, 'json');

			}
			
		});

	</script>

JS;

}

?>