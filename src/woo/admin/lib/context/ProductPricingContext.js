import React, { useState, useEffect, useContext, createContext } from 'react';
import { registerCustomerPricingFields, mixDataJacketTypeNumber } from '../lib';
import { getProductPricingSettings } from '../api/helpers';
import map from 'lodash/map';
const ProductPricingContext = createContext();

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
};

function mapObject(object, iteratee) {
  const props = Object.keys(object);
  const result = new Array(props.length);
  props.forEach((key, index) => {
    result[key] = iteratee(object[key], key, object);
  })
  return result;
}

const ProductPricingProvider = ({ productID, children }) => {
  const customerPricingFields = registerCustomerPricingFields();
  const [loading, setLoading] = useState(true);
  const [productPricingSettings, setProductPricingSettings] = useState({});
  const [fields, setFields] = useState({});
  const [total, setTotal] = useState(0);
  const _mixDataJacketTypeNumber = mixDataJacketTypeNumber();

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
    setProductPricingSettings(pricingSettings?.settings);

    setLoading(false);
  }, [])

  const updateTagVariableViaSettingsRules = ({ _r, _r_total }, opts) => {
    if(!_r) return; 
    let _tagVariables = {};
    let _fields = opts;
    let JacketTypeNumber = { ..._mixDataJacketTypeNumber };

    /**
     * Customer field tags
     */
    map(_fields, (value, name) => {
      _tagVariables[`@{${ name }}`] = () => value;
    })

    /**
     * System tags
     */
    _tagVariables['@{MIX_JacketType_Number}'] = () => {
      let _key = `${ opts?.jacket_type }:${ opts?.number }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }
    
    /**
     * Recipe tags
     */
    _r.forEach((item, _index) => {
      let result = 0;
      let { field_type, name, recipe } = item;
      let _tagVariablesWithValue = mapObject(_tagVariables, (fn) => {
        return fn();
      });

      switch(field_type) {
        case 'global':
          _tagVariables[`@{${name}}`] = () => {
            try{
              let evalString = recipe.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
              result = eval(evalString);
            } catch(e) {
              result = 0;
            } 
            return result;
          }
          break;
        default:
          let { field_operator, field_option  } = item;
          _tagVariables[`@{${name}}`] = () => {  
            let operatorCase = {
              '=='() { return (opts[field_type] == field_option) },
              '!='() { return (opts[field_type] != field_option) }
            };

            if(operatorCase[field_operator]() == false) return 0;

            try{
              let evalString = recipe.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
              result = eval(evalString);
            } catch(e) {
              result = 0;
            } 
            return result;
          }
          break;
      }
    })

    return {
      tags: _tagVariables,
      total() {
        const _tagVariablesWithValue = mapObject(_tagVariables, (fn) => {
          return fn();
        });

        try {
          let evalString = _r_total.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
          return eval(evalString);
        } catch (error) {
          return 0;
        }
      }
    };
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
  }

  return <ProductPricingContext.Provider value={ value }>
    { children }
  </ProductPricingContext.Provider>
}

const useProductPricing = () => {
  return useContext(ProductPricingContext);
}

export { ProductPricingProvider, useProductPricing };