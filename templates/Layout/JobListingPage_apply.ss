<h1>Position Application</h1>

<% with $CurrentJob %>
	<p><strong>Title:</strong> $Title<br />
	<strong>Location:</strong> $Location<br />
<% end_with %>

<div class="apply-form form_full">
	$RenderForm
</div>

<div id="job_nav">
	<% with $CurrentJob %>
		<a href="$JobListingPage.Link">&larr; View all Jobs</a>
	<% end_with %>
</div>
