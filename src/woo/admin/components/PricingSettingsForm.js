/**
 * Product Pricing Settings Form 
 */
import react, { Fragment, useState, useEffect } from 'react'
import { Form, Button, PageHeader, Switch, Tag, Divider, Input, Select, Space, Mentions, Collapse, Tabs } from 'antd';
import { SlidersOutlined, MinusCircleOutlined, PlusOutlined } from '@ant-design/icons';
import CustomerOptionsListView from './CustomerOptionsListView';
import { userProductPricingSettings } from '../lib/context/ProductPricingSettingsContext';
import find from 'lodash/find';
import map from 'lodash/map';
import styled from 'styled-components';
import SwitchCustom from './fields/SwitchCustom';
import DynamicField from './fields/DynamicField';

const { __ } = wp.i18n; 
const { Option, OptGroup } = Select;
const { Panel } = Collapse;
const { TabPane } = Tabs;

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
  if(Object.keys(fields).length == 0) {
    return <Fragment>{ __('Loading...', 'clampdown-child') }</Fragment>
  }
  
  const { product, customerOptions, generalCustomerOptions, saveData, saveDataLoading } = userProductPricingSettings();
  const [priceTags, setPriceTags] = useState([]);
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  useEffect(() => {
    /**
     * Opt tags
     */
    let _priceTags = map(customerOptions, (o, keyName) => ({ value: `{${ o.name }}`, label: o.label, keyName }));
    let _globalPriceTags = map(generalCustomerOptions, (o, keyName) => ({ value: `{${ o.name }}`, label: o.label, keyName }));
    let newPriceTags = [..._priceTags, ..._globalPriceTags];
    
    /**
     * Rule tags
     */
    if(fields?.product_pricing_custom_tag_price_rules?.length > 0) {
      fields.product_pricing_custom_tag_price_rules.forEach(item => {
        if(!item?.name) return; 
        newPriceTags.push({ value: `{${ item?.name }}`, label: item?.name })
      })
    }

    /**
     * System Price tags  
     */
    newPriceTags.push({ value: '{MIX_JacketType_Number}', label: __('MIX_JacketType_Number') }),
    
    setPriceTags(newPriceTags);
  }, [fields]);

  const onFinish = (values) => {
    saveData(values);
  }

  const onFinishFailed = (errorInfo) => {
    console.log(errorInfo);
  }

  return <Fragment>
    { JSON.stringify(fields) }
    <Form
      name="product_pricing_settings"
      form={ form }
      layout={ 'vertical' }
      onFinish={ onFinish } 
      onFinishFailed={ onFinishFailed } 
      onValuesChange={ (changedValues, allValues) => {
        onChange(allValues);
      } } >
      <PageHeader
        className="site-page-header"
        title={ __('Product Pricing Settings', 'clampdown-child') }
        avatar={ { icon: <SlidersOutlined /> } }
        tags={ <Tag color="blue">{ __('Advanced', 'clampdown-child') }</Tag> }
        extra={[
          <Button type="primary" htmlType="submit" loading={ saveDataLoading }>
            { saveDataLoading == true ? __('Saving...', 'clampdown-child') : __('Update', 'clampdown-child') }
          </Button>
        ]}
      >
        <hr />
        <Form.Item 
          label={ __('Enable Pricing Mode', 'clampdown-child') } 
          name="enable_pricing_mode"
          valuePropName="checked">
          <SwitchCustom />
        </Form.Item>

        <Tabs defaultActiveKey={ 'default_options' } type="card">
          <TabPane tab={ __('Default Options', 'clampdown-child') } key={ 'default_options' } forceRender={ true }>
            <Divider orientation="left">{ __('General Options', 'clampdown-child') }</Divider>
            {
              generalCustomerOptions && 
              map(generalCustomerOptions, (item, key) => {
                const { name, label, type } = item;
                const attrs = {};
                const more = {};

                if(item.options) {
                  more.options = item.options;
                }

                return <Form.Item
                  key={ key }
                  label={ label }
                  name={ ['general_default_opts', name] } 
                  required={ true }>
                  <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
                </Form.Item>
              })
            }

            <Divider orientation="left">{ __('Variants Options', 'clampdown-child') }</Divider>
            {
              customerOptions && 
              map(customerOptions, (item, key) => {
                const { name, label, type } = item;
                const attrs = {};
                const more = {};

                if(item.options) {
                  more.options = item.options;
                }

                return <Form.Item
                  key={ key }
                  label={ label }
                  name={ ['variant_default_opts', name] } 
                  required={ true }>
                  <DynamicField _type={ type } _attrs={ attrs } _more={ more } />
                </Form.Item>
              })
            } 
          </TabPane>
          <TabPane tab={ __('Rule Tags', 'clampdown-child') } key={ 'rule_tags' } forceRender={ true }>
            <Divider orientation="left">{ __('Custom Tag Price Recipe', 'clampdown-child') }</Divider>
            <Form.List
              name="product_pricing_custom_tag_price_rules" >
              { (_fields, { add, remove }) => (
                <Fragment>
                  <Collapse>
                    {
                      _fields.map(({ key, name, ...restField }) => {
                        return <Panel 
                          key={ key } 
                          header={ fields.product_pricing_custom_tag_price_rules[name]?.name } 
                          extra={ <MinusCircleOutlined onClick={() => remove(name)} /> } >
                          <Form.Item
                            {...restField} 
                            label="Name" 
                            name={ [name, 'name'] } 
                            required={ true } >
                            <Input style={{ borderRadius: 1 }} />
                          </Form.Item>
                          <Form.Item 
                            {...restField}
                            label="Field Type"
                            name={ [name, 'field_type'] }
                            required={ true } >
                            <Select style={{ width: '100%' }} >
                              <OptGroup label={ __('System Options', 'clampdown-child') }>
                                <Option value="global">{ __('Global', 'clampdown-child') }</Option>
                              </OptGroup>
                              <OptGroup label={ __('General Options', 'clampdown-child') }>
                                {
                                  Object.values(generalCustomerOptions).map(o => (
                                    <Option key={ o.name } value={ o.name }>{ o.label }</Option>
                                  ))
                                }
                              </OptGroup>
                              <OptGroup label={ __('Customer Options', 'clampdown-child') }>
                                {
                                  Object.values(customerOptions).map(o => (
                                    <Option key={ o.name } value={ o.name }>{ o.label }</Option>
                                  ))
                                }
                              </OptGroup>
                            </Select>
                          </Form.Item>
                          <Form.Item
                            noStyle
                            shouldUpdate={ (prevValues, curValues) => {
                              return prevValues.product_pricing_custom_tag_price_rules[name]?.field_type != curValues.product_pricing_custom_tag_price_rules[name]?.field_type;
                            } }>
                            {
                              () => {
                                let _allOpts = { ...customerOptions, ...generalCustomerOptions };
                                const _item = find(_allOpts, (item) => { 
                                  return item.name == fields?.product_pricing_custom_tag_price_rules[name]?.field_type }
                                );
                                return <Fragment>
                                  {
                                    _item != null &&
                                    <Fragment>
                                      <Form.Item
                                        { ...restField }
                                        label="Operator"
                                        name={ [name, 'field_operator'] }
                                        required={ true } >
                                        <Select>
                                          <Option value="==">{ __('Value is equal to', 'clampdown-child') }</Option>
                                          <Option value="!=">{ __('Value is not equal to', 'clampdown-child') }</Option>
                                        </Select>
                                      </Form.Item>
                                      <Form.Item 
                                        { ...restField }
                                        label="Value"
                                        name={ [name, 'field_option'] }
                                        required={ true } >
                                        {
                                          (() => {
                                            if(_item != null && _item?.options) {
                                              return <Select style={{ width: '100%' }}>
                                                {
                                                  _item.options.map(o => <Option key={ o } value={ o }>{ o }</Option>)
                                                }
                                              </Select>
                                            } else {
                                              return <Input style={{ borderRadius: '1px' }} />
                                            }
                                          })()
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
                            <Mentions split={ '' } style={{ borderRadius: 1 }}>
                              {
                                priceTags.length > 0 && 
                                priceTags.map(item => (
                                  <Mentions.Option value={ item.value }>{ item.label }</Mentions.Option>
                                )) 
                              }
                            </Mentions>
                          </Form.Item>
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

            <Divider orientation="left">{ __('Total Price', 'clampdown-child') }</Divider>
            <Form.Item
              label={ __('Total Price Recipe', 'clampdown-child') } 
              required={ true }
              name="product_pricing_total_price_recipe" >
              <Mentions split={ '' } style={{ borderRadius: 1 }}>
                {
                  priceTags.length > 0 && 
                  priceTags.map(item => (
                    <Mentions.Option value={ item.value }>{ item.label }</Mentions.Option>
                  )) 
                }
              </Mentions>
            </Form.Item>
          </TabPane>
        </Tabs>

        
      </PageHeader>
    </Form>
  </Fragment> 
}