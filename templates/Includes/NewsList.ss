<% if ShowNewsList %>
<div id="news-widget">
	<h2>$NewsListHeadline</h2>
	<% if News %>
	<div class="content-list">
		<% control News %>
		<div class="content-item">
			<a href="$Link" class="link-block">
				<h3>$Title</h3>
				<p class="date"><strong>NEWS</strong> $FromDate.Long</p>
				<p><% if Abstract %>$Abstract<% else %>$Content.Summary(16)<% end_if %></p>
			</a>
		</div>
		<% end_control %>
	</div>
	<% else %>
	<p>$NewsListNoNewsMessage</p>
	<% end_if %>
</div>
<% end_if %>