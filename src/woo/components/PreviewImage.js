import React, { Fragment } from 'react';
import PreviewImage from '../../../images/preview-image.png';
import styled from 'styled-components'; 

const PreviewImageContainer = styled.div`
  margin-bottom: 2em;
`

export default (props) => {
  return <PreviewImageContainer>
    <img src={PreviewImage } alt="#" />
  </PreviewImageContainer>
}