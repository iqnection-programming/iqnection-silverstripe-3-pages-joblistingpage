<h1>Position Application</h1>

<% with $CurrentJob %>
	<h2>Title: $Title<br />
		Location: $Location</h2>
<% end_with %>

<div class="apply-form form_full">
	$RenderForm
</div>

<div id="job_nav">
	<% with $CurrentJob %>
		<a href="$JobListingPage.Link">&larr; View all Jobs</a>
	<% end_with %>
</div>
