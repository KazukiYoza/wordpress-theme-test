<?php
$modal = array();
$modal['title'] = block_value('title');
$modal['desc'] = block_value('description');
// $modal['image'] = block_field('image');
$modal['link'] = block_value('link');
?>

<figure class="wp-block-image is-style-shadow">
    <a href="#modal_a">
        <img src="<?php echo block_field('image') ?>" data-src="" alt="" class="lazyloaded" data-luminous="off">
    </a>
</figure>
<p><?php echo $modal['title'] ?></p>

<div class="remodal" data-remodal-id="modal_a">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="wp-block-columns">
        <div class="wp-block-column">
            <figure class="wp-block-image is-style-shadow">
                <img src="<?php echo block_field('image') ?>" data-src="" alt="" class="lazyloaded" data-luminous="off">
            </figure>
        </div>

        <div class="wp-block-column">
            <h2><?php echo $modal['title']; ?></h2>
            <p><?php echo $modal['desc']; ?></p>
            <a href="<?php echo $modal['link']; ?>" class="button is-primary">詳細を見る</a>
        </div>
    </div>
</div>