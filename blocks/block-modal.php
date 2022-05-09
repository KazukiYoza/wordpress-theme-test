<?php
$modal = array();
$modal['title'] = block_value('title');
$modal['desc'] = block_value('description');
$modal['image'] = block_value('image');
$modal['link'] = block_value('link');
?>


<?php foreach ($modal as $key => $value) {
    if ($value != null) { ?>
    <figure class="wp-block-image is-style-shadow">
        <a href="<?php echo $modal['link']; ?>">
            <img src="<?php echo $modal['image']; ?>" data-src="" alt="" class="lazyloaded"data-luminous="off">
        </a>
    </figure>
    <p><?php echo $modal['title'] ?></p>
<?php } ?>
<?php } ?>