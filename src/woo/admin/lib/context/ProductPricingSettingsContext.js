import react, { useContext, createContext, useState, useEffect } from 'react';
import { getProductPricingSettings, sendProductPricingSettingsToSave } from '../api/helpers';
import { registerCustomerPricingFields } from '../lib';

const ProductPricingSettingsContext = createContext();

const ProductPricingSettingsProvider = ({ product, children }) => {
  const [settings, setSettings] = useState({})

  useEffect(() => {
    const __setSettingsData = async () => {
      const result = await getProductPricingSettings(product);
      const settings = result?.settings;
      setSettings({ ...settings })
    }
    
    __setSettingsData();
  }, [])

  const saveData = async (data) => {
    const result = await sendProductPricingSettingsToSave(product, data);
    console.log(result);
  }

  const value = { 
    product,
    settings, setSettings,
    customerOptions: registerCustomerPricingFields(),
    saveData,
  };

  return <ProductPricingSettingsContext.Provider value={ value }>
    { children }
  </ProductPricingSettingsContext.Provider>
}

const userProductPricingSettings = () => {
  return useContext(ProductPricingSettingsContext);
}

export { ProductPricingSettingsProvider, userProductPricingSettings };