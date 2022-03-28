import React, { useEffect } from "react";
import styled from "styled-components";
import { Form, Input, Select} from "antd";
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';
import DynamicField from "../admin/components/fields/DynamicField";

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
  const { customerPricingFields, variables } = useProductPricing();
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  const onFinish = (values) => {
    console.log(values);
  }
  
  return <CustomerPricingFormContainer>
    {/* { JSON.stringify(variables) } */}
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
            const { name, label, type } = item;
            const attrs = {};
            const more = {};
            if(item.options) {
              more.options = item.options;
            }

            return <Form.Item 
              label={ label }
              name={ name } 
              key={ key }
              hidden={ (type == 'hidden' ? true : false) } >
              <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
            </Form.Item>
          })
        }
      </FormInnerContainer>
    </Form>
  </CustomerPricingFormContainer>
}

