import React, { Fragment, useEffect } from 'react'
import styled from 'styled-components';
import { Button } from 'antd';

const AddToCartContainer = styled(Button)`
  width: 100%;
  background: black !important;
  border: none;
  box-shadow: none;
  outline: none;
  color: white !important;
  padding: 1.5em;
  line-height: 0;
  height: auto;

  &:hover {
    background: black;
    opacity: .8;
  }
`

export default function ButtonAddToCart({ text, onClick, ...args }) {
  return <AddToCartContainer 
    style={{ width: '100%' }}
    size={ 'large' }
    onClick={ onClick }
    { ...args } >
    { text }
  </AddToCartContainer>
}