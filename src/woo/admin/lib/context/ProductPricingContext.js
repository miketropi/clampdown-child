import React, { useState, useEffect, useContext, createContext } from 'react';
import { registerGeneralCustomerPricingFields, registerCustomerPricingFields, mixDataJacketTypeNumber, updateTagVariableViaSettingsRules } from '../lib';
import { getProductPricingSettings } from '../api/helpers';
import { Modal } from 'antd';
import { InfoCircleOutlined } from '@ant-design/icons';
import { __ } from '@wordpress/i18n';

const ProductPricingContext = createContext();
// const { __ } = wp.i18n;

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
}; 

const ProductPricingProvider = ({ productID, wp_nonce, children }) => {
  const [loading, setLoading] = useState(true);
  const [generalOptions, setGeneralOptions] = useState({})
  const [variables, setVariables] = useState([]);
  const [currentVariable, setCurrentVariable] = useState(0);
  const [productPricingSettings, setProductPricingSettings] = useState({});
  const [productExtraData, setProductExtraData] = useState({});
  const [total, setTotal] = useState(0);
  const customerPricingFields = registerCustomerPricingFields();
  const generalCustomerPricingFields = registerGeneralCustomerPricingFields();

  const getDefaultFields = (fields, fn) => {
    let _f = fields;
    fn ? (_f = {..._f, ...fn.call('', _f)}) : '';
    return _f;
  }

  useEffect(async () => {
    const pricingSettings = await getProductPricingSettings(productID);

    if(pricingSettings?.settings?.general_default_opts?.sides) {
      pricingSettings.settings.general_default_opts.sides = parseInt(pricingSettings.settings.general_default_opts.sides);
    }
    // console.log('__', pricingSettings?.settings);

    setProductPricingSettings(pricingSettings?.settings);
    setProductExtraData(pricingSettings?.extra);

    /**
     * General default value
     */
    let _generalOptions = { ...generalOptions };
    _generalOptions = getDefaultFields(pricingSettings?.settings?.general_default_opts);
    setGeneralOptions(_generalOptions)
    
    /**
     * Variant default value
     */
    let _variables = [...variables];
    _variables[currentVariable] = getDefaultFields(pricingSettings?.settings?.variant_default_opts, (_f) => {
      let _obj = updateTagVariableViaSettingsRules(pricingSettings?.settings, { ..._generalOptions, ..._f });
      return { __TOTAL__: _obj?.eachVariantTotal() || 0 }
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
      let _obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions, ...fields });    
      fields.__TOTAL__ = _obj.eachVariantTotal();
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
    let _obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions }, variables);
    console.log(_obj)
    let total = _obj?.total() || 0;

    setTotal(total.toFixed(2));
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
          let number = _variables.length;
          _variables[number] = getDefaultFields(productPricingSettings?.variant_default_opts, (_f) => {
            let _obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions, ..._f });
            return { __TOTAL__: _obj?.eachVariantTotal() || 0 }
          });
          setVariables(_variables);
          setCurrentVariable(number);
        }
      });
    }
  }

  const onRemoveVariant = (index) => {
    let _variables = [...variables];
    // console.log(index, _variables, _variables.splice(index, 1)); return;
    Modal.confirm({
      title: __('Confirm', 'clampdown-child'),
      icon: <InfoCircleOutlined />,
      content: __('Remove variant item?', 'clampdown-child'),
      okText: __('OK', 'clampdown-child'),
      cancelText: __('Cancel', 'clampdown-child'),
      cancelButtonProps: { style: { background: 'none', color: 'black', border: 'none', boxShadow: 'none' } },
      okButtonProps: { style: { border: 'none', boxShadow: 'none' } },
      onOk: () => { 

        _variables.splice(index, 1);
        // console.log('1___', _variables);
        _variables.filter(element => {
          return element != undefined;
        });

        // console.log('2___', _variables);

        setVariables(_variables);
        setCurrentVariable(0);
      }
    });
  } 

  const value = {
    version: '1.0.0',
    productID, wp_nonce, 
    // allSettings,
    generalCustomerPricingFields,
    customerPricingFields,
    loading, setLoading,
    productPricingSettings, setProductPricingSettings,
    productExtraData,
    updateTagVariableViaSettingsRules,
    total, setTotal,
    generalOptions, setGeneralOptions,
    variables, setVariables,
    currentVariable, setCurrentVariable,
    onChangeVariablePlace,
    onRemoveVariant,
  };

  return <ProductPricingContext.Provider value={ value }>
    {/* { JSON.stringify(variables) } */}
    { children }
  </ProductPricingContext.Provider>
}

const useProductPricing = () => {
  return useContext(ProductPricingContext);
}

export { ProductPricingProvider, useProductPricing };