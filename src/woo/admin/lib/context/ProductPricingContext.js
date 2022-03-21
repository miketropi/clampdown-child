import React, { useState, useEffect, useContext, createContext } from 'react';
import { registerCustomerPricingFields } from '../lib';
import { getProductPricingSettings } from '../api/helpers';
const ProductPricingContext = createContext();

const ProductPricingProvider = ({ productID, children }) => {
  const customerPricingFields = registerCustomerPricingFields();
  const [loading, setLoading] = useState(true);
  const [productPricingSettings, setProductPricingSettings] = useState({});
  const [fields, setFields] = useState({});

  useEffect(async () => {

    const getDefaulFields = () => {
      let __fields = { ...fields };
      Object.values(customerPricingFields).forEach(item => {
        __fields[item.name] = item.default;
      })
      
      return __fields;
      
    }
    setFields(getDefaulFields());

    const pricingSettings = await getProductPricingSettings(productID);
    setProductPricingSettings(pricingSettings);

    setLoading(false);
  }, [])

  const value = {
    version: '1.0.0',
    customerPricingFields,
    fields, setFields,
    loading, setLoading,
    productPricingSettings, setProductPricingSettings,
  }

  return <ProductPricingContext.Provider value={ value }>
    { children }
  </ProductPricingContext.Provider>
}

const useProductPricing = () => {
  return useContext(ProductPricingContext);
}

export { ProductPricingProvider, useProductPricing };