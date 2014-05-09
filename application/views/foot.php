	</div> <!-- align center -->
	<div class="credits" align="right">&copy; 2013  &bull; Powered by <a href="http://xumb.frofens.org">Xumb</a></div>
	</div> <!-- container corners -->
<?php
	if( ENVIRONMENT!='production' ) {
?>
	<div id="error-details" style="display: none">&nbsp;</div>
<?php
	} // if ENV
?>
</body>
<script>
$(document).ready(function() {
	$(".itembox").fancybox({
		maxWidth	: 500,
		maxHeight	: 400,
		fitToView	: false,
		width		: '90%',
		height		: '90%',
		autoSize	: false,
		closeClick	: true,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
})
</script>
</html>