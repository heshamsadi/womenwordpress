<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage ROSALINDA
 * @since ROSALINDA 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'rosalinda_storage_get' ) ) {
	function rosalinda_storage_get( $var_name, $default = '' ) {
		global $ROSALINDA_STORAGE;
		return isset( $ROSALINDA_STORAGE[ $var_name ] ) ? $ROSALINDA_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'rosalinda_storage_set' ) ) {
	function rosalinda_storage_set( $var_name, $value ) {
		global $ROSALINDA_STORAGE;
		$ROSALINDA_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'rosalinda_storage_empty' ) ) {
	function rosalinda_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $ROSALINDA_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $ROSALINDA_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $ROSALINDA_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $ROSALINDA_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'rosalinda_storage_isset' ) ) {
	function rosalinda_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $ROSALINDA_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $ROSALINDA_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $ROSALINDA_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $ROSALINDA_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'rosalinda_storage_inc' ) ) {
	function rosalinda_storage_inc( $var_name, $value = 1 ) {
		global $ROSALINDA_STORAGE;
		if ( empty( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = 0;
		}
		$ROSALINDA_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'rosalinda_storage_concat' ) ) {
	function rosalinda_storage_concat( $var_name, $value ) {
		global $ROSALINDA_STORAGE;
		if ( empty( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = '';
		}
		$ROSALINDA_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'rosalinda_storage_get_array' ) ) {
	function rosalinda_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $ROSALINDA_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) ? $ROSALINDA_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $ROSALINDA_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $ROSALINDA_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'rosalinda_storage_set_array' ) ) {
	function rosalinda_storage_set_array( $var_name, $key, $value ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$ROSALINDA_STORAGE[ $var_name ][] = $value;
		} else {
			$ROSALINDA_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'rosalinda_storage_set_array2' ) ) {
	function rosalinda_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$ROSALINDA_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$ROSALINDA_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'rosalinda_storage_merge_array' ) ) {
	function rosalinda_storage_merge_array( $var_name, $key, $value ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$ROSALINDA_STORAGE[ $var_name ] = array_merge( $ROSALINDA_STORAGE[ $var_name ], $value );
		} else {
			$ROSALINDA_STORAGE[ $var_name ][ $key ] = array_merge( $ROSALINDA_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'rosalinda_storage_set_array_after' ) ) {
	function rosalinda_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			rosalinda_array_insert_after( $ROSALINDA_STORAGE[ $var_name ], $after, $key );
		} else {
			rosalinda_array_insert_after( $ROSALINDA_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'rosalinda_storage_set_array_before' ) ) {
	function rosalinda_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			rosalinda_array_insert_before( $ROSALINDA_STORAGE[ $var_name ], $before, $key );
		} else {
			rosalinda_array_insert_before( $ROSALINDA_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'rosalinda_storage_push_array' ) ) {
	function rosalinda_storage_push_array( $var_name, $key, $value ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $ROSALINDA_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) ) {
				$ROSALINDA_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $ROSALINDA_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'rosalinda_storage_pop_array' ) ) {
	function rosalinda_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $ROSALINDA_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $ROSALINDA_STORAGE[ $var_name ] ) && is_array( $ROSALINDA_STORAGE[ $var_name ] ) && count( $ROSALINDA_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $ROSALINDA_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) && is_array( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) && count( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $ROSALINDA_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'rosalinda_storage_inc_array' ) ) {
	function rosalinda_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( empty( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ][ $key ] = 0;
		}
		$ROSALINDA_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'rosalinda_storage_concat_array' ) ) {
	function rosalinda_storage_concat_array( $var_name, $key, $value ) {
		global $ROSALINDA_STORAGE;
		if ( ! isset( $ROSALINDA_STORAGE[ $var_name ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ] = array();
		}
		if ( empty( $ROSALINDA_STORAGE[ $var_name ][ $key ] ) ) {
			$ROSALINDA_STORAGE[ $var_name ][ $key ] = '';
		}
		$ROSALINDA_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'rosalinda_storage_call_obj_method' ) ) {
	function rosalinda_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $ROSALINDA_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $ROSALINDA_STORAGE[ $var_name ] ) ? $ROSALINDA_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $ROSALINDA_STORAGE[ $var_name ] ) ? $ROSALINDA_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'rosalinda_storage_get_obj_property' ) ) {
	function rosalinda_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $ROSALINDA_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $ROSALINDA_STORAGE[ $var_name ]->$prop ) ? $ROSALINDA_STORAGE[ $var_name ]->$prop : $default;
	}
}
