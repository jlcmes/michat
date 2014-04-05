<?php
	$this->assign('title','MICHAT | Friendships');
	$this->assign('nav','friendships');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/friendships.js").wait(function(){
		$(document).ready(function(){
			page.init();
		});
		
		// hack for IE9 which may respond inconsistently with document.ready
		setTimeout(function(){
			if (!page.isInitialized) page.init();
		},1000);
	});
</script>

<div class="container">

<h1>
	<i class="icon-th-list"></i> Friendships
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="friendshipCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_SourceUserId">Source User Id<% if (page.orderBy == 'SourceUserId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_TargetUserId">Target User Id<% if (page.orderBy == 'TargetUserId') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Accepted">Accepted<% if (page.orderBy == 'Accepted') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Mutual">Mutual<% if (page.orderBy == 'Mutual') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('sourceUserId') || '') %></td>
				<td><%= _.escape(item.get('targetUserId') || '') %></td>
				<td><%= _.escape(item.get('accepted') || '') %></td>
				<td><%= _.escape(item.get('mutual') || '') %></td>
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="friendshipModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="sourceUserIdInputContainer" class="control-group">
					<label class="control-label" for="sourceUserId">Source User Id</label>
					<div class="controls inline-inputs">
						<select id="sourceUserId" name="sourceUserId"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="targetUserIdInputContainer" class="control-group">
					<label class="control-label" for="targetUserId">Target User Id</label>
					<div class="controls inline-inputs">
						<select id="targetUserId" name="targetUserId"></select>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="acceptedInputContainer" class="control-group">
					<label class="control-label" for="accepted">Accepted</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="accepted" placeholder="Accepted" value="<%= _.escape(item.get('accepted') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="mutualInputContainer" class="control-group">
					<label class="control-label" for="mutual">Mutual</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="mutual" placeholder="Mutual" value="<%= _.escape(item.get('mutual') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteFriendshipButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteFriendshipButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete Friendship</button>
						<span id="confirmDeleteFriendshipContainer" class="hide">
							<button id="cancelDeleteFriendshipButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteFriendshipButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="friendshipDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit Friendship
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="friendshipModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveFriendshipButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="friendshipCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newFriendshipButton" class="btn btn-primary">Add Friendship</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
