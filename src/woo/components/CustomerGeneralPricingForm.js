import React, { Fragment, useState, useEffect } from 'react';
import { Form, Select} from 'antd';
import styled from 'styled-components';
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';

const { __ } = wp.i18n;
const { Option } = Select;

const FormInnerContainer = styled.div`
  display: flex;
  flex-wrap: wrap; 
  justify-content: space-between;

  > * {
    width: calc(50% - 15px)
  }
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
            return <Form.Item 
              label={ item.label }
              name={ item.name } 
              key={ key }>
              <Select>
                {
                  item.options.length > 0 && 
                  map(item.options, (o, index) => <Option value={ o } key={ index }>{ o }</Option>)
                }
              </Select>
            </Form.Item>
          })
        }
      </FormInnerContainer>
    </Form>
  </Fragment>
}