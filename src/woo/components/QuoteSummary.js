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
    border-bottom: 1px solid black;
    padding-bottom: .5em;
  }

  .quote-summary-list {
    margin: 0;
    padding: 0;

    &__item {
      list-style: none;
      font-weight: 600;
      padding: .2em 0; 
      line-height: normal;

      label {
        font-size: 1em;
        font-weight: bold;
      }
    }
  }

  .total-price {
    border-top: 1px solid black;
    font-weight: bold;
    margin-top: .5em;
    margin-bottom: .2em;
    padding-top: .5em;
    font-size: 1.5em;
    line-height: normal;
  }

  small {
    line-height: normal;
    font-weight: 600;
    display: inline-block;
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
  const { productPricingSettings, generalOptions, variables, total } = useProductPricing();
  const _replaceValue = (string) => {
    let obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions }, variables);
    let tagValues = reduce(obj?.tags, (result, _fn, key) => {
      result[key] = _fn();
      return result;
    }, {});
    
    let result = '#No';
    let evalString = string.replaceArray(Object.keys(tagValues), Object.values(tagValues));
    console.log(string, evalString)
    try {
      result = eval(evalString);
    } catch (e) {
      result = evalString;
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
    <div className="total-price"><span style={{ color: '#d5208b' }}>$</span>{ total }</div>
    <small>{ __('Estimates are in CAD and excludes tax and shipping.', 'clampdown-child') }</small>
  </QuoteSummaryContainer>
}