import React, { useState, useEffect, useContext, createContext } from 'react';
import { registerCustomerPricingFields, mixDataJacketTypeNumber, updateTagVariableViaSettingsRules } from '../lib';
import { getProductPricingSettings } from '../api/helpers';

const ProductPricingContext = createContext();
const { __ } = wp.i18n;

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
};

const ProductPricingProvider = ({ productID, children }) => {
  const [loading, setLoading] = useState(true);
  const [variables, setVariables] = useState([]);
  const [currentVariable, setCurrentVariable] = useState(0);
  const [productPricingSettings, setProductPricingSettings] = useState({});
  const [fields, setFields] = useState({});
  const [total, setTotal] = useState(0);

  const customerPricingFields = registerCustomerPricingFields();
  const getDefaultFields = (settings) => {
    let _f = {};
    Object.values(customerPricingFields).forEach(item => {
      _f[item.name] = item.default;
    })  
    
    let _obj = updateTagVariableViaSettingsRules({
      _r: settings?.product_pricing_custom_tag_price_rules,
      _r_total: settings?.product_pricing_total_price_recipe,
    }, _f);

    _f.__TOTAL__ = _obj?.total() || 0;
    return _f;
  }
  const _mixDataJacketTypeNumber = mixDataJacketTypeNumber();

  useEffect(async () => {
    const pricingSettings = await getProductPricingSettings(productID);
    setProductPricingSettings(pricingSettings?.settings);

    let _variables = [...variables];
    _variables[currentVariable] = getDefaultFields(pricingSettings?.settings);
    setVariables(_variables);
    setFields(getDefaultFields());

    setLoading(false);
  }, [])

  const onChangeVariablePlace = (num) => {
    let _variables = [...variables];

    if(_variables[num]) {
      // switch
      console.log('switch variable');
      setCurrentVariable(num);
    } else {
      // add new
      if(confirm(__('Add variable', 'clampdown-child'))) {
        _variables[num] = getDefaultFields(productPricingSettings);
        setVariables(_variables);
        setCurrentVariable(num);
      }
    }
  }

  const value = {
    version: '1.0.0',
    customerPricingFields,
    fields, setFields,
    loading, setLoading,
    productPricingSettings, setProductPricingSettings,
    updateTagVariableViaSettingsRules,
    total, setTotal,
    _mixDataJacketTypeNumber,
    variables, setVariables,
    currentVariable, setCurrentVariable,
    onChangeVariablePlace,
  }

  return <ProductPricingContext.Provider value={ value }>
    {/* { JSON.stringify(variables) } */}
    { children }
  </ProductPricingContext.Provider>
}

const useProductPricing = () => {
  return useContext(ProductPricingContext);
}

export { ProductPricingProvider, useProductPricing };