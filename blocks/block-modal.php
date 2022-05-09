<?php
$modal = array();
$modal['modal_id'] = block_value('modal_id');
$modal['title'] = block_value('title');
$modal['desc'] = nl2br(block_value('description'));
$attachment_id = block_value('image');
$modal['image'] = wp_get_attachment_image( $attachment_id, 'large' );
$modal['link'] = block_value('link');
?>

<figure class="wp-block-image is-style-shadow">
    <a href="#modal_<?php echo $modal['modal_id'] ?>">
        <?php echo $modal['image']; ?>
    </a>
</figure>


<div class="remodal" data-remodal-id="modal_<?php echo $modal['modal_id'] ?>">
    <button data-remodal-action="close" class="remodal-close"></button>
    <div class="wp-block-columns wp-block-columns--modal">

        <div class="wp-block-column wp-block-column--left">
            <figure class="wp-block-image is-style-shadow">
                <?php echo $modal['image']; ?>
            </figure>
        </div>
        <div class="wp-block-column wp-block-column--right">
            <h2 class="title"><?php echo $modal['title']; ?></h2>
            <p class="desc"><?php echo $modal['desc']; ?></p>
            <div class="swell-block-button red_ is-style-btn_solid">
                <a href="<?php echo $modal['link']; ?>" class="swell-block-button__link"><span>詳細を見る</span></a>
            </div>
        </div>
    </div>
</div>