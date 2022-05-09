<?php

/* 子テーマのfunctions.phpは、親テーマのfunctions.phpより先に読み込まれることに注意してください。 */


/**
 * 親テーマのfunctions.phpのあとで読み込みたいコードはこの中に。
 */
// add_filter('after_setup_theme', function(){
// }, 11);


/**
 * 子テーマでのファイルの読み込み
 */
add_action('wp_enqueue_scripts', function() {
	
	$timestamp = date( 'Ymdgis', filemtime( get_stylesheet_directory() . '/style.css' ) );
	wp_enqueue_style( 'child_style', get_stylesheet_directory_uri() .'/style.css', [], $timestamp );
	/* その他の読み込みファイルはこの下に記述 */
	wp_enqueue_style( 'remodal_default_style', get_stylesheet_directory_uri() .'/assets/css/remodal-default-theme.css', [], $timestamp );
	wp_enqueue_style( 'remodal_style', get_stylesheet_directory_uri() .'/assets/css/remodal.css', [], $timestamp );
	wp_enqueue_script( 'remodal_js', get_stylesheet_directory_uri() .'/assets/js/plugins/remodal.min.js', array('jquery'), '1.0.0', true );

}, 11);
