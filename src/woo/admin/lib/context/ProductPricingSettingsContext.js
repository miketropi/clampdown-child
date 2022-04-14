import react, { useContext, createContext, useState, useEffect } from 'react';
import { getProductPricingSettings, sendProductPricingSettingsToSave } from '../api/helpers';
import { registerGeneralCustomerPricingFields, registerCustomerPricingFields } from '../lib';

const ProductPricingSettingsContext = createContext();

const ProductPricingSettingsProvider = ({ product, children }) => {
  const [settings, setSettings] = useState({});
  const [saveDataLoading, setSaveDataLoading] = useState(false);

  useEffect(() => {
    const __setSettingsData = async () => {
      const result = await getProductPricingSettings(product);
      const settings = result?.settings;

      if(settings?.general_default_opts?.sides) {
        settings.general_default_opts.sides = parseInt(settings.general_default_opts.sides);
      }

      setSettings({ ...settings })
    }
    
    __setSettingsData();
  }, [])

  const saveData = async (data) => {
    setSaveDataLoading(true);
    const result = await sendProductPricingSettingsToSave(product, data);
    setSaveDataLoading(false);
    console.log(result);
  }

  const value = { 
    product,
    settings, setSettings,
    generalCustomerOptions: registerGeneralCustomerPricingFields(),
    customerOptions: registerCustomerPricingFields(),
    saveData,
    saveDataLoading,
  };

  return <ProductPricingSettingsContext.Provider value={ value }>
    { children }
  </ProductPricingSettingsContext.Provider>
}

const userProductPricingSettings = () => {
  return useContext(ProductPricingSettingsContext);
}

export { ProductPricingSettingsProvider, userProductPricingSettings };