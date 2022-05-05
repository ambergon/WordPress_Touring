<?php
/* Plugin Name:WordPress_Touring
 * Plugin URI:
 * Description:Touring カテゴリのDraft記事をランダムで一つ表示する。
 * Version:1.0
 * Author:ambergon
 * Author URI:https://ambergonslibrary.com/
 * License:
 * License URL:
 * Text Domain:
 * Domain Path:
 * */

#カテゴリ
#- Touring

class WordPress_Touring {

    const PLUGIN_NAME = 'WordPress_Touring';
    const PREFIX = 'WordPress_Touring_';

    function SetPluginMenu(){
        add_menu_page( self::PLUGIN_NAME . 'の設定' , self::PLUGIN_NAME , 'administrator' , __FILE__ , [ $this , 'setting' ] );
    }
    function setting(){
        global $parent_file;
        if( $parent_file != 'option-general.php' ){
            require( ABSPATH . 'wp-admin/options-head.php' );
        }

        ###カテゴリをidで取得する
        $cate_ID = get_cat_ID("Touring");
        $request = new WP_Query(
            apply_filters(
                'widget_posts_args',
                [
                    'cat'                 => $cate_ID,
                    'post_status'         => 'draft',
                    'ignore_sticky_posts' => true,
                ])
        );

        #投稿がなければキャンセル
        if ( ! $request->have_posts() ) {
            return;
        }

        #cssを読み込む
        echo '<link rel="stylesheet"  href="';
        bloginfo('stylesheet_url');
        echo '" type="text/css" media="all" />';

        $randam_post = array_rand( $request->posts , 1 );
        $randam_draft = $request->posts[ $randam_post ];
        $post = get_post( $randam_draft->ID );
        echo $post->post_content;
    }
}

$WordPress_Touring = new WordPress_Touring();

if( is_admin() ){
    add_action( 'admin_menu' , [ $WordPress_Touring , 'SetPluginMenu' ] );
}





?>
