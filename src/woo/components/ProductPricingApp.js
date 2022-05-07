import react, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { Alert, Button, Row, Col } from 'antd';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import CustomerGeneralPricingForm from './CustomerGeneralPricingForm';
import CustomerPricingForm from './CustomerPricingForm';
import VariablesPlace from './VariablesSpace';
import ButtonAddToCart from './ButtonAddToCart';
import PreviewImage from './PreviewImage';
import QuoteSummary from './QuoteSummary';
import { __ } from '@wordpress/i18n';

export default function ProductPricingApp() {
  const { 
    productID, wp_nonce, 
    generalOptions, setGeneralOptions,
    productExtraData, 
    variables, setVariables,
    currentVariable, 
    loading, 
    productPricingSettings, 
    updateTagVariableViaSettingsRules, 
    onChangeVariablePlace, 
    total } = useProductPricing();

  const [sendRequest, setSendRequest] = useState(false);
  const [sendRequestMessage, setSendRequestMessage] = useState({type: 'info', message: '', action: ''});
  const [styleWarningMessageShow, setStyleWarningMessageShow] = useState(false);

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
        newSendRequestMessage.message = <Fragment>{ __('This product is already in your quote request list. Remove this product on request list before add a new request. Thank you!', 'clampdown-child') }</Fragment>
        newSendRequestMessage.action = <Button type="primary" target="_blank" href={ result.rqa_url }>{ __('Go to Request List', 'clampdown-child') }</Button>
      } else {
        newSendRequestMessage.type = 'success';
        newSendRequestMessage.message = <Fragment>{ __('Product added to the list. Thank you!', 'clampdown-child') }</Fragment>
        newSendRequestMessage.action = <Button type="primary" target="_blank" href={ result.rqa_url }>{ __('Go to Request List', 'clampdown-child') }</Button>
      }
  
      setSendRequestMessage(newSendRequestMessage);

      // redirect to request quote page Success
      if(newSendRequestMessage.type == 'success') {
        window.location.href = result.rqa_url;
      } 
      
      document.scrollingElement.scrollTop = 0;
    }

    console.log(result);
  }

  const styleWarningMessageShow_func = (variantFields) => {
    let { sides } = generalOptions;
    let { style, style2, style3 } = variantFields;

    if(['Smash', 'Clash'].includes(style)) {
      setStyleWarningMessageShow(true);
      return;
    }

    if([4, 6].includes(sides) && ['Smash', 'Clash'].includes(style2)) {
      setStyleWarningMessageShow(true);
      return;
    }

    if([6].includes(sides) && ['Smash', 'Clash'].includes(style3)) {
      setStyleWarningMessageShow(true);
      return;
    }

    setStyleWarningMessageShow(false);
  }

  return <Fragment>
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

    <Row gutter={40}>
      <Col md={16} sm={24} xs={24}>
        <PreviewImage 
          variant={ variables[currentVariable] } 
          jacketcover={ productExtraData?.product_thumbnail_url }
          sides={ generalOptions?.sides } />
        
        {
          styleWarningMessageShow == true &&
          <Alert
            message="Warning"
            description={ __('These images are here for reference only. Colours will appear differently on different screens. We\'ve got lots of colours and can mix to your requirements.', 'clampdown-child') }
            type="warning"
            showIcon
            closable
            style={{ marginBottom: '3em' }}
          />
        }

        <VariablesPlace onChange={ onChangeVariablePlace } />
        
        <CustomerPricingForm 
          onChange={ allFields => {
            let _variables = [...variables];
            _variables[currentVariable] = allFields;

            let _obj = updateTagVariableViaSettingsRules(productPricingSettings, { ...generalOptions, ...allFields });
            _variables[currentVariable].__TOTAL__ = _obj.eachVariantTotal();

            setVariables(_variables);
            styleWarningMessageShow_func(allFields);
          } } 
          fields={ variables[currentVariable] } />
      </Col>
      <Col md={8} sm={24} xs={24}>
        <CustomerGeneralPricingForm 
          onChange={ (allFields) => { setGeneralOptions(allFields); } } 
          fields={ generalOptions }/>

        {
          productPricingSettings?.product_pricing_summary_fields &&
          productPricingSettings?.product_pricing_summary_fields?.length > 0 && 
          <QuoteSummary />
        }

        <ButtonAddToCart  
          text={ __(`Request Quote`, 'clampdown-child') }
          loading={ sendRequest }
          onClick={ AddToCartClickHandle } />
      </Col>
    </Row>
  </Fragment>
}