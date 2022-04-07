import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerGeneralPricingForm from './CustomerGeneralPricingForm';
import CustomerPricingForm from './CustomerPricingForm';
import VariablesPlace from './VariablesSpace';
import ButtonAddToCart from './ButtonAddToCart';
import { __ } from '@wordpress/i18n';

export default function ProductPricingApp() {
  const { 
    productID, wp_nonce, 
    generalOptions, setGeneralOptions,
    variables, setVariables,
    currentVariable, 
    loading, 
    productPricingSettings, 
    updateTagVariableViaSettingsRules, 
    onChangeVariablePlace, 
    total } = useProductPricing();

  if(loading == true) {
    return <Fragment>{ __('Loading...', 'clampdown-child') }</Fragment>
  }

  const AddToCartClickHandle = async (e) => {
    e.preventDefault();
    // console.log(generalOptions, variables)
    
    const result = await jQuery.ajax({
      type: 'POST',
      url: `${ CLAMPDOWN_PHP_WOO_DATA.site_url }/?wc-ajax=yith_ywraq_action`,
      data: {
        'quantity': 1,
        'context': 'frontend',
        'action': 'yith_ywraq_action',
        'ywraq_action': 'add_item',
        'product_id': parseInt(productID),
        wp_nonce,
        'yith-add-to-cart': parseInt(productID),
        pricing_data: { ...generalOptions, ...variables },
        pricing_total: total,
      },
      error: (e) => {
        console.log(e)
      }
    });

    console.log(result);
  }

  return <Fragment>
    <CustomerGeneralPricingForm onChange={ (allFields) => { 
        setGeneralOptions(allFields);
      } }
      fields={ generalOptions }/>
    <hr />
    <br />
    <VariablesPlace onChange={ onChangeVariablePlace } />
    <CustomerPricingForm 
      onChange={ allFields => {
        let _variables = [...variables];
        _variables[currentVariable] = allFields;

        let _obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions, ...allFields });
        _variables[currentVariable].__TOTAL__ = _obj.eachVariantTotal();

        setVariables(_variables);
      } } 
      fields={ variables[currentVariable] } />
    <hr />
    <br />
    <ButtonAddToCart 
      text={ __(`Request Quote ($${ total })`, 'clampdown-child') }
      onClick={ AddToCartClickHandle } />
  </Fragment>
}