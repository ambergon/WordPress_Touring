<?php
/* Plugin Name:WordPress_Touring
 * Plugin URI:
 * Description:
 * Version:1.0
 * Author:ambergon
 * Author URI:https://ambergonslibrary.com/
 * License:
 * License URL:
 * Text Domain:
 * Domain Path:
 * */


##とりあえず指定した記事のカテゴリのdraft記事をリストで取得する
#カテゴリ
#- Touring
#- date


class WordPress_Touring {

    const PLUGIN_NAME = 'WordPress_Touring';
    const PREFIX = 'WordPress_Touring_';

    function SetPluginMenu(){
        add_menu_page( self::PLUGIN_NAME . 'の設定' , self::PLUGIN_NAME , 'administrator' , __FILE__ , [ $this , 'setting' ] );
        #add_action( 'admin_init' , [ $this , 'setting_api' ] );
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
            error_log( 'return');
            return;
        }

        #ランダムで一つだけ取得する
        #取得された最近の記事の数だけfor文を回す
        foreach ( $request->posts as $posts ){
            $post = get_post( $posts->ID );
            echo $post->post_content;
        }

        echo 'aaaa';
        #echo'<form method="post" action="options.php">'
        #settings_fields( self::PREFIX );
        #do_settings_sections( self::PREFIX );
        #submit_button();
        #echo'</form>'
    }
    #function setting_api(){
    #}
}




$WordPress_Touring = new WordPress_Touring();

if( is_admin() ){
    add_action( 'admin_menu' , [ $WordPress_Touring , 'SetPluginMenu' ] );
}













?>
