import React, { Fragment, useState, useEffect } from 'react';
import styled from 'styled-components';
import { Form, Divider, Collapse, Button, Input, Mentions } from 'antd';
import { PlusOutlined } from '@ant-design/icons';
import { MentionsGeneralOptions, MentionsSummaryOptions } from '../lib/mentionsOptions';
import { userProductPricingSettings } from '../lib/context/ProductPricingSettingsContext';
import map from 'lodash/map';
import ActionRuleItem from './ActionRuleItem';
import { __ } from '@wordpress/i18n';

const { Panel } = Collapse;

export default ({ fields }) => {
  const { generalCustomerOptions } = userProductPricingSettings();

  return <Fragment>
    <Divider orientation="left">{ __('Register Summary Fields', 'clampdown-child') }</Divider>
    <Form.List
      name="product_pricing_summary_fields" >
      { (_fields, { add, remove }) => (
        <Fragment>
          <Collapse>
          {
            _fields.map(({ key, name, ...restField }) => {
              let item = fields?.product_pricing_summary_fields[name];
              let headerText = item?.label || '';
              return <Panel
                key={ key } 
                header={ `${ headerText }` } 
                extra={ <ActionRuleItem index={ key } name={ name } actions={ { add, remove } } /> } 
                >
                <Form.Item
                  { ...restField }
                  label="Label"
                  name={ [name, 'label'] }
                  required={ true } >
                  <Input style={{ borderRadius: '1px' }} />
                </Form.Item>
                <Form.Item
                  { ...restField }
                  label="Value"
                  name={ [name, 'value'] }
                  required={ true } >
                  <Mentions>
                    {
                      map(generalCustomerOptions, (item, key) => {
                        const { label, name } = item;
                        return <Mentions.Option value={ `{${ name }}` } key={ key }>{ label }</Mentions.Option>
                      })
                    }
                    {
                      fields?.product_pricing_custom_tag_price_total_rules?.length > 0 && 
                      fields?.product_pricing_custom_tag_price_total_rules.map((_r, _index) => {
                        if(_r?.name) {
                          return <Mentions.Option value={ `{${ _r.name }}` } key={ `${ _index }_mentions_total` }>{ _r.name }</Mentions.Option>
                        }
                      })
                    }
                    {
                      map(MentionsSummaryOptions, (label, value) => {
                        return <Mentions.Option value={ value } key={ value }>{ label }</Mentions.Option>
                      })
                    }
                    {
                      map(MentionsGeneralOptions, (label, value) => {
                        return <Mentions.Option value={ value } key={ value }>{ label }</Mentions.Option>
                      })
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
              { __('Add Item', 'clampdown-child') }
            </Button>
          </Form.Item>
        </Fragment>
      ) }
    </Form.List>
  </Fragment>
}