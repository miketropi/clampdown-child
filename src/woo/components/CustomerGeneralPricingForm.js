import React, { Fragment, useEffect } from 'react';
import { Form, Select } from 'antd';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';
import DynamicField from '../admin/components/fields/DynamicField';
import { __ } from '@wordpress/i18n';

const { Option } = Select;
const FormInnerContainer = styled.div`
  
`

export default function CustomerGeneralPricingForm({ onChange, fields }) { 
  const { generalCustomerPricingFields } = useProductPricing();
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
      onValuesChange={ (changedValues, allValues) => { onChange(allValues)} }>
      <FormInnerContainer>
        {
          Object.keys(generalCustomerPricingFields).length > 0 && 
          map(generalCustomerPricingFields, (item, key) => {
            const { name, label, type } = item;
            const attrs = {};
            const more = {};

            if(item.options) {
              more.options = item.options;
            }

            return <Form.Item 
              // label={ label }
              name={ name } 
              key={ key }
              hidden={ (type == 'hidden' ? true : false) } >
              <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
            </Form.Item>
          })
        }
      </FormInnerContainer>
    </Form>
  </Fragment>
}