import React, { createContext, useContext, useState, useEffect } from 'react';
import { STYLE_OPTS, COLOUR_OPTS } from '../../lib/variantFields';

const VariantRecordImagesSettingsContext = createContext();

const VariantRecordImagesSettingsProvider = ({ children }) => {
  const [fields, setFields] = useState({});

  const value = {
    fields, setFields,
    styleOpts: STYLE_OPTS.map(s => s.value),
    colourOpts: COLOUR_OPTS.map(c => c.value),
  };
  return <VariantRecordImagesSettingsContext.Provider value={ value }>
    {/* { JSON.stringify(value) } */}
    { children }
  </VariantRecordImagesSettingsContext.Provider>
}

const useVariantRecordImagesSettings = () => {
  return useContext(VariantRecordImagesSettingsContext);
}

export { VariantRecordImagesSettingsProvider, useVariantRecordImagesSettings };