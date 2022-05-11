import React, { Fragment, useState, useEffect } from "react";
import styled from "styled-components";
import { useProductPricing } from "../admin/lib/context/ProductPricingContext";
import { Tooltip } from 'antd';
import { PlusOutlined } from '@ant-design/icons'
import { __ } from '@wordpress/i18n';
import { Record } from './PreviewImage';

const VariablesContainer = styled.div`
  margin-bottom: 2em;

  ul {
    margin: 0;
    padding: 0;
    display: flex;
    flex-wrap: wrap;

    li {
      list-style: none;
      margin-right: 10px;
      margin-bottom: 10px;
    }
  }
`;
const VariableItem = styled.div`
  width: 70px;
  height: 70px;
  border-radius: 70px;
  overflow: hidden;
  background: ${ props => props.background || '#eee' };
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: .3s ease;
  -webkit-transition: .3s ease;
  box-shadow: ${ props => props.active ? '2px 6px 14px -3px rgb(0 0 0 / 50%)' : 'none' };
  
  .round-center {
    background: white;
    width: 24px;
    height: 24px;
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;

    > * {
      display: none;
    }
  }

  &:hover {

    .round-center > * {
      display: block;
    }
  }
`;

export default function VariablesPlace({ onChange }) {
  const [space, setSpace] = useState(6);
  const { variables, currentVariable } = useProductPricing();

  return <VariablesContainer>
    <ul>
      {
        [...Array(space).keys()].map((n) => {
          let _active = (currentVariable == n ? true : false);
          // console.log(n, variables[n]);
          return <li key={ n }>
            {
              variables[n] 
                ? <Tooltip title={ variables[n].colour } placement="bottom" >
                    <VariableItem active={ _active } background={ variables[n].colour } onClick={ () => { onChange(n) } }>
                      {/* <span className="round-center"></span> */}
                      <Record 
                        style={ variables[n].style } 
                        colour={ variables[n].colour } 
                        colour2={ variables[n].colour_1_2 } 
                        useSplatter={ variables[n].splatter }
                        splatterName={ variables[n].splatter_image } 
                        colourInColour={ variables[n].colour_in_colour } />
                    </VariableItem>
                  </Tooltip>
                : <Tooltip title={ __('Add variant', 'clampdown-child') } placement="bottom" >
                    <VariableItem active={ _active } onClick={ () => { onChange(n) } }>
                      <span className="round-center">
                        <PlusOutlined />
                      </span>
                    </VariableItem>
                  </Tooltip>
              
            }
          </li>
        })
      }
    </ul>
  </VariablesContainer>
}