<?php if (get_field('address')): ?>
<div class="entry-content">
	<div class="gmap_canvas">
		<iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?= urlencode(get_field('address'));?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
	</div>
</div>
<?php endif;?>