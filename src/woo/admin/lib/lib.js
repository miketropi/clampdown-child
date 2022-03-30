/**
 * Lib 
 */
import disco from '../../../json/disco.json';
import foldover from '../../../json/foldover.json';
import gatefoldJacket from '../../../json/gatefold-jacket.json';
import innerLoadingGatefoldJacket from '../../../json/inner-loading-gatefold-jacket.json';
import standardJacket from '../../../json/standard-jacket.json';
import widespine from '../../../json/widespine.json';
import map from 'lodash/map';

export const mixDataJacketTypeNumber = () => {
  return { 
    ...disco, 
    ...foldover, 
    ...gatefoldJacket, 
    ...innerLoadingGatefoldJacket, 
    ...standardJacket, 
    ...widespine 
  };
}

export const mapObject = (object, iteratee) => {
  const props = Object.keys(object);
  const result = new Array(props.length);
  props.forEach((key, index) => {
    result[key] = iteratee(object[key], key, object);
  })
  return result;
}

export const registerGeneralCustomerPricingFields = () => {
  return {
    Size: (() => {
      return {
        name: 'size',
        label: 'Size',
        type: 'select', 
        options: ['12" Pricing', '7" Pricing'],
        default: '12" Pricing',
      }
    })(),
    Sides: (() => {
      return {
        name: 'sides',
        label: 'Sides',
        type: 'select', 
        options: [0, 1, 2, 4, 6],
        default: 2,
      }
    })(),
    Speed: (() => {
      return {
        name: 'speed',
        label: 'Speed',
        type: 'select', 
        options: ['33 1/3', '45'],
        default: '33 1/3',
      }
    })(),
    JacketType: (() => {
      return {
        name: 'jacket_type',
        label: 'Jacket Type',
        type: 'select',
        options: [
          'Standard Jacket',
          'Gatefold Jacket',
          'Inner Loading Gatefold Jacket',
          'Widespine',
          'Foldover',
          'Disco'
        ],
        default: 'Standard Jacket',
      }
    })(),
    InnerSleeve: (() => {
      return {
        name: 'inner_sleeve',
        label: 'Inner Sleeve',
        type: 'select',
        options: [
          'White',
          'Black',
          'Printed',
          'White Poly Lined',
          'Black Poly Lined',
        ],
        default: 'White',
      }
    })(),
    Insert: (() => {
      return {
        name: 'insert',
        label: 'Insert',
        type: 'select',
        options: [
          'None',
          '1 panel',
          '2 panel',
          '4 panel',
          '6 panel',
        ],
        default: 'None',
      }
    })(),
    Packaging: (() => {
      return {
        name: 'packaging',
        label: 'Packaging',
        type: 'select',
        options: [
          'Poly Bags',
          'Shrink Wrap'
        ],
        default: 'Poly Bags'
      }
    })(),
    DownloadCards: (() => {
      return {
        name: 'download_cards',
        label: 'Download Cards',
        type: 'select',
        options: [
          'None',
          'Simple',
          'Fancy',
        ],
        default: 'None',
      }
    })(),
    MarketingStickers: (() => {
      return {
        name: 'marketing_stickers',
        label: 'Marketing Stickers',
        type: 'select',
        options: [
          'None',
          'Circle',
          'Square',
        ],
        default: 'None',
      }
    })(),
    Tests: (() => {
      return {
        name: 'tests',
        label: 'Tests?',
        type: 'hidden',
        default: 'Yes',
      }
    })(),
    Labels: (() => {
      return {
        name: 'labels',
        label: 'Labels',
        type: 'hidden',
        default: 'Yes',
      }
    })(),
  }
}

export const registerCustomerPricingFields = () => {
  return {
    Number: (() => {
      return {
        name: 'number',
        label: 'Number',
        type: 'select',
        options: [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 900, 1000, 1100, 1200, 2000],
        default: 300,
      }
    })(),
    Style: (() => {
      return {
        name: 'style',
        label: 'Style',
        type: 'select',
        options: ['Standard', 'Colour',	'Deluxe', 'Colour'],
        default: 'Standard',
      }
    })(),
    Colour: (() => {
      return {
        name: 'colour',
        label: 'Colour',
        type: 'select',
        options: ['Black', 'Orange', 'Red'],
        default: 'Black',
      }
    })(),
    Weight: (() => {
      return {
        name: 'weight',
        label: 'Weight',
        type: 'select',
        options: ['140g', '180g'],
        default: '140g',
      }
    })(),
  }
}

export const updateTagVariableViaSettingsRules = (settings, opts, variables = null) => {
  // console.log(variables_count);
  // console.log({ _r, _r_total }, opts)
  const variant_rules = settings?.product_pricing_custom_tag_price_rules || [];
  const total_rules = settings?.product_pricing_custom_tag_price_total_rules || [];
  const _each_variant_total = settings?.product_pricing_total_price_foreach_variant;
  const _total = settings?.product_pricing_total_price;
  const _r =( variables == null ? variant_rules : total_rules);
  // console.log(variables, settings);
  if(!_r) return; 
  let _tagVariables = {};
  let _fields = { ...opts };
  let JacketTypeNumber = mixDataJacketTypeNumber();

  /**
   * Customer field tags
   */
  map(_fields, (value, name) => {
    let fieldNumber = ['sides', 'number'];
    if(fieldNumber.includes(name)) {
      value = parseInt(value);
    }

    _tagVariables[`@{${ name }}`] = () => value;
  })

  if(variables == null) {
    /**
       * each variant
       * 
       * @{MIX_JacketType_Number}
       */
    _tagVariables['@{MIX_JacketType_Number}'] = () => {
      let _key = `${ opts?.jacket_type }:${ opts?.number }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }
  } else {
    /**
     * Total
     * 
     * - @{Variants_Count_Number}
     * - @{TOTAL_Variant_Number_Units}
     * - @{TOTAL_ALL_Variants_Price}
     * - @{MIX_JacketType_TOTAL_Variant_Number_Units}
     */

    _tagVariables['@{Variants_Count_Number}'] = () => { 
      return variables.length; 
    }

    _tagVariables['@{TOTAL_Variant_Number_Units}'] = () => {
      let total = 0;
      variables.map(v => { total += parseInt(v.number) });
      return total;
    }

    _tagVariables['@{TOTAL_ALL_Variants_Price}'] = () => { 
      let total = 0;
      variables.map(v => { total += v.__TOTAL__; }); 
      return total;
    }

    _tagVariables['@{MIX_JacketType_TOTAL_Variant_Number_Units}'] = () => {
      let TotalNumberUnits = _tagVariables['@{TOTAL_Variant_Number_Units}']();
      let _key = `${ opts?.jacket_type }:${ TotalNumberUnits }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }
  }
  
  /**
   * Recipe tags
   */
  if(_r.length > 0) {
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
              if(name === 'Records') {
                console.log(evalString);
              }
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
  }

  return {
    tags: _tagVariables,
    eachVariantTotal() {

      const _tagVariablesWithValue = mapObject(_tagVariables, (fn) => {
        return fn();
      });

      try {
        let evalString = _each_variant_total.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
        return eval(evalString);
      } catch (error) {
        return 0;
      }
    }, 
    total() {

      const _tagVariablesWithValue = mapObject(_tagVariables, (fn) => {
        return fn();
      });

      console.log(_tagVariablesWithValue);

      try {
        let evalString = _total.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
        return eval(evalString);
      } catch (error) {
        return 0;
      }
    }
  };
}