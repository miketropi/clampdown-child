/**
 * Clampdown Script
 * 
 */

/**
 * SCSS
 */
import './scss/main.scss';

;((w, $) => { 
  'use strict';

  const requestQuoteShowMoreDataList_Func = () => {
    $('body').on('click', '.product-pricing-data-list .__show-more-data-list', function(e) {
      e.preventDefault();
      let $self = $(this);
      $self.parent().find('.product-pricing-data-list__ul').addClass('__show-full');
      $self.remove();
    })
  }

  const uploadSubmitFilesCustomOrderOptions_Func = () => {
    let $selects = $('.custom-options-order-by-user-logged select');
    // console.log($fields);
    $.each($selects, (index, $s) => {
      const choices = new Choices($s);
      choices.setChoices(async () => {
        try {
          const orders = await fetch(`${ CLAMPDOWN_PHP_DATA.ajaxurl }?action=clampdown_child_woo_get_orders_by_user_logged_in`);
          console.log(orders.json());
        } catch(err) {
          console.log(err)
        }
      })
    })
    
  }

  const Ready = () => {
    requestQuoteShowMoreDataList_Func();
    uploadSubmitFilesCustomOrderOptions_Func();
  }

  /**
   * DOM Ready  
   * 
   */
  $(Ready);
})(window, jQuery)