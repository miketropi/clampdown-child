import React from 'react';
import reactDOM from 'react-dom';
import ProductPricingApp from './woo/components/ProductPricingApp';
import { ProductPricingProvider } from './woo/admin/lib/context/ProductPricingContext';

import 'antd/dist/antd.css'; 

;((w, $) => {
  'use strict';

  if(!w.React)
    w.React = React;

  const Ready = () => {
    const App = document.getElementById('PRODUCT_PRICING_MODE_APP');
    if(!App) return;

    reactDOM.render(
      <ProductPricingProvider productID={ App.dataset.productId } wp_nonce={ App.dataset.wp_nonce }>
        <ProductPricingApp />
      </ProductPricingProvider>, App);
  } 

  $(Ready)
})(window, jQuery)