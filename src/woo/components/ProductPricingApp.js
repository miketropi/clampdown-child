import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerGeneralPricingForm from './CustomerGeneralPricingForm';
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
    generalOptions, setGeneralOptions,
    variables, setVariables,
    currentVariable, 
    loading, 
    productPricingSettings, 
    updateTagVariableViaSettingsRules, 
    onChangeVariablePlace, 
    total } = useProductPricing();

  useEffect(() => {

  }, [])

  if(loading == true) {
    return <Fragment>{ __('Loading...', 'clampdown-child') }</Fragment>
  }

  const AddToCartClickHandle = (e) => {
    e.preventDefault();
    console.log(generalOptions, variables)
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
    {/* <VariantPriceContainer>
      <span>{ __('Variant Price:', 'clampdown-child') }</span> 
      <span>{ `$${ variables[currentVariable].__TOTAL__ }` }</span>
    </VariantPriceContainer> */}
    <hr />
    <br />
    <ButtonAddToCart 
      text={ __(`Request Quote ($${ total })`, 'clampdown-child') }
      onClick={ AddToCartClickHandle } />
  </Fragment>
}