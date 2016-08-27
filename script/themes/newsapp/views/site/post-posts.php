<?php if($posts) foreach($posts as $post) { ?>
	<?php $this->renderPartial('/site/post-repeat',array('post'=>$post,'typepage'=>$typepage)); ?>
<?php } else { ?>
<div class="entry">
  <div class="post-content">
		<h2 class="text-center txt-sorry">Sorry, try again</h2>
  </div>
</div>
<?php } ?>