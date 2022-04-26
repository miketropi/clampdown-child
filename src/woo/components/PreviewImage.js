import React, { Fragment } from 'react';
import PreviewImage from '../../../images/preview-image.png';
import styled from 'styled-components'; 

const PreviewImageContainer = styled.div`
  margin-bottom: 2em;
`

const JacketCoverImageContainer = styled.div`
  width: 50%;
  padding-bottom: 50%;
  position: relative;
  background-color: black;
  background-image: ${ props => (props.coverimage ? `url(${ props.coverimage })` : 'none') };
  background-size: cover;
  box-shadow: 0 0 10px 0 rgb(1 1 1 / 20%), 25px 0 0 0 #f5f5f5;
`

const RecordContainer = styled.div``

export const Record = ({ style, colour }) => {
  return <RecordContainer>

  </RecordContainer>;
}

export default ({ variant, jacketcover, sides }) => {
  return <PreviewImageContainer>
    <JacketCoverImageContainer coverimage={ jacketcover } />
    {/* <img src={PreviewImage } alt="#" /> */}
  </PreviewImageContainer>
}