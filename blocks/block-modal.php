<?php
$modal = array();
$modal['modal_id'] = block_value('modal_id');
$modal['title'] = block_value('title');
$modal['desc'] = block_value('description');
// $modal['image'] = block_field('image');
$modal['link'] = block_value('link');
?>

<figure class="wp-block-image is-style-shadow">
    <a href="#modal_<?php echo $modal['modal_id'] ?>">
        <img src="<?php echo block_field('image') ?>" data-src="" alt="" class="lazyloaded" data-luminous="off">
    </a>
</figure>


<div class="remodal" data-remodal-id="modal_<?php echo $modal['modal_id'] ?>">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="wp-block-columns wp-block-columns--modal">
        <div class="wp-block-column">
            <figure class="wp-block-image is-style-shadow">
                <img src="<?php echo block_field('image') ?>" data-src="" alt="" class="lazyloaded" data-luminous="off">
            </figure>
        </div>

        <div class="wp-block-column">
            <h2><?php echo $modal['title']; ?></h2>
            <p><?php echo $modal['desc']; ?></p>
            <div class="swell-block-button red_ is-style-btn_solid">
                <a href="<?php echo $modal['link']; ?>" class="swell-block-button__link"><span>詳細を見る</span></a>
            </div>
        </div>
    </div>
</div>