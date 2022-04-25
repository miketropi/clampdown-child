import React, { useEffect } from "react";
import styled from "styled-components";
import { Form, Input, Select, Divider } from "antd";
import { useProductPricing } from '../admin/lib/context/ProductPricingContext';
import map from 'lodash/map';
import DynamicField from "../admin/components/fields/DynamicField";
import { isConditional } from "../admin/lib/lib";

const { Option } = Select;

const CustomerPricingFormContainer = styled.div`
  .ant-divider-horizontal.ant-divider-with-text::before, 
  .ant-divider-horizontal.ant-divider-with-text::after {
    transform: none;
  }
`
const FormInnerContainer = styled.div`
  display: flex;
  flex-wrap: wrap; 
  justify-content: space-between;

  > * {
    width: calc(33% - 15px)
  }
`

export default function CustomerPricingForm({ onChange, fields }) {
  const { generalOptions, customerPricingFields, variables } = useProductPricing();
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  const onFinish = (values) => {
    console.log(values);
  }
  
  return <CustomerPricingFormContainer>
    {/* { JSON.stringify(fields) } */}
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
            const { name, label, type, conditional, extra } = item;
            const attrs = {};
            const more = {};
            const _show = (typeof conditional === 'undefined') ? true : isConditional(conditional, {...generalOptions, ...fields});           

            if(item.options) {
              more.options = item.options;
            }

            if(type === 'divider') {
              let label = extra?.frontendDividerLabel;
              // console.log(label);
              if(!label) {
                return <Divider orientation="left" key={ name } style={{ display: _show ? '' : 'none' }} plain></Divider>
              }

              return <Divider orientation="left" key={ name } style={{ display: _show ? '' : 'none' }} plain>{ label != '' && <strong style={{ color: 'rgb(213, 32, 139)' }}>{ label }</strong> }</Divider>
            }

            return <Form.Item 
              // label={ label }
              name={ name } 
              key={ key }
              hidden={ ((type == 'hidden' || !_show) ? true : false) } >
              <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
            </Form.Item>
          })
        }
      </FormInnerContainer>
    </Form>
  </CustomerPricingFormContainer>
}

