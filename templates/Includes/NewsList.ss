<% if ShowNewsList %>
<div id="news-widget">
	<h1>$NewsListHeadline</h1>
	<% if News %>
		<% control News %>
		<a href="$Link" class="link-block">
			<p class="date">$FromDate.Long</p>
			<h3>$Title</h3>
			<p><% if Abstract %>$Abstract<% else %>$Content.Summary(16)<% end_if %></p>
		</a>
		<% end_control %>
	<% else %>
	<p>$NewsListNoNewsMessage</p>
	<% end_if %>
</div>
<% end_if %>