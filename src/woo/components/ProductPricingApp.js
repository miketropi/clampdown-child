import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerPricingForm from './CustomerPricingForm';

export default function ProductPricingApp() {
  const { version, fields, setFields, loading } = useProductPricing();

  useEffect(() => {

  }, [])

  if(loading == true) {
    return <Fragment>Loading...</Fragment>
  }

  return <Fragment>
    <CustomerPricingForm 
      onChange={ allFields => {
        setFields(allFields);
      } } 
      fields={ fields } />
  </Fragment>
}