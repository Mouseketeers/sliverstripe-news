<h1>$Title</h1>
$Content
<% control News %>
<div id="NewsItem">
	<p class="date">$FromDate.Long</p>
	<h2>$Title</h2>
	<p>$NewsImage.SetWidth(80)$Content.firstParagraph</p>
	<p><a href="$Link" class="ReadMore">Read more</a></p>
</div>
<% end_control %>