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

export default function CustomerGeneralPricingForm({ onChange, fields }) { 
  const { generalCustomerPricingFields, generalOptions } = useProductPricing();
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
      <FormInnerContainer>
        {
          Object.keys(generalCustomerPricingFields).length > 0 && 
          map(generalCustomerPricingFields, (item, key) => {
            const { name, label, type, conditional } = item;
            const attrs = {};
            const more = {};
            const _show = (typeof conditional === 'undefined') ? true : isConditional(conditional, { ...generalOptions, ...fields });      

            if(item.options) {
              more.options = item.options;
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