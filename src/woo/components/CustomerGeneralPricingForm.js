import React, { Fragment, useEffect } from 'react';
import { Form } from 'antd';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';
import DynamicField from '../admin/components/fields/DynamicField';
import { isConditional } from '../admin/lib/lib';
import { __ } from '@wordpress/i18n';

const FormInnerContainer = styled.div`
  
`

const SizeTitleStyle = styled.h2`
  font-weight: bold;
  font-size: 2.4em;
  color: black;

  small {
    font-size: .6em;
    color: #d5208b;
  }
`

export default function CustomerGeneralPricingForm({ onChange, fields }) { 
  const { generalCustomerPricingFields, generalOptions, currentVariable } = useProductPricing();
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  return <Fragment>
    {/* { JSON.stringify(fields) } */}
    <Form 
      form={ form }
      layout={ 'vertical' }
      name={ 'customer_general_pricing_data' }
      onValuesChange={ (changedValues, allValues) => { onChange(allValues) } }>
      <SizeTitleStyle>{ fields?.size }" VINYL <small> VARIANT #{ currentVariable + 1 }</small></SizeTitleStyle>
      <FormInnerContainer>
        {
          Object.keys(generalCustomerPricingFields).length > 0 && 
          map(generalCustomerPricingFields, (item, key) => {
            const { name, label, type, conditional, extra } = item;
            const attrs = {};
            const more = {};
            let _show = (typeof conditional === 'undefined') ? true : isConditional(conditional, { ...generalOptions, ...fields });      

            if(item.options) {
              if(fields?.size == '7') {
                item.options.map(item => {
                  if([0, 4, 6].includes(item.value)) {
                    item.disable = true;
                  }
                  return item;
                })
              }

              more.options = item.options;
            }

            if(extra && (extra?.hiddenFrontend == true)) {
              _show = false;
            }

            return <Form.Item 
              name={ name } 
              key={ key }
              hidden={ ((type == 'hidden' || !_show) ? true : false) } >
              <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
            </Form.Item>
          })
        }
      </FormInnerContainer>
    </Form>
  </Fragment>
}