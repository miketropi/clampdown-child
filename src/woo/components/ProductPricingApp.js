import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerPricingForm from './CustomerPricingForm';
import VariablesPlace from './VariablesSpace';

const TotalPriceContainer = styled.div`
  
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
    <TotalPriceContainer>
      Total: { `$${ variables[currentVariable].__TOTAL__ }` }
    </TotalPriceContainer>
  </Fragment>
}