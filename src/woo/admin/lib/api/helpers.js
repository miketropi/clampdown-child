/**
 * Request
 */

export const request = async (action, data, method = 'POST', headers = {}) => {
  const response = await fetch(`${ wp.ajax.settings.url }?action=${ action }`, {
    method,
    headers: {
      'Content-Type': 'application/json',
      // 'Content-Type': 'application/x-www-form-urlencoded',
      ...headers
    },
    body: JSON.stringify(data)
  })

  return response.json();
}

export const getProductPricingSettings = async (productID) => {
  return await request('clampdown_child_woo_ajax_get_product_pricing_settings', {
    'product': productID
  });
}

