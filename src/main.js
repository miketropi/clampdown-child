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
    if($selects.length == 0) return; 

    $.each($selects, (index, $s) => {
      const choices = new Choices($s);
      choices.clearChoices();
      choices.setChoiceByValue(null);
    
      choices.setChoices(async () => {
        try {
          const orders = await fetch(`${ CLAMPDOWN_PHP_DATA.ajaxurl }?action=clampdown_child_woo_get_orders_by_user_logged_in`, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
          });
          return await orders.json();
        } catch(err) {
          console.log(err)
        }
      })
    })
  }

  const autoFillGFormField = () => {
    const { fname, lname, user_email } = CLAMPDOWN_PHP_DATA.autofill;

    /**
     * Name field
     */
    $('.autofill-billing-name').find('.name_first input').val(fname);
    $('.autofill-billing-name').find('.name_last input').val(lname);

    /**
     * User email field
     */
    $('.autofill-user-email').find('input').val(user_email);
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

  /**
   * 
   */
  $(w).on('load', () => {
    autoFillGFormField();
  })
})(window, jQuery)