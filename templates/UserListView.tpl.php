<?php
	$this->assign('title','MICHAT | Users');
	$this->assign('nav','users');

	$this->display('_Header.tpl.php');
?>

<script type="text/javascript">
	$LAB.script("scripts/app/users.js").wait(function(){
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
	<i class="icon-th-list"></i> Users
	<span id=loader class="loader progress progress-striped active"><span class="bar"></span></span>
	<span class='input-append pull-right searchContainer'>
		<input id='filter' type="text" placeholder="Search..." />
		<button class='btn add-on'><i class="icon-search"></i></button>
	</span>
</h1>

	<!-- underscore template for the collection -->
	<script type="text/template" id="userCollectionTemplate">
		<table class="collection table table-bordered table-hover">
		<thead>
			<tr>
				<th id="header_Id">Id<% if (page.orderBy == 'Id') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Username">Username<% if (page.orderBy == 'Username') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Password">Password<% if (page.orderBy == 'Password') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_LastSeen">Last Seen<% if (page.orderBy == 'LastSeen') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_Connected">Connected<% if (page.orderBy == 'Connected') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<th id="header_PublicProfile">Public Profile<% if (page.orderBy == 'PublicProfile') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
				<th id="header_PublicKey">Public Key<% if (page.orderBy == 'PublicKey') { %> <i class='icon-arrow-<%= page.orderDesc ? 'up' : 'down' %>' /><% } %></th>
-->
			</tr>
		</thead>
		<tbody>
		<% items.each(function(item) { %>
			<tr id="<%= _.escape(item.get('id')) %>">
				<td><%= _.escape(item.get('id') || '') %></td>
				<td><%= _.escape(item.get('username') || '') %></td>
				<td><%= _.escape(item.get('password') || '') %></td>
				<td><%if (item.get('lastSeen')) { %><%= _date(app.parseDate(item.get('lastSeen'))).format('MMM D, YYYY h:mm A') %><% } else { %>NULL<% } %></td>
				<td><%= _.escape(item.get('connected') || '') %></td>
<!-- UNCOMMENT TO SHOW ADDITIONAL COLUMNS
				<td><%= _.escape(item.get('publicProfile') || '') %></td>
				<td><%= _.escape(item.get('publicKey') || '') %></td>
-->
			</tr>
		<% }); %>
		</tbody>
		</table>

		<%=  view.getPaginationHtml(page) %>
	</script>

	<!-- underscore template for the model -->
	<script type="text/template" id="userModelTemplate">
		<form class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div id="idInputContainer" class="control-group">
					<label class="control-label" for="id">Id</label>
					<div class="controls inline-inputs">
						<span class="input-xlarge uneditable-input" id="id"><%= _.escape(item.get('id') || '') %></span>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="usernameInputContainer" class="control-group">
					<label class="control-label" for="username">Username</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="username" placeholder="Username" value="<%= _.escape(item.get('username') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="passwordInputContainer" class="control-group">
					<label class="control-label" for="password">Password</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="password" placeholder="Password" value="<%= _.escape(item.get('password') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="lastSeenInputContainer" class="control-group">
					<label class="control-label" for="lastSeen">Last Seen</label>
					<div class="controls inline-inputs">
						<div class="input-append date date-picker" data-date-format="yyyy-mm-dd">
							<input id="lastSeen" type="text" value="<%= _date(app.parseDate(item.get('lastSeen'))).format('YYYY-MM-DD') %>" />
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
						<div class="input-append bootstrap-timepicker-component">
							<input id="lastSeen-time" type="text" class="timepicker-default input-small" value="<%= _date(app.parseDate(item.get('lastSeen'))).format('h:mm A') %>" />
							<span class="add-on"><i class="icon-time"></i></span>
						</div>
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="connectedInputContainer" class="control-group">
					<label class="control-label" for="connected">Connected</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="connected" placeholder="Connected" value="<%= _.escape(item.get('connected') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="publicProfileInputContainer" class="control-group">
					<label class="control-label" for="publicProfile">Public Profile</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="publicProfile" placeholder="Public Profile" value="<%= _.escape(item.get('publicProfile') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
				<div id="publicKeyInputContainer" class="control-group">
					<label class="control-label" for="publicKey">Public Key</label>
					<div class="controls inline-inputs">
						<input type="text" class="input-xlarge" id="publicKey" placeholder="Public Key" value="<%= _.escape(item.get('publicKey') || '') %>">
						<span class="help-inline"></span>
					</div>
				</div>
			</fieldset>
		</form>

		<!-- delete button is is a separate form to prevent enter key from triggering a delete -->
		<form id="deleteUserButtonContainer" class="form-horizontal" onsubmit="return false;">
			<fieldset>
				<div class="control-group">
					<label class="control-label"></label>
					<div class="controls">
						<button id="deleteUserButton" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Delete User</button>
						<span id="confirmDeleteUserContainer" class="hide">
							<button id="cancelDeleteUserButton" class="btn btn-mini">Cancel</button>
							<button id="confirmDeleteUserButton" class="btn btn-mini btn-danger">Confirm</button>
						</span>
					</div>
				</div>
			</fieldset>
		</form>
	</script>

	<!-- modal edit dialog -->
	<div class="modal hide fade" id="userDetailDialog">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">&times;</a>
			<h3>
				<i class="icon-edit"></i> Edit User
				<span id="modelLoader" class="loader progress progress-striped active"><span class="bar"></span></span>
			</h3>
		</div>
		<div class="modal-body">
			<div id="modelAlert"></div>
			<div id="userModelContainer"></div>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal" >Cancel</button>
			<button id="saveUserButton" class="btn btn-primary">Save Changes</button>
		</div>
	</div>

	<div id="collectionAlert"></div>
	
	<div id="userCollectionContainer" class="collectionContainer">
	</div>

	<p id="newButtonContainer" class="buttonContainer">
		<button id="newUserButton" class="btn btn-primary">Add User</button>
	</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>
