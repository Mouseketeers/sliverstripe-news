<% if OtherNews %>
<div id="OtherNews">
	<h2>More news</h2>
	<% control OtherNews %>
		<% if FromDate %><p class="date">$FromDate.Long</p><% end_if %>
		<p><a href="$Link">$Title</a></p>
	</div>
	<% end_control %>
</div>
<% end_if %>