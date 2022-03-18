/**
 * Woo backend scripts
 * 
 */
import react from 'react'; 
import reactDOM from 'react-dom';
import { ProductPricingSettingsProvider } from './lib/context/ProductPricingSettingsContext'
import ProductPricingSettings from './components/ProductPricingSettings';

;((w, $) => {

  const Ready = () => {
    const App = document.getElementById('CLAMPDOWN_PRODUCT_PRICING_SETTINGS_APP');
    if(!App) return;

    reactDOM.render(
    <ProductPricingSettingsProvider product={ App.dataset.product }>
      <ProductPricingSettings />
    </ProductPricingSettingsProvider>, App);
  }

  $(Ready)

})(window, jQuery); 
