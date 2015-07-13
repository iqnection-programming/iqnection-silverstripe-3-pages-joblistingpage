<h1>Position Details</h1>
<% with Jobby %>
	<p><strong>Title:</strong> $Title<br />
	<strong>Location:</strong> $Location<br />
	$Content
	<div id="job_nav">
		<a href="$JobListingPage.Link">&larr; View all Jobs</a>
		<a href="$ApplyLink">Apply for this Position &rarr;</a>
	</div>
<% end_with %>
