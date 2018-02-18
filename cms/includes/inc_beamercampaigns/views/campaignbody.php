<?php
$campaign_body_content = '';

$campaign_body_content = <<<HTML
<script type="text/html" id="section-item-dd-tmpl">
<option value=""> -- Select -- </option>
<% if(ddItems.length > 0) { %>
<% _.each( ddItems, function( item ){ %>
	<option value="<%= item.ind %>"><%= item.label %></option>
<% }) %>
<% } %>
</script>
<script type="text/html" id="section-body-item-tmpl">
<div class="section-body-item" data-item-ind="<%= itemInd %>">
	<div class="section-item-img">
		<span class="item-img" style="background-image: url('{$htmlroot}<%= thumbPhoto %>');"></span>
	</div> 
	<div class="section-item-content">
		<h3 class="item-title"><%= label %></h3>

		<% if(type == 'accommodations'){ %>
			<% if(rate) { %>
			<p class="summary-item bold">From $<%= rate %></p>
			<% } %>
			<% if(sqm) { %>
			<p class="summary-item item-inline"><span class="bold">Area:</span><%= sqm %></p>
			<% } %>
            <% if(beds) { %>
			<p class="summary-item item-inline"><span class="bold">Beds:</span><%= beds %></p>
			<% } %>
			<% if(pax) { %>
			<p class="summary-item item-inline"><span class="bold">Max Guests:</span><%= pax %></p>
			<% } %>
		<% }%>
		
		<% if(typeof rating != 'undefined') {  
				flooredRating = Math.floor(rating); 
				ratingDiff = (rating - flooredRating);
		%>
			<p class="item-price">From $<%= rate%> <%= ((rate != 'POA') ? 'per person, twin share' : '') %></p>
			<p class="star-rating" title="<%= rating %> stars">
                <% for( var t = 1; t <= flooredRating; t++ ) { %>
                <i class="fa fa-star"></i>
                <% } %>
                <% if( ratingDiff == 0.5 ) { %>
                <i class="fa fa-star-half-full"></i>
                <% } %>
            </p>
	    <% } %>
	    		<% if(typeof introduction != 'undefined') { %>
				<p class="item-intro"><%= introduction %></p>
		<% } %>
		<% if (typeof details != 'undefined') { %>
	    		<p class="item-description"><%= ((details != null && details.length > 250) ?  details.substr(0,250) + ' ...' : details )%></p>
	    <% } %>
		<input type="text" name="item-rank[<%= itemInd %>]" value="<%= itemRank %>" class="sm item-rank" style="width:70px;">
		<input type="hidden" name="item-type[<%= itemInd %>]" value="<%= type %>" class="sm item-type">
		<a href="" class="remove-body-item" title="Remove" data-item-ind="<%= itemInd %>"><i class="fa fa-times"></i></a>
	</div> 
</div>		
</script>

<script type="text/html" id="campaign-section-tmpl">
	<div class="section-item item collapsed" data-section-ind="<%= ind %>" id="section-item-<%= ind %>">
		<div class="head">
			<div class="btn-group item-actions">
				<button type="button" class="btn btn-default toggle" title="Expand"><i class="fa fa-plus-square"></i> <span>Show</span></button>
				<button type="button" class="btn btn-default save-item" title="Save changes"><i class="fa fa-save"></i> Save</button>
				<button type="button" class="btn btn-default remove-item" title="Remove"><i class="fa fa-times"></i> Remove</button>
			</div>
			<p class="title" title="<%= heading %>"><%= heading %></p>
		</div>
		<div class="body upper">
			<label>
				<span>Section Type:</span> 
				<select class="section-type-dd" name="section-type">
					<option>-- Select --</option>
					<% _.each( sectionType, function( type, key ){ %>
						<option value="<%= key %>" data-label="<%= type %>" <%= (key == sectionKey)? 'selected' : '' %>><%= type %></option>
					<% }) %>	
				</select>
			</label>
			<label>
				<span>Heading:</span> 
				<input type="text" name="section-heading" value="<%= heading %>" class="md section-heading">
			</label>
			<label>
				<span>Rank:</span>
				<input type="text" name="section-rank" value="<%= rank %>" class="sm" style="width:70px;">
			</label>				
		</div>
		<div class="body lower">
			<label>
				<span>Section Item:</span> 
				<select class="md section-item-dd" name="section-item" id="section-item-dd-<%= ind %>">
					<option value=""> -- Select -- </option>
					<% if(ddItems.length > 0) { %>
					<% _.each( ddItems, function( item ){ %>
						<option value="<%= item.ind %>"><%= item.label %></option>
					<% }) %>
					<% } %>					
				</select>
			</label>
			<label>
				<span>Rank:</span>
				<input type="text" name="section-item-rank" value="" class="sm section-item-rank" style="width:70px;">
			</label>
			<label>
				<button type="button" class="btn btn-warning add-section-item"><i class="fa fa-plus-circle"></i> Add Item</button>
			</label>				
		</div>
		<div class="body body-items">
			
		</div>
	</div>
</script>
HTML;

$campaign_body_content .= <<<HTML
	<div style="margin-bottom:25px;">
	<button type="button" id="add-campaign-section" class="btn btn-primary" data-token="{$id}"><i class="fa fa-plus-circle"></i> Add Section</button>
	<button type="button" id="campaign-preview" class="btn btn-info" data-token="{$id}"><i class="fa fa-eye"></i> Preview</button>
	<button type="button" id="campaign-send" class="btn btn-success" data-token="{$id}" style="float:right;"><i class="fa fa-envelope"></i> Publish</button>
	</div>
	<p class="action-msg"></p>
	<div id="campaign-body" data-token="{$id}" class="campaign-body-wrapper item-container"></div>
HTML;

$styles_ext  .= '<link href="/'.$admin_dir.'/css/beamer/beamer.css" rel="stylesheet">';
$scripts_ext .= '<script src="'.$htmladmin.'/js/beamer/beamer.js"></script>';
?>