import React, { Fragment } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import { updateTagVariableViaSettingsRules } from '../admin/lib/lib';
import reduce from 'lodash/reduce';
import { __ } from '@wordpress/i18n';

const QuoteSummaryContainer = styled.div`
  font-size: .9em; 
  margin: 1em 0; 
  padding: 1em;
  background: #e5f5fd;

  h4.quote-summary__title {
    font-size: 1em; 
    color: black;
    text-transform: uppercase;
    font-weight: bold;
  }

  .quote-summary-list {
    margin: 0;
    padding: 0;

    &__item {
      list-style: none;
      font-weight: 600;

      label {
        font-size: 1em;
        font-weight: bold;
      }
    }
  }
`

String.prototype.replaceArray = function(find, replace) {
  var replaceString = this;
  var regex; 
  for (var i = 0; i < find.length; i++) {
    regex = new RegExp(find[i], "g");
    replaceString = replaceString.replace(regex, replace[i]);
  }
  return replaceString;
}; 

export default () => {
  const { productPricingSettings, generalOptions, variables } = useProductPricing();
  const _replaceValue = (string) => {
    let obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions }, variables);
    let tagValues = reduce(obj?.tags, (result, _fn, key) => {
      result[key] = _fn();
      return result;
    }, {});
    
    let result = '#NAN';
    let evalString = string.replaceArray(Object.keys(tagValues), Object.values(tagValues));
    
    try {
      result = eval(evalString);
    } catch (e) {
      result = '#NAN';
    }

    return result;
  }

  return <QuoteSummaryContainer>
    <h4 className="quote-summary__title">{ __('Quote Summary', 'clampdown-child') }</h4>
    <ul className="quote-summary-list">
      {
        productPricingSettings?.product_pricing_summary_fields && 
        productPricingSettings?.product_pricing_summary_fields.map((item, index) => {
          let { label, value } = item;
          return (
            <li key={ index } className="quote-summary-list__item">
              <label>{ label }:</label> { _replaceValue(value) }
            </li>
          )
        })
      }
    </ul>
  </QuoteSummaryContainer>
}