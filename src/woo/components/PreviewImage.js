import React, { useState } from 'react';
import styled from 'styled-components';
import { getRecordImage, getSplatterImage, getColourInColourImage } from '../admin/lib/lib';
import { Image } from 'antd';

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
  -webkit-transform: translateX(-36%);
  user-select: none;
  -webkit-user-select: none;

  > *:first-child {
    z-index: 3;
  }

  > *:not(first-child) {
    position: absolute;
    left: 0;
    top: 0;
  }

  > *:nth-child(2) {
    transform: translateX(12%);
    -webkit-transform: translateX(12%);
    z-index: 2;
  }

  > *:nth-child(3) {
    transform: translateX(22%);
    -webkit-transform: translateX(22%);
    z-index: 1;
  }
`

const RecordContainer = styled.div`
  position: relative;
  display: inline-block;
  height: 100%;
  z-index: 0;
  box-shadow: 7px 7px 9px -5px rgb(1 1 1 / 30%);
  border-radius: 100%;

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

    &.__style-Color-In-Color {
      height: 100%;
    }
  }

  .record-splatter-image {
    position: absolute;
    left: 0;
    top: 0;
    z-index: 4;
    width: 100%;
    height: 100%;
    background-size: 100%;
    background-position: bottom left;
    background-repeat: no-repeat;
  }
`

export const Record = ({ style, colour, colour2, useSplatter, splatterName, colourInColour }) => {
  let recordImage = getRecordImage(colour);
  let recordImage2 = getRecordImage(colour2);
  let splatterImage = getSplatterImage(splatterName);
  let colourInColourImage = getColourInColourImage(colourInColour);

  if(style === 'Standard Black') {
    recordImage = getRecordImage('Black');
    recordImage2 = false;
  }

  if(style === 'Colour') {
    recordImage2 = false;
  } else if(style === 'Smash') {
    recordImage = getRecordImage('Smash');
    recordImage2 = false;
  } else if(style === 'Clash') {
    recordImage = getRecordImage('Clash');
    recordImage2 = false;
  } else if(style === 'Color In Color') {
    recordImage2 = colourInColourImage;
  }

  return <RecordContainer>
    {
      recordImage != false && 
      <img className="record-image-main" src={ recordImage } alt="#" />
    }
    {
      recordImage2 != false && 
      <div className={ ['record-image-2__shadow', `__style-${ style.split(' ').join('-') }`].join(' ') } style={{ 'backgroundImage': `url(${ recordImage2 })` }}></div>
    }
    {
      useSplatter === 'yes' &&
      splatterImage !== false &&
      <div className="record-splatter-image"  style={{ 'backgroundImage': `url(${ splatterImage })` }}></div>
    }
  </RecordContainer>;
}

export default ({ variant, jacketcover, sides }) => {
  return <PreviewImageContainer>
    <JacketCoverImageContainer coverimage={ jacketcover } />
    <RecordImageContainer>
      <Record 
        style={ variant?.style } 
        colour={ variant?.colour } 
        colour2={ variant.colour_1_2 } 
        useSplatter={ variant.splatter }
        splatterName={ variant.splatter_image }
        colourInColour={ variant.colour_in_colour } />
      {
        ([4, 6].includes(sides)) && 
        <Record 
          style={ variant?.style2 } 
          colour={ variant?.colour2 } 
          colour2={ variant.colour_2_2 } 
          useSplatter={ variant.splatter2 }
          splatterName={ variant.splatter_image2 }
          colourInColour={ variant.colour_in_colour2 } />
      }
      {
        (sides === 6) && 
        <Record 
          style={ variant?.style3 } 
          colour={ variant?.colour3 } 
          colour2={ variant.colour_3_2 } 
          useSplatter={ variant.splatter3 }
          splatterName={ variant.splatter_image3 }
          colourInColour={ variant.colour_in_colour3 } />
      }
    </RecordImageContainer>
  </PreviewImageContainer>
}