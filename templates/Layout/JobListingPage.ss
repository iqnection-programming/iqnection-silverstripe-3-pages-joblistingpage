<h1>$Title</h1>
$Content

<% if $JobPositions.Count %>
	<div id="jobs_container">
		<div id="job-search-box">
			<div class="stacked col2">
				<div class="fieldgroup-field field">
					<label>Filter By Category:</label>
					<div>
						<select id="job-search-category">
							<option value="">All</option>
							<% loop $JobCategories %>
								<option value="$ID">$Title</option>
							<% end_loop %>
						</select>
					</div>
				</div>
				<div class="fieldgroup-field field">
					<label>Filter By Keyword:</label>
					<div>
						<input id="job-search-filter" type="text" value="" />
					</div>
				</div>
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
				<% loop $JobPositions %>
					<tr class="job-row" rel="$JobCategory.ID">
						<td class="l" data-title="Job Title"><a href="$Link">$Title</a></td>
						<td class="l" data-title="Category"><a href="$Link">$JobCategory.Title</a></td>
						<td class="l" data-title="Location"><a href="$Link">$Location</a></td>
						<td class="c" data-title="More Info"><a href="$Link">Details&nbsp;<img src="/iq-joblistingpage/images/magnifier.png"></a></td>
					</tr>
				<% end_loop %>                
			</tbody>
		</table>
	</div><!--jobs_container-->
<% else %>
	<p>There currently aren't any open positions. Please check back later.</p>
<% end_if %>
