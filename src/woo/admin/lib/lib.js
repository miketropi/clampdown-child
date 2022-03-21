/**
 * Lib 
 */

export const registerCustomerPricingFields = () => {
  return {
    Sides: (() => {
      return {
        name: 'sides',
        label: 'Sides',
        type: 'select', 
        options: [0, 1, 2, 4, 6],
        default: 0,
      }
    })(),
    Speed: (() => {
      return {
        name: 'speed',
        label: 'Speed',
        type: 'select', 
        options: ['33 1/3', '45'],
        default: '33 1/3',
      }
    })(),
    JacketType: (() => {
      return {
        name: 'jacket_type',
        label: 'Jacket Type',
        type: 'select',
        options: [
          'Standard Jacket',
          'Gatefold Jacket',
          'Inner Loading Gatefold Jacket',
          'Widespine',
          'Foldover',
          'Disco'
        ],
        default: 'Standard Jacket',
      }
    })(),
    InnerSleeve: (() => {
      return {
        name: 'inner_sleeve',
        label: 'Inner Sleeve',
        type: 'select',
        options: [
          'White',
          'Black',
          'Printed',
          'White Poly Lined',
          'Black Poly Lined',
        ],
        default: 'White',
      }
    })(),
    Insert: (() => {
      return {
        name: 'insert',
        label: 'Insert',
        type: 'select',
        options: [
          'None',
          '1 panel',
          '2 panel',
          '4 panel',
          '6 panel',
        ],
        default: 'None',
      }
    })(),
    Packaging: (() => {
      return {
        name: 'packaging',
        label: 'Packaging',
        type: 'select',
        options: [
          'Poly Bags',
          'Shrink Wrap'
        ],
        default: 'Poly Bags'
      }
    })(),
    DownloadCards: (() => {
      return {
        name: 'download_cards',
        label: 'Download Cards',
        type: 'select',
        options: [
          'None',
          'Simple',
          'Fancy',
        ],
        default: 'None',
      }
    })(),
    MarketingStickers: (() => {
      return {
        name: 'marketing_stickers',
        label: 'Marketing Stickers',
        type: 'select',
        options: [
          'None',
          'Circle',
          'Square',
        ],
        default: 'None',
      }
    })(),
    Number: (() => {
      return {
        name: 'number',
        label: 'Number',
        type: 'select',
        options: [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 900, 1000, 1100, 2000],
        default: 50,
      }
    })(),
    Style: (() => {
      return {
        name: 'style',
        label: 'Style',
        type: 'select',
        options: ['Standard', 'Colour',	'Deluxe', 'Colour'],
        default: 'Standard',
      }
    })(),
    Colour: (() => {
      return {
        name: 'colour',
        label: 'Colour',
        type: 'select',
        options: ['Black', 'Orange', 'Red'],
        default: 'Black',
      }
    })(),
    Weight: (() => {
      return {
        name: 'weight',
        label: 'Weight',
        type: 'select',
        options: ['140g', '180g'],
        default: '140g',
      }
    })(),
  }
}