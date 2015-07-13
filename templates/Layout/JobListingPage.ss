<h1>$Title</h1>
$Content
<% if Positions %>
	<div id="jobs_container">
		<div id="job-search-box">
			<h3>Filter Results</h3>
			<div>
				<label>Filter By Category:</label>
				<select id="job-search-category">$CategoriesForDropdown</select>
			</div>
			<div>
				<label>Filter By Keyword:</label>
				<input id="job-search-filter" value="" />
			</div>
		</div>
		<table cellspacing="1" id="job_list">
			<thead>
				<tr>
					<th class="l">Job Title</th>
					<th class="l">Job Category</th>
					<th class="l">Job Location</th>
					<th class="c">More Information</th>
				</tr>
			</thead>
			<tbody>
				<% loop Positions %>
					<tr class="job-row" rel="$JobCategoryID">
						<td class="l" data-title="Job Title"><a href="$Link">$Title</a></td>
						<td class="l" data-title="Category"><a href="$Link">$CategoryName</a></td>
						<td class="l" data-title="Location"><a href="$Link">$Location</a></td>
						<td class="c" data-title="More Info"><a href="$Link">Details&nbsp;<img src="/iq-joblistingpage/images/magnifier.png"></a></td>
					</tr>
				<% end_loop %>                
			</tbody>
		</table>
	</div><!--jobs_container-->
<% end_if %>
