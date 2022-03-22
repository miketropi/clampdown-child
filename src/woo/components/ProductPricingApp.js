import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerPricingForm from './CustomerPricingForm';

const TotalPriceContainer = styled.div`
  
`

export default function ProductPricingApp() {
  const { 
    version, 
    fields, 
    setFields, 
    loading, 
    tagVariables, 
    productPricingSettings, 
    updateTagVariableViaSettingsRules, 
    total, 
    setTotal } = useProductPricing();

  useEffect(() => {

  }, [])

  if(loading == true) {
    return <Fragment>Loading...</Fragment>
  }

  return <Fragment>
    <CustomerPricingForm 
      onChange={ allFields => {
        setFields(allFields);
        let _obj = updateTagVariableViaSettingsRules({
          _r: productPricingSettings?.product_pricing_custom_tag_price_rules,
          _r_total: productPricingSettings?.product_pricing_total_price_recipe,
        }, allFields);

        // console.log(_obj.tags['@{MIX(JacketType:Number)}']());
        // console.log(_obj.tags['@{BaseCost}'](), _obj.tags['@{JacketsCost}'](), `Total: ${ _obj.total() }`);
        setTotal(_obj.total())
      } } 
      fields={ fields } />
    <TotalPriceContainer>
      Total: { total }
    </TotalPriceContainer>
  </Fragment>
}