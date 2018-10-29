<h1>Position Details</h1>
<% if $CurrentJob.Exists %>
	<% with $CurrentJob %>
		<h2>Title: $Title<br />
			Location: $Location</h2>
		$Description
		<div id="job_nav">
			<a href="$JobListingPage.Link">&larr; View all Jobs</a>
			<a href="$ApplyLink">Apply for this Position &rarr;</a>
		</div>
	<% end_with %>
<% else %>
	<p>I could not locate the position you're looking for.</p>
<% end_if %>