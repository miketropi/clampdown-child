import react, { useContext, createContext, useState, useEffect } from 'react';
import { getProductPricingSettings } from '../api/helpers';
import { registerCustomerPricingFields } from '../lib';

const ProductPricingSettingsContext = createContext();

const ProductPricingSettingsProvider = ({ product, children }) => {
  const [settings, setSettings] = useState({})

  useEffect(() => {
    const __setSettingsData = async () => {
      const result = await getProductPricingSettings(product);
      setSettings({ ...result })
    }
    
    __setSettingsData();
  }, [])

  const value = { 
    product,
    settings, setSettings,
    customerOptions: registerCustomerPricingFields(),
  };

  return <ProductPricingSettingsContext.Provider value={ value }>
    { children }
  </ProductPricingSettingsContext.Provider>
}

const userProductPricingSettings = () => {
  return useContext(ProductPricingSettingsContext);
}

export { ProductPricingSettingsProvider, userProductPricingSettings };