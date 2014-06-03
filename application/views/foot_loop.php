	</div>
</section>	

<footer>
	<div class="wrap960">
		<p style="text-align: right;">&copy; 2013  &bull; Powered by <a href="http://xumb.frofens.org">Xumb</a></p>
	</div>
</footer>

<?php if( ENVIRONMENT!='production' ) { ?>
	<div id="error-details" style="display: none">&nbsp;</div>
<?php } // if ENV ?>

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
		type		: 'ajax',
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
})
</script>
</html>