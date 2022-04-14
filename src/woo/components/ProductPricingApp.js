import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { Alert, Button, Row, Col } from 'antd';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerGeneralPricingForm from './CustomerGeneralPricingForm';
import CustomerPricingForm from './CustomerPricingForm';
import VariablesPlace from './VariablesSpace';
import ButtonAddToCart from './ButtonAddToCart';
import PreviewImage from './PreviewImage';
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

  const [sendRequest, setSendRequest] = useState(false);
  const [sendRequestMessage, setSendRequestMessage] = useState({type: 'info', message: '', action: ''});

  if(loading == true) {
    return <Fragment>{ __('Loading...', 'clampdown-child') }</Fragment>
  }

  const AddToCartClickHandle = async (e) => {
    e.preventDefault();
    let newSendRequestMessage = { ...sendRequestMessage };
    let product_id = parseInt(productID);
    
    // Button loading start
    setSendRequest(true);

    const result = await jQuery.ajax({
      type: 'POST',
      url: `${ CLAMPDOWN_PHP_WOO_DATA.site_url }/?wc-ajax=yith_ywraq_action`,
      data: {
        'quantity': 1,
        'context': 'frontend',
        'action': 'yith_ywraq_action',
        'ywraq_action': 'add_item',
        product_id,
        wp_nonce,
        'yith-add-to-cart': product_id,
        pricing_data: { ...generalOptions, variables: [...variables] },
        pricing_total: total,
      },
      error: (e) => {
        console.log(e)
      }
    });

    // Button loading remove
    setSendRequest(false);

    {
      if(result.result == 'exists') {
        newSendRequestMessage.type = 'warning';
        newSendRequestMessage.message = <Fragment>{ __('This product is already in your quote request list. Remove this product on request list after add a new request. Thank you!', 'clampdown-child') }</Fragment>
        newSendRequestMessage.action = <Button type="primary" target="_blank" href={ result.rqa_url }>{ __('Go to Request List', 'clampdown-child') }</Button>
      } else {

        newSendRequestMessage.type = 'success';
        newSendRequestMessage.message = <Fragment>{ __('Product added to the list. Thank you!', 'clampdown-child') }</Fragment>
        newSendRequestMessage.action = <Button type="primary" target="_blank" href={ result.rqa_url }>{ __('Go to Request List', 'clampdown-child') }</Button>
      }
  
      setSendRequestMessage(newSendRequestMessage);

      // redirect to request quote page Success
      if(newSendRequestMessage.type == 'success')
        window.location.href = result.rqa_url;
    }

    console.log(result);
  }

  return <Fragment>
    <Row gutter={40}>
      <Col md={16}>
        <PreviewImage />
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
      </Col>
      <Col md={8}>
        <CustomerGeneralPricingForm 
          onChange={ (allFields) => { setGeneralOptions(allFields); } } 
          fields={ generalOptions }/>

        {
          (sendRequestMessage.message != '') && 
          <Fragment>
            <Alert
              message={ __('Request a Quote', 'clampdown-child') }
              description={ sendRequestMessage.message }
              type={ sendRequestMessage.type }
              action={ sendRequestMessage.action }
              showIcon
              closable
              onClose={ () => {
                let newSendRequestMessage = { ...sendRequestMessage };
                newSendRequestMessage.message = '';
                setSendRequestMessage(newSendRequestMessage);
              } }
            />
            <br />
          </Fragment>
        }
        <ButtonAddToCart  
          text={ __(`Request Quote ($${ total })`, 'clampdown-child') }
          loading={ sendRequest }
          onClick={ AddToCartClickHandle } />
      </Col>
    </Row>
  </Fragment>
}