import React, { useState, useEffect, useContext, createContext } from 'react';
import { registerGeneralCustomerPricingFields, registerCustomerPricingFields, mixDataJacketTypeNumber, updateTagVariableViaSettingsRules } from '../lib';
import { getProductPricingSettings } from '../api/helpers';
import { Modal } from 'antd';
import { InfoCircleOutlined } from '@ant-design/icons';

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
  const [generalOptions, setGeneralOptions] = useState({})
  const [variables, setVariables] = useState([]);
  const [currentVariable, setCurrentVariable] = useState(0);
  const [productPricingSettings, setProductPricingSettings] = useState({});
  const [total, setTotal] = useState(0);

  const customerPricingFields = registerCustomerPricingFields();
  const generalCustomerPricingFields = registerGeneralCustomerPricingFields();
  const getDefaultFields = (fields, fn) => {
    let _f = {};
    Object.values(fields).forEach(item => {
      _f[item.name] = item.default;
    })  

    fn ? (_f = {..._f, ...fn.call('', _f)}) : '';
    return _f;
  }
  const _mixDataJacketTypeNumber = mixDataJacketTypeNumber();

  useEffect(async () => {
    const pricingSettings = await getProductPricingSettings(productID);
    setProductPricingSettings(pricingSettings?.settings);

    /**
     * General default value
     */
    let _generalOptions = { ...generalOptions };
    _generalOptions = getDefaultFields(generalCustomerPricingFields);
    setGeneralOptions(_generalOptions)

    /**
     * Variant default value
     */
    let _variables = [...variables];
    _variables[currentVariable] = getDefaultFields(customerPricingFields, (_f) => {
      let _obj = updateTagVariableViaSettingsRules({
        _r: pricingSettings?.settings?.product_pricing_custom_tag_price_rules,
        _r_total: pricingSettings?.settings?.product_pricing_total_price_recipe,
      }, { ..._generalOptions, ..._f });
  
      // _f.__TOTAL__ = _obj?.total() || 0;
      return { __TOTAL__: _obj?.total() || 0 }
    });
    setVariables(_variables);

    setLoading(false);
  }, [])

  /**
   * Calc total price each variant item after change general opts
   */
  const recalcVariantsTotalPrice = () => {
    let _variables = [...variables];
    if(_variables.length <= 0) return;

    /**
     * each variant item & update Total price
     */
    _variables.forEach((fields, i) => {
      if(!fields) return;
      
      let _obj = updateTagVariableViaSettingsRules({
        _r: productPricingSettings?.product_pricing_custom_tag_price_rules,
        _r_total: productPricingSettings?.product_pricing_total_price_recipe,
      }, { ...generalOptions, ...fields });
      
      fields.__TOTAL__ = _obj.total();
      _variables[i] = fields;
    })

    setVariables(_variables);
  }

  useEffect(() => {
    /**
     * Update variants total
     */
    recalcVariantsTotalPrice();
  }, [generalOptions])

  useEffect(() => {
    let _total = 0;
    let _variables = [...variables];

    _variables.forEach(item => {
      _total += item?.__TOTAL__ || 0;
    })

    setTotal(_total.toFixed(2));
  }, [variables])

  const onChangeVariablePlace = (num) => {
    let _variables = [...variables];

    if(_variables[num]) {
      // switch
      setCurrentVariable(num);
    } else {
      Modal.confirm({
        title: __('Confirm', 'clampdown-child'),
        icon: <InfoCircleOutlined />,
        content: __('Add variant item?', 'clampdown-child'),
        okText: __('OK', 'clampdown-child'),
        cancelText: __('Cancel', 'clampdown-child'),
        cancelButtonProps: { style: { background: 'none', color: 'black', border: 'none', boxShadow: 'none' } },
        okButtonProps: { style: { border: 'none', boxShadow: 'none' } },
        onOk: () => { 
          _variables[num] = getDefaultFields(customerPricingFields, (_f) => {
            let _obj = updateTagVariableViaSettingsRules({
              _r: productPricingSettings?.product_pricing_custom_tag_price_rules,
              _r_total: productPricingSettings?.product_pricing_total_price_recipe,
            }, { ...generalOptions, ..._f });
            
            // _f.__TOTAL__ = _obj?.total() || 0;
            return { __TOTAL__: _obj?.total() || 0 }
          });
          setVariables(_variables);
          setCurrentVariable(num);
        }
      });
    }
  }

  const value = {
    version: '1.0.0',
    generalCustomerPricingFields,
    customerPricingFields,
    loading, setLoading,
    productPricingSettings, setProductPricingSettings,
    updateTagVariableViaSettingsRules,
    total, setTotal,
    _mixDataJacketTypeNumber,
    generalOptions, setGeneralOptions,
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