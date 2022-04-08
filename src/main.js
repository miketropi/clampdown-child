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

  const Ready = () => {
    requestQuoteShowMoreDataList_Func();
  }

  /**
   * DOM Ready  
   * 
   */
  $(Ready);
})(window, jQuery)