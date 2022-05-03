import React from 'react';
import styled from 'styled-components';
import { getRecordImage } from '../admin/lib/lib';

const PreviewImageContainer = styled.div`
  margin-bottom: 2em;
  display: flex;
`

const JacketCoverImageContainer = styled.div`
  width: 50%;
  padding-bottom: 50%;
  position: relative;
  background-color: black;
  background-image: ${ props => (props.coverimage ? `url(${ props.coverimage })` : 'none') };
  background-size: cover;
  background-position: center center;
  box-shadow: 0 0 10px 0 rgb(1 1 1 / 20%), 25px 0 0 0 #f5f5f5;
  z-index: 5;
`

const RecordImageContainer = styled.div`
  width: 50%;
  transform: translateX(-36%);
`

const RecordContainer = styled.div`
  position: relative;
  display: inline-block;
  height: 100%;
  z-index: 0;

  .record-image-main {
    height: 100%;
  }

  .record-image-2__shadow {
    position: absolute;
    left: 0;
    bottom: 0; 
    z-index: 3;
    width: 100%;
    height: 50%;
    background-size: 100%;
    background-position: bottom left;
    background-repeat: no-repeat;
  }
`

export const Record = ({ style, colour, colour2 }) => {
  const recordImage = getRecordImage(colour);
  const recordImage2 = getRecordImage(colour2);
  return <RecordContainer>
    {
      recordImage != false && 
      <img className="record-image-main" src={ recordImage } alt="#" />
    }
    {
      recordImage2 != false && 
      <div className="record-image-2__shadow" style={{ 'backgroundImage': `url(${ recordImage2 })` }}></div>
    }
  </RecordContainer>;
}

export default ({ variant, jacketcover, sides }) => {
  return <PreviewImageContainer>
    <JacketCoverImageContainer coverimage={ jacketcover } />
    {/* { JSON.stringify( variant ) } */}
    <RecordImageContainer>
      <Record colour={ variant?.colour } colour2={ variant.colour_1_2 } />
    </RecordImageContainer>
  </PreviewImageContainer>
}