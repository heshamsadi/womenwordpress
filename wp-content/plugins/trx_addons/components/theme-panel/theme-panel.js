/* global jQuery:false */
/* global TRX_ADDONS_STORAGE:false */

jQuery(document).ready(function(){

	"use strict";

	// Button 'Go Back'
	jQuery('.trx_addons_theme_panel_prev_step').on('click', function(e) {
		var tabs = jQuery(this).parents('.trx_addons_tabs'),
			tabs_li = tabs.find('> ul > li'),
			tab_active = tabs.find('.ui-state-active').index();
		tabs_li.eq(tab_active-1).find('> a').trigger('click');
		e.preventDefault();
		return false;
	});

	// Button 'Next Step'
	jQuery('.trx_addons_theme_panel_next_step').on('click', function(e) {
		var tabs = jQuery(this).parents('.trx_addons_tabs'),
			tabs_li = tabs.find('> ul > li'),
			tab_active = tabs.find('.ui-state-active').index();
		tabs_li.eq(tab_active+1 >= tabs_li.length ? 0 : tab_active+1).find('> a').trigger('click');
		e.preventDefault();
		return false;
	});

	// Select / Deselect all plugins
	jQuery('.trx_addons_theme_panel_plugins_buttons').on('click', 'a', function(e) {
		if (jQuery(this).hasClass('trx_addons_theme_panel_plugins_button_select')) {
			var items = jQuery(this).parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_list_item > a:not([data-state="deactivate"])');
			if (items.length > 0) {
				items.parent().addClass('trx_addons_theme_panel_plugins_list_item_checked');
				jQuery(this).parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_install').removeAttr('disabled');
			}
		} else {
			jQuery(this).parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_list_item').removeClass('trx_addons_theme_panel_plugins_list_item_checked');
			jQuery(this).parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_install').attr('disabled', 'disabled');
		}
		e.preventDefault();
		return false;
	});

	// Select / Deselect one plugin
	jQuery('.trx_addons_theme_panel_plugins_list_item').on('click', 'a', function(e) {
		if (jQuery(this).data('state')!='deactivate') {
			var item = jQuery(this).parent();
			item.toggleClass('trx_addons_theme_panel_plugins_list_item_checked');
			if (item.parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_list_item_checked').length > 0) {
				item.parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_install').removeAttr('disabled');
			} else {
				item.parents('.trx_addons_theme_panel_plugins_installer').find('.trx_addons_theme_panel_plugins_install').attr('disabled', 'disabled');
			}
		}
		e.preventDefault();
		return false;
	});

	//Run installation
    jQuery('.trx_addons_theme_panel_plugins_install').on('click', function(e) {
        var bt = jQuery(this);
        if (bt.attr('disabled') !== 'disabled') {
            var plugins_total = jQuery( this ).parents( '.trx_addons_theme_panel_plugins_installer' ).find( '.trx_addons_theme_panel_plugins_list_item_checked' ).length;
            if ( plugins_total > 0 ) {
                bt.attr('disabled', 'disabled').data('need-reload', '1');
                jQuery('.trx_addons_theme_panel').addClass('trx_addons_theme_panel_busy').data('plugins-total', plugins_total);
                trx_addons_plugins_installer();
            }
        }
        e.preventDefault();
        return false;
    });

    // Installer
    var attempts = 0;

    function trx_addons_plugins_installer() {

        var items = jQuery( '.trx_addons_theme_panel_plugins_installer' ).find( '.trx_addons_theme_panel_plugins_list_item_checked' );
        if (items.length === 0) {
            if ( jQuery('.trx_addons_theme_panel_plugins_install').data('need-reload') == '1' ) {
                if ( location.hash != 'trx_addons_theme_panel_section_plugins' ) {
                    trx_addons_document_set_location( location.href.split('#')[0] + '#' + 'trx_addons_theme_panel_section_plugins' );
                }
                location.reload( true );
            }
            return;
        }
        var item  = items.eq(0),
            link  = item.find('a'),
            url   = trx_addons_add_to_url( link.attr('href'), { 'activate-multi': 1 } ),
            label = link.find('span'),
            state = link.data('state'),
            text  = link.data(state+'-progress'),
            total = jQuery('.trx_addons_theme_panel').data('plugins-total');

        label
            .addClass('trx_addons_loading')
            .html(text);

        //Request plugin activation
        attempts++;
        if ( attempts > 3 ) {
            attempts = 0;
            item.removeClass('trx_addons_theme_panel_plugins_list_item_checked');
            setTimeout( trx_addons_plugins_installer, 0 );
            return;
        }

        // Repeat checking after the plugin activation to avoid breaking install process if server not respond
        var check_again = false,
            check_again_timer = state == 'activate'
                                ? setTimeout( function() {
                                        check_again = true;
                                        trx_addons_plugins_check_state();
                                    }, 30000 )
                                : 0;

        // Do action: install or activate plugin
        jQuery.get(url).done(
            function(response) {
                if (check_again_timer) {
                    clearTimeout(check_again_timer);
                    check_again_timer = 0;
                }
                // Repeat checking after the plugin activation to prevent breaking install process if server not respond
                check_again = false;
                check_again_timer = state == 'activate'
                                        ? setTimeout( function() {
                                                check_again = true;
                                                trx_addons_plugins_check_state();
                                            }, 30000 )
                                        : 0;
                // Check current state of the plugin
                trx_addons_plugins_check_state();
            }
        );

        // Check state of the plugin
        function trx_addons_plugins_check_state() {
            jQuery.post(
                // Add parameter 'activate-multi' to prevent 'welcome screen' from some plugins
                trx_addons_add_to_url( TRX_ADDONS_STORAGE['ajax_url'], { 'activate-multi': 1 } ),
                {
                    'action': 'trx_addons_check_plugin_state',
                    'nonce': TRX_ADDONS_STORAGE['ajax_nonce'],
                    'slug': link.data('slug')
                },
                function(response){
                    if (check_again && !check_again_timer) {
                        return;
                    }
                    if (check_again_timer) {
                        clearTimeout(check_again_timer);
                        check_again_timer = 0;
                    }
                    var rez  = { error: '', state: '' },
                        step = 0,
                        pos  = -1;
                    if ( response !== '' &&  response !== 0 && response.indexOf('{"error":') >= 0 ) {
                        try {
                            if ( (pos = response.indexOf('{"error":')) >= 0 ) {
                                response = response.substr( pos );
                                    rez = JSON.parse( response );
                            } else {
                                rez.error = TRX_ADDONS_STORAGE['msg_get_pro_error'];
                            }
                        } catch (e) {
                            rez = { error: TRX_ADDONS_STORAGE['msg_get_pro_error'] };
                            console.log( response );
                        }
                    }
                    if (rez.error !== '') {
                        item.removeClass('trx_addons_theme_panel_plugins_list_item_checked');
                        attempts = 0;
                    } else {
                        if (rez.state == 'activate' ) {
                            if (state == 'install') {
                                state = 'activate';
                                link.attr('href', link.data('activate-nonce'));
                                attempts = 0;
                            } else {
                                attempts++;
                            }
                            step = 1;
                        } else if (rez.state == 'deactivate') {
                            if (state == 'install' || state == 'activate') {
                                state = 'deactivate';
                                item.removeClass('trx_addons_theme_panel_plugins_list_item_checked');
                                attempts = 0;
                            } else {
                                attempts++;
                            }
                        } else {
                            attempts++;
                        }
                        if (state !== '' && state !== 0) {
                            link.data('state', state).attr('data-state', state);
                            label.removeClass('trx_addons_loading');
                            label.html(link.data(state+'-label'));
                        }
                        // Doing next step
                        trx_addons_plugins_installer();
                    }
                }
            );
        }
    }
});
