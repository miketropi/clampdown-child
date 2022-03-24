import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerPricingForm from './CustomerPricingForm';
import VariablesPlace from './VariablesSpace';
import ButtonAddToCart from './ButtonAddToCart';

const VariantPriceContainer = styled.div`
  padding: 1em 0;
  border: solid #eee;
  border-width: 1px 0;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  margin-bottom: 1em;
`
const { __ } = wp.i18n;

export default function ProductPricingApp() {
  const { 
    version, 
    fields, 
    setFields, 
    variables,
    setVariables,
    currentVariable, 
    loading, 
    tagVariables, 
    productPricingSettings, 
    updateTagVariableViaSettingsRules, 
    onChangeVariablePlace, 
    total, 
    setTotal } = useProductPricing();

  useEffect(() => {

  }, [])

  if(loading == true) {
    return <Fragment>{ __('Loading...', 'clampdown-child') }</Fragment>
  }

  return <Fragment>
    <VariablesPlace onChange={ onChangeVariablePlace } />
    <CustomerPricingForm 
      onChange={ allFields => {
        let _variables = [...variables];
        _variables[currentVariable] = allFields;

        let _obj = updateTagVariableViaSettingsRules({
          _r: productPricingSettings?.product_pricing_custom_tag_price_rules,
          _r_total: productPricingSettings?.product_pricing_total_price_recipe,
        }, allFields);

        _variables[currentVariable].__TOTAL__ = _obj.total();
        setVariables(_variables);
      } } 
      fields={ variables[currentVariable] } />
    <VariantPriceContainer>
      <span>{ __('Variant Price:', 'clampdown-child') }</span> 
      <span>{ `$${ variables[currentVariable].__TOTAL__ }` }</span>
    </VariantPriceContainer>
    <ButtonAddToCart text={ __(`Add To Cart ($${ total })`, 'clampdown-child') } />
  </Fragment>
}