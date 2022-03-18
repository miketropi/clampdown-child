/**
 * Product Pricing Settings Form 
 */
import react, { Fragment, useState, useEffect } from 'react'
import { Form, Button, PageHeader, Switch, Tag, Divider, Input, Select, Space, Mentions, Collapse } from 'antd';
import { SlidersOutlined, MinusCircleOutlined, PlusOutlined } from '@ant-design/icons';
import CustomerOptionsListView from './CustomerOptionsListView';
import { userProductPricingSettings } from '../lib/context/ProductPricingSettingsContext';
import find from 'lodash/find';
import map from 'lodash/map';
import styled from 'styled-components';

const { __ } = wp.i18n; 
const { Option } = Select;
const { Panel } = Collapse;

const RuleItemContainer = styled.fieldset`
  display: flex;
  flex-wrap: wrap;
  align-items: center; 
  padding: 2em;
  margin-bottom: 2em;
  border: solid 1px #eee;

  legend {
    width: auto;
    padding: 0 1em;
    margin: 0;
    color: black;
    border-bottom: 0;
    font-size: 1em;
    font-weight: bold;
  }

  > * {
    width: 100%
  }
`

export default function ProductPricingSettingsForm({ onChange, fields }) {
  const { customerOptions } = userProductPricingSettings();
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  return <Fragment>
    {/* { JSON.stringify(fields) } */}
    <Form
      name="product_pricing_settings"
      form={ form }
      layout={ 'vertical' }
      onValuesChange={ (changedValues, allValues) => {
        onChange(allValues);
      } } >
      <PageHeader
        className="site-page-header"
        title={ __('Product Pricing Settings', 'clampdown-child') }
        avatar={ { icon: <SlidersOutlined /> } }
        tags={ <Tag color="blue">{ __('Advanced', 'clampdown-child') }</Tag> }
        extra={[
          <Button type="primary" htmlType="submit">
            { __('Update', 'clampdown-child') }
          </Button>
        ]}
      >
        <hr />
        <Form.Item 
          label={ __('Enable Pricing Mode', 'clampdown-child') } 
          name="enable_pricing_mode"
          valuePropName="checked">
          <Switch defaultChecked />
        </Form.Item>

        {/* <Divider orientation="left">{ __('Customer Options', 'clampdown-child') }</Divider>
        <CustomerOptionsListView options={ customerOptions } />

        <br /> */}
        <Divider orientation="left">{ __('Rules Custom Price', 'clampdown-child') }</Divider>
        <Form.List
          name="product_pricing_custom_price_rules" >
          { (_fields, { add, remove }) => (
            <Fragment>
              <Collapse>
                {
                  _fields.map(({ key, name, ...restField }) => {
                    return <Panel 
                      key={ key } 
                      header={ fields.product_pricing_custom_price_rules[name]?.name } >
                      <Form.Item
                        {...restField} 
                        label="Name" 
                        name={[name, 'name']} 
                        required={ true } >
                        <Input style={{ borderRadius: 1 }} />
                      </Form.Item>
                      <Form.Item 
                        {...restField}
                        label="Field Type"
                        name={[name, 'field_type']}
                        required={ true } >
                        <Select 
                          style={{ width: '100%' }} >
                          {
                            Object.values(customerOptions).map(o => (
                              <Option key={ o.name } value={ o.name }>{ o.label }</Option>
                            ))
                          }
                          <Option value="triggerAllFields">Trigger All Fields</Option>
                        </Select>
                      </Form.Item>
                      <Form.Item
                        noStyle
                        shouldUpdate={ (prevValues, curValues) => {
                          return prevValues.product_pricing_custom_price_rules[name]?.field_type != curValues.product_pricing_custom_price_rules[name]?.field_type;
                        } }>
                        {
                          () => {
                            const _item = find(customerOptions, (item) => { 
                              return item.name == fields?.product_pricing_custom_price_rules[name]?.field_type }
                            );
                            return <Fragment>
                              {
                                _item != null &&
                                <Fragment>
                                  <Form.Item
                                    { ...restField }
                                    label="Operator"
                                    name={[name, 'field_operator']}
                                    required={ true } >
                                    <Select>
                                      <Option value="==">Value is equal to</Option>
                                      <Option value="!=">Value is not equal to</Option>
                                    </Select>
                                  </Form.Item>
                                  <Form.Item 
                                    { ...restField }
                                    label="Value"
                                    name={[name, 'field_option']}
                                    required={ true } > 
                                    {
                                      _item != null && 
                                      <Select style={{ width: '100%' }}>
                                        {
                                          _item.options.map(o => <Option key={ o } value={ o }>{ o }</Option>)
                                        }
                                      </Select>
                                    }
                                  </Form.Item >
                                </Fragment>
                              }
                            </Fragment>
                          }
                        }
                      </Form.Item>
                      <Form.Item
                        { ...restField }
                        label={ __('Recipe', 'clampdown-child') }
                        name={ [name, 'recipe'] }
                        required={ true } >
                        <Mentions style={{ borderRadius: 1 }}>
                          {
                            map(customerOptions, (o, keyName) => {
                              return <Mentions.Option value={ `{${ o.name }}` }>
                                { o.label }
                              </Mentions.Option>
                            })
                          }
                        </Mentions>
                      </Form.Item>
                      <MinusCircleOutlined onClick={() => remove(name)} />
                    </Panel>
                  })
                }
              </Collapse>
              <Form.Item 
                style={{ marginTop: '2em' }}>
                <Button type="dashed" onClick={() => add()} block icon={<PlusOutlined />}>
                  Add rule
                </Button>
              </Form.Item>
            </Fragment>
          ) }
        </Form.List>
      </PageHeader>
    </Form>
  </Fragment> 
}