import React, { useState, useEffect, Fragment } from "react";
import styled from "styled-components";
import { Form, Input, Select} from "antd";
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';

const { Option } = Select;

const CustomerPricingFormContainer = styled.div``
const FormInnerContainer = styled.div`
  display: flex;
  flex-wrap: wrap; 
  justify-content: space-between;

  > * {
    width: calc(50% - 15px)
  }
`

export default function CustomerPricingForm({ onChange, fields }) {
  const { customerPricingFields } = useProductPricing();
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  const onFinish = (values) => {
    console.log(values);
  }
  
  return <CustomerPricingFormContainer>
    <Form
      form={ form }
      layout={ 'vertical' }
      name={ 'customer_pricing_data' }
      onFinish={ onFinish }
      onValuesChange={ (changedValues, allValues) => { onChange(allValues)} }>
      <FormInnerContainer>
        {
          Object.keys(customerPricingFields).length > 0 && 
          map(customerPricingFields, (item, key) => {
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
  </CustomerPricingFormContainer>
}

