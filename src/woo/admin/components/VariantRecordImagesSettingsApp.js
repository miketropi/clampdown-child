import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import { PageHeader, Button } from 'antd';
import { __ } from '@wordpress/i18n';
import VariantRecordImagesSettingsForm from './VariantRecordImagesSettingsForm';
import { useVariantRecordImagesSettings } from '../lib/context/VariantRecordImagesSettingsContext';

const VariantRecordImagesSettingsContainer = styled.div`
  width: 880px;
  max-width: calc(100% - 20px);
  margin: 3em auto;
  padding: 3em;
  background: white;
  border: solid 1px #eee;

  .ant-page-header {
    border: solid 1px #eee;
  }
`

export default () => {
  const { fields, setFields } = useVariantRecordImagesSettings();
  const onChange = (newFields) => {
    setFields(...newFields)
  }

  return <VariantRecordImagesSettingsContainer>
    <PageHeader
      className="site-page-header"
      onBack={() => {
        let r = confirm(__('Back to dashboard?', 'clampdown-child'));
        if(r) { window.location.href = '/admin'; }
      }}
      title={ __('Record Images Settings 💿', 'clampdown-child') }
      extra={ [
        <Button type="primary" key="action_save">{ __('Save', 'clampdown-child') }</Button>
      ] }
    />
    <VariantRecordImagesSettingsForm onChange={ onChange } fields={ fields } />
  </VariantRecordImagesSettingsContainer>
}