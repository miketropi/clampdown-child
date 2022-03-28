import React from 'react';
import styled from 'styled-components';
import { Select, Input } from 'antd';
import map from 'lodash/map';

const { __ } = wp.i18n;
const { Option } = Select;

export default function DynamicField(props) {
  const { _type, _attrs, _more } = props;
  let output = null;

  switch(_type) {
    case 'select':
      output = <Select { ...props } { ..._attrs }>
        {
          _more.options &&
          _more.options.map((o, _index) => {
            return <Option value={ o } key={ _index }>{ o }</Option>
          })
        }
      </Select>
      break;
    
    default: 
      output = <Input { ...props } { ..._attrs } style={{ borderRadius: '1px' }}/>
      break;
  }

  return output;
}