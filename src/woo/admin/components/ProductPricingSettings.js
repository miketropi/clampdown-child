import react, { useState, useEffect, Fragment } from 'react';
import { userProductPricingSettings } from '../lib/context/ProductPricingSettingsContext';
import ProductPricingSettingsForm from './PricingSettingsForm';

const { __ } = wp.i18n;

export default function ProductPricingSettings(props) {
  const { settings, setSettings, customerOptions } = userProductPricingSettings();
  
  return <Fragment>
    <ProductPricingSettingsForm 
      onChange={ (newFields) => {
        setSettings(newFields)
      } } 
      fields={ settings } 
    />
  </Fragment>
} 