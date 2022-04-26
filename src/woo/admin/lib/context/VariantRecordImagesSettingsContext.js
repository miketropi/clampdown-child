import React, { createContext, useContext, useState, useEffect } from 'react';

const VariantRecordImagesSettingsContext = createContext();

const VariantRecordImagesSettingsProvider = ({ children }) => {
  const value = {};
  return <VariantRecordImagesSettingsContext.Provider value={ value }>
    { children }
  </VariantRecordImagesSettingsContext.Provider>
}

const useVariantRecordImagesSettings = () => {
  return useContext(VariantRecordImagesSettingsContext);
}

export { VariantRecordImagesSettingsProvider, useVariantRecordImagesSettings };