/**
 * Request
 */

export const request = async (action, data, method = 'POST') => {
  const result = await jQuery.ajax({
    method,
    url: CLAMPDOWN_PHP_WOO_DATA.ajax_url,
    data: {
      action,
      data
    }, 
    error(e) {
      console.log(e)
    }
  })

  return result;
}

export const getProductPricingSettings = async (productID) => {
  return await request('clampdown_child_woo_ajax_get_product_pricing_settings', {
    'product': parseInt(productID)
  });
}

export const sendProductPricingSettingsToSave = async (productID, settings) => {
  return await request('clampdown_child_woo_ajax_save_product_pricing_settings', {
    productID, 
    settings
  });
}