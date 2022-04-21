/**
 * Lib 
 */
import disco from '../../../json/disco.json';
import foldover from '../../../json/foldover.json';
import gatefoldJacket from '../../../json/gatefold-jacket.json';
import innerLoadingGatefoldJacket from '../../../json/inner-loading-gatefold-jacket.json';
import standardJacket from '../../../json/standard-jacket.json';
import widespine from '../../../json/widespine.json';
import printedInnerSleeves from '../../../json/printed-inner-sleeves.json';
import polyLinedInnerSleeves from '../../../json/poly-lined-inner-sleeves.json';
import labels from '../../../json/labels.json';
import downloadCards from '../../../json/download-cards.json';
import printedInserts from '../../../json/printed-inserts.json';
import panel4Inserts from '../../../json/4-panel-inserts.json';
import panel6Inserts from '../../../json/6-panel-inserts.json';
import printed40InnerSleeves from '../../../json/printed-4-0-inner-sleeves.json';
import whitePolyLinedInnerSleeves from '../../../json/white-poly-lined-inner-sleeves.json';
import { generalFields } from './generalCustomerPricingFields';
import { variantFields } from './variantFields';
import * as _7inch from '../../../json/7inch/7inch-data';

import map from 'lodash/map';

export const mixDataJacketTypeNumber = (size = '12') => { 
  console.log('mixDataJacketTypeNumber: ', size);
  const mixDataBySize = {
    '12': { 
      ...disco, 
      ...foldover, 
      ...gatefoldJacket, 
      ...innerLoadingGatefoldJacket, 
      ...standardJacket, 
      ...widespine,
  
      ...printedInnerSleeves,
      ...polyLinedInnerSleeves,
      ...labels,
      ...downloadCards,
  
      ...printedInserts,
      ...panel4Inserts,
      ...panel6Inserts,
  
      ...printed40InnerSleeves,
      ...whitePolyLinedInnerSleeves,
    },
    '7': (() => {
      let { standardJackets, 
        foldoverJackets, 
        wideSpineJackets, 
        printedInnerSleeves, 
        fullColourLabels, 
        oneColourLabels, 
        plainWhiteLabels, 
        printedInserts, 
        Panel4Inserts, 
        downloadCards } = _7inch;

        return {
          ...standardJackets, 
          ...foldoverJackets, 
          ...wideSpineJackets, 
          ...printedInnerSleeves, 
          ...fullColourLabels, 
          ...oneColourLabels, 
          ...plainWhiteLabels, 
          ...printedInserts, 
          ...Panel4Inserts, 
          ...downloadCards
        }
    })(),
  };

  return mixDataBySize[size];
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
  return generalFields;
}

export const registerCustomerPricingFields = () => {
  return variantFields;
}

export const isConditional = (conditional, fields) => {
  let pass = true;
  conditional?.map((item, _index) => {
    if(! item.values.includes(fields[item.field])) {
      if(pass == true) {
        pass = false;
      }
    }
  })
  return pass;
}

export const updateTagVariableViaSettingsRules = (settings, opts, variables = null) => {
  const variant_rules = settings?.product_pricing_custom_tag_price_rules || [];
  const total_rules = settings?.product_pricing_custom_tag_price_total_rules || [];
  const _each_variant_total = settings?.product_pricing_total_price_foreach_variant;
  const _total = settings?.product_pricing_total_price;
  const _r =( variables == null ? variant_rules : total_rules);

  if(!_r) return; 
  let _tagVariables = {};
  let _fields = { ...opts };
  let JacketTypeNumber = mixDataJacketTypeNumber(opts?.size);

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
     * - @{MIX_InnerSleeve_TOTAL_Variant_Number_Units}
     * - @{MIX_Labels_TOTAL_Variant_Number_Units}
     * - @{MIX_DownloadCards_TOTAL_Variant_Number_Units}
     * - @{MIX_Inserts_TOTAL_Variant_Number_Units}
     */

    _tagVariables['@{sides_label}'] = () => {
      let _valueMap = {
        0: 'Zero Side',
        1: 'One Side',
        2: 'Two Sides',
        4: 'Four Sides',
        6: 'Six Sides',
      };
      
      let output = (_valueMap[opts?.sides] ? _valueMap[opts?.sides] : '#No');
      return output;
    }

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

    _tagVariables['@{MIX_InnerSleeve_TOTAL_Variant_Number_Units}'] = () => {
      let TotalNumberUnits = _tagVariables['@{TOTAL_Variant_Number_Units}']();
      let _labelKey = `${ opts?.inner_sleeve } Inner Sleeves`;
      let _key = `${ _labelKey }:${ TotalNumberUnits }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }

    _tagVariables['@{MIX_Labels_TOTAL_Variant_Number_Units}'] = () => {
      let TotalNumberUnits = _tagVariables['@{TOTAL_Variant_Number_Units}']();
      let _labelKey = opts?.labels == 'Yes' ? 'Labels' : '__Labels_No';
      let _key = `${ _labelKey }:${ TotalNumberUnits }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }

    _tagVariables['@{MIX_DownloadCards_TOTAL_Variant_Number_Units}'] = () => {
      let TotalNumberUnits = _tagVariables['@{TOTAL_Variant_Number_Units}']();
      let _labelKey = opts?.download_cards == 'None' ? '__Download_Cards_No' : 'Download Cards';
      let _key = `${ _labelKey }:${ TotalNumberUnits }`;
      return (JacketTypeNumber[_key] ? (JacketTypeNumber[_key] || 0) : 0);
    }

    _tagVariables['@{MIX_Inserts_TOTAL_Variant_Number_Units}'] = () => {
      let TotalNumberUnits = _tagVariables['@{TOTAL_Variant_Number_Units}']();
      let _labelKey = opts?.insert == 'No' ? '__Insert_No' : `${ opts?.insert } Inserts`;
      let _key = `${ _labelKey }:${ TotalNumberUnits }`;  
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
              result = eval(evalString);
            } catch(e) {
              result = 0;
            } 
            return result;
          }
          break;
        default:
          let { field_operator, field_option } = item;
          
          _tagVariables[`@{${name}}`] = () => {  
            let operatorCase = {
              '=='() { return (opts[field_type] == field_option) },
              '!='() { return (opts[field_type] != field_option) },
              'in'() { return field_option?.split(',').includes(opts[field_type]) },
              'notIn'() { return !field_option?.split(',').includes(opts[field_type]) },
            };
  
            if(operatorCase[field_operator]() == false) return 0;
  
            try{
              let evalString = recipe.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
              if(name === 'InnerSleeveCost') {
                // console.log(evalString);
              }
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

      // console.log(_tagVariablesWithValue);

      try {
        let evalString = _total.replaceArray(Object.keys(_tagVariablesWithValue), Object.values(_tagVariablesWithValue));
        return eval(evalString);
      } catch (error) {
        return 0;
      }
    }
  };
}