<h1>$Title</h1>
$Content
<div id="ContentList">
	<% if ContentList %>
	<% control ContentList %>
	<% cached 'NewsPage', ID, Updated %>
	<div class="news listItem clickable" onclick="location.href='$Link'">
		<% if FromDate %><span class="date">$FromDate.FormatI18N(%e. %B %Y)</span><% end_if %>
		<h2><a href="$link">$Title</a></h2>
		<p><% if Abstract %>$Abstract<% else %>$Content.Summary<% end_if %></p>
	</div>
	<% end_cached %>
	<% end_control %>
	<% include Pagination %>
	<% end_if %>
</div>