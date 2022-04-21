import React from 'react';
import { Select, Input } from 'antd';
import { __ } from '@wordpress/i18n';

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
            if(typeof(o) === 'object') {
              const { label, value, disable } = o;
              // console.log(o);
              return <Option value={ value } key={ _index } disabled={ disable }>{ label }</Option>
            } else {
              return <Option value={ o } key={ _index }>{ o }</Option>
            }
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