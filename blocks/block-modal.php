<?php
$modal = array();
$modal['title'] = block_value('title');
$modal['desc'] = block_value('description');
// $modal['image'] = block_field('image');
$modal['link'] = block_value('link');
?>

<figure class="wp-block-image is-style-shadow">
    <a href="#modal_a">
        <img src="<?php echo block_field('image') ?>" data-src="" alt="" class="lazyloaded"data-luminous="off">
    </a>
</figure>
<p><?php echo $modal['title'] ?></p>

<div class="remodal" data-remodal-id="modal_a">
  <button data-remodal-action="close" class="remodal-close"></button>
  <h2><?php echo $modal['title']; ?></h2>
  <p><?php echo $modal['desc']; ?></p>
  <br>
  <button data-remodal-action="cancel" class="remodal-cancel">Cancel</button>
  <button data-remodal-action="confirm" class="remodal-confirm">OK</button>
</div>