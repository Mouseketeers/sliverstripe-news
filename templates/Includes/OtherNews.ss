<% if OtherNews %>
<div id="OtherNews">
	<h2>Øvrige aktuelle nyheder</h2>
	<% control OtherNews %>
	
	<div class="listItem clickable" onclick="location.href='$Link'">
		<% if FromDate %><p class="date">$FromDate.FormatI18N(%e. %B %Y)</p><% end_if %>
		<p><a href="$Link">$Title</a></p>
		
	</div>
	<% end_control %>
</div>
<% end_if %>