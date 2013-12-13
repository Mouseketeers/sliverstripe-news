<% if OtherNews %>
	<h2>More news</h2>
	<div class="content-list">
		<% control OtherNews %>
		<div class="content-item">
			<a href="$Link" class="link-block">
				<h3>$Title</h3>
				<% if FromDate %><p class="date"><strong>NEWS</strong> $FromDate.Long</p><% end_if %>
			</a>
		</div>
	<% end_control %>
</div>
<% end_if %>