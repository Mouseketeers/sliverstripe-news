
<div id="NewsWidget">
	<% if News %>
	<% control News %>
	<div class="NewsWidgetItem" onclick="location.href='$Link'">
		<p class="date">$FromDate.Long</p>
		<h3>$Title</h3>
		<p>$Content.firstParagraph</p>
		<p><a href="$Link" class="ReadMore">Read more</a></p>
	</div>
	<% end_control %>
	
	<% else %>
	<p>$NoNewsMessage</p>
	<% end_if %>
</div>
