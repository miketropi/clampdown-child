/**
 * Woo backend scripts
 * 
 */
import react from 'react'; 
import reactDOM from 'react-dom';
import { VariantRecordImagesSettingsProvider } from './lib/context/VariantRecordImagesSettingsContext';
import VariantRecordImagesSettingsApp from './components/VariantRecordImagesSettingsApp';

;((w, $) => {
  const Ready = () => {
    const App = document.getElementById('VARIANT_RECORD_IMAGES_SETTINGS');
    if(!App) return;
    reactDOM.render(<VariantRecordImagesSettingsProvider>
      <VariantRecordImagesSettingsApp />
    </VariantRecordImagesSettingsProvider>, App);
  }
  $(Ready)
})(window, jQuery); 
