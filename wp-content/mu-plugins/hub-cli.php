<?php
/**
 * Minimal WP-CLI utilities for hub cache warming/clearing
 */
defined('ABSPATH') || exit;

if ( defined('WP_CLI') && WP_CLI ) {
    class Rosalinda_Hub_CLI {
        public static function clear( $args, $assoc ) {
            $opt = get_option('rosalinda_hub_transient_keys', array());
            $count = 0;
            if (!empty($opt) && is_array($opt)) {
                foreach ($opt as $k) {
                    if (delete_transient($k)) $count++;
                }
            }
            update_option('rosalinda_hub_transient_keys', array());
            WP_CLI::success("Cleared {$count} keys.");
            return 0;
        }

        public static function warm( $args, $assoc ) {
            if (empty($assoc['term'])) {
                WP_CLI::error('Missing --term=<term_id>');
                return 1;
            }
            $term_id = (int) $assoc['term'];
            $pages = isset($assoc['pages']) ? max(1,(int)$assoc['pages']) : 3;

            // Build filters from assoc args
            $filters = array();
            $allowed = function_exists('ros_hub_allowed_filters') ? ros_hub_allowed_filters() : array();
            foreach (array('protein','state','time','diet') as $k) {
                if (!empty($assoc[$k])) {
                    $v = sanitize_text_field($assoc[$k]);
                    if (isset($allowed[$k]) && in_array($v, $allowed[$k], true)) $filters[$k] = $v;
                }
            }

            $warmed = array();
            // Warm chips override/discovered
            if (function_exists('ros_hub_get_chips_for_term')) {
                $c = ros_hub_get_chips_for_term($term_id, 8);
                $warmed[] = 'ros_hub_chips_override_' . $term_id;
            }

            // Warm pages
            for ($p=1;$p<=$pages;$p++) {
                $key = function_exists('rosalinda_hub_transient_key') ? rosalinda_hub_transient_key($term_id, array('primary',$filters,'paged'=>$p)) : '';
                // Trigger the same query used by the theme: primary list and collection
                $meta_query = array('relation'=>'AND');
                if (!empty($filters['protein'])) $meta_query[] = array('key'=>'protein','value'=>$filters['protein'],'compare'=>'=');
                if (!empty($filters['state'])) $meta_query[] = array('key'=>'state','value'=>$filters['state'],'compare'=>'=');
                if (!empty($filters['time'])) {
                    $min = (int)$filters['time'];
                    $max = $min === 15 ? 15 : ($min === 30 ? 30 : 60);
                    $meta_query[] = array('key'=>'time_total','value'=>$max,'type'=>'NUMERIC','compare'=>'<=');
                }
                if (!empty($filters['diet'])) $meta_query[] = array('key'=>'diet','value'=>$filters['diet'],'compare'=>'LIKE');

                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 12,
                    'paged' => $p,
                    'tax_query' => array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),
                    'meta_query' => count($meta_query) > 1 ? $meta_query : array(),
                    'ignore_sticky_posts' => true,
                );
                $q = new WP_Query($args);
                // touching the query should prime any transients that call rosalinda_hub_get_cached
                $warmed[] = $key;
                wp_reset_postdata();
            }

            WP_CLI::success('Warmed ' . count($warmed) . ' keys.');
            foreach ($warmed as $k) WP_CLI::line($k);
            return 0;
        }
    }

    WP_CLI::add_command('hub:cache', function($args,$assoc){
        if (isset($args[0]) && $args[0] === 'clear') return Rosalinda_Hub_CLI::clear($args,$assoc);
        if (isset($args[0]) && $args[0] === 'warm') return Rosalinda_Hub_CLI::warm($args,$assoc);
        WP_CLI::error('Unknown subcommand. Use clear|warm');
    });
}
