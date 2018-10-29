<h1>Position Details</h1>
<% if $CurrentJob.Exists %>
	<% with $CurrentJob %>
		<p><strong>Title:</strong> $Title<br />
		<strong>Location:</strong> $Location<br />
		$Description
		<div id="job_nav">
			<a href="$JobListingPage.Link">&larr; View all Jobs</a>
			<a href="$ApplyLink">Apply for this Position &rarr;</a>
		</div>
	<% end_with %>
<% else %>
	<p>I could not locate the position you're looking for.</p>
<% end_if %>