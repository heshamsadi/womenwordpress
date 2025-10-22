<?php
/**
 * Hub helpers: transient management and lightweight collectors for L2/L3 hub templates
 */
defined('ABSPATH') || exit;

// Transient registry option name
if (!function_exists('rosalinda_hub_transient_key')) {
    function rosalinda_hub_transient_key($term_id, $filters = array()) {
        $hash = md5($term_id . ':' . serialize($filters));
        return 'ros_hub_' . $hash;
    }

    function rosalinda_hub_register_key($key) {
        $opt = get_option('rosalinda_hub_transient_keys', array());
        if (!in_array($key, $opt, true)) {
            $opt[] = $key;
            update_option('rosalinda_hub_transient_keys', $opt);
        }
    }

    function rosalinda_hub_get_cached($term_id, $filters, $callback, $expire = 600) {
        $key = rosalinda_hub_transient_key($term_id, $filters);
        $data = get_transient($key);
        if ($data === false) {
            $data = call_user_func($callback);
            set_transient($key, $data, $expire);
            rosalinda_hub_register_key($key);
        }
        return $data;
    }

    /**
     * Allowed filter values used by discovery and validation
     */
    function ros_hub_allowed_filters() {
        return array(
            'protein' => array('chicken','beef','pork','seafood','veg','tofu'),
            'state'   => array('fresh','frozen'),
            'time'    => array('15','30','60'),
            'diet'    => array('vegan','vegetarian','keto','paleo'),
        );
    }

    /**
     * Discover chips from recent posts in a term (L3), filtered by a safe whitelist.
     * Caches for 10 min. Falls back to static allowed list if discovery yields none.
     */
    function ros_hub_discover_chips( int $term_id, int $limit = 8 ): array {
        $allowed = ros_hub_allowed_filters();

        $key = 'ros_hub_chips_' . md5( $term_id . ':' . $limit );
        $cached = get_transient( $key );
        if ( false !== $cached ) return $cached;

        // Sample recent posts in this term
        $ids = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => 60,
            'tax_query' => array(array('taxonomy'=>'category','field'=>'term_id','terms'=>$term_id)),
            'fields' => 'ids',
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ));

        $found = array('protein'=>array(), 'state'=>array(), 'time'=>array(), 'diet'=>array());

        foreach ($ids as $pid) {
            $protein = get_post_meta($pid, 'protein', true);
            $state   = get_post_meta($pid, 'state', true);
            $time    = get_post_meta($pid, 'time_total', true);
            $diet    = (array) get_post_meta($pid, 'diet', true);

            if ($protein && in_array($protein, $allowed['protein'], true)) $found['protein'][$protein] = 1 + ($found['protein'][$protein] ?? 0);
            if ($state && in_array($state, $allowed['state'], true)) $found['state'][$state] = 1 + ($found['state'][$state] ?? 0);
            if ($time) {
                $bucket = $time <= 15 ? '15' : ($time <= 30 ? '30' : '60');
                $found['time'][$bucket] = 1 + ($found['time'][$bucket] ?? 0);
            }
            foreach ($diet as $d) if (in_array($d, $allowed['diet'], true)) $found['diet'][$d] = 1 + ($found['diet'][$d] ?? 0);
        }

        // Sort by frequency and cap
        foreach ($found as $k => $arr) {
            if (!empty($arr)) {
                arsort($arr);
                $found[$k] = array_slice(array_keys($arr), 0, $limit);
            } else {
                $found[$k] = array_slice($allowed[$k], 0, min($limit, count($allowed[$k])));
            }
        }

        set_transient($key, $found, 600);
        rosalinda_hub_register_key($key);
        return $found;
    }

    /**
     * Get chips for a term, preferring an editor-provided chips_override term meta.
     * Accepted formats:
     *  - JSON object: {"protein":["chicken"],"state":["frozen"]}
     *  - Simple list: protein=chicken|beef,state=frozen,diet=keto|vegan
     * Validates values against ros_hub_allowed_filters().
     * Caches parsed override for 10 minutes as ros_hub_chips_override_{term_id} and registers key.
     */
    function ros_hub_get_chips_for_term( int $term_id, int $limit = 8 ): array {
        $allowed = ros_hub_allowed_filters();
        $cache_key_override = 'ros_hub_chips_override_' . $term_id;
        $cached = get_transient($cache_key_override);
        if ( false !== $cached ) return $cached;

        $raw = get_term_meta($term_id, 'chips_override', true);
        $parsed = null;
        if (!empty($raw) && is_string($raw)) {
            $trim = trim($raw);
            // Try JSON first
            $json = json_decode($trim, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                $parsed = $json;
            } else {
                // Parse simple k=v|v2,k2=v form
                $pairs = preg_split('/\s*,\s*/', $trim);
                $parsed = array();
                foreach ($pairs as $pair) {
                    if (strpos($pair, '=') === false) continue;
                    list($k, $v) = explode('=', $pair, 2);
                    $k = trim($k); $v = trim($v);
                    if ($k === '') continue;
                    $vals = preg_split('/\s*\|\s*/', $v);
                    $parsed[$k] = $vals;
                }
            }
        }

        if (!empty($parsed) && is_array($parsed)) {
            $clean = array();
            foreach ($parsed as $k => $vals) {
                if (!isset($allowed[$k])) continue;
                $vals = (array) $vals;
                $out = array();
                foreach ($vals as $val) {
                    $val = trim($val);
                    if ($val === '') continue;
                    if (in_array($val, $allowed[$k], true)) $out[] = $val;
                }
                if (!empty($out)) $clean[$k] = array_values(array_slice(array_unique($out), 0, $limit));
            }
            if (!empty($clean)) {
                set_transient($cache_key_override, $clean, 600);
                rosalinda_hub_register_key($cache_key_override);
                return $clean;
            }
        }

        // Fallback to discovery
        return ros_hub_discover_chips($term_id, $limit);
    }

    function rosalinda_hub_clear_all_transients() {
        $opt = get_option('rosalinda_hub_transient_keys', array());
        if (!empty($opt) && is_array($opt)) {
            foreach ($opt as $k) {
                delete_transient($k);
            }
        }
        update_option('rosalinda_hub_transient_keys', array());
    }

    // Bust hub transients on content updates
    add_action('save_post', 'rosalinda_hub_clear_all_transients', 10, 2);
    add_action('edited_terms', 'rosalinda_hub_clear_all_transients');
    add_action('trashed_post', 'rosalinda_hub_clear_all_transients');
}
