<h1>Position Application</h1>
<% with findJobby %>
	<p><strong>Title:</strong> $Title<br />
	<strong>Location:</strong> $Location<br />
<% end_with %>
$RenderForm
<div id="job_nav">
	<% with findJobby %>
		<a href="$JobListingPage.Link">&larr; View all Jobs</a>
	<% end_with %>
</div>
