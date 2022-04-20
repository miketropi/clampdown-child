const generalFields = {
  Size: (() => {
    return {
      name: 'size',
      label: 'Size',
      type: 'select', 
      options: ['12" Pricing', '7" Pricing'],
      default: '12" Pricing',
    }
  })(),
  Sides: (() => {
    return {
      name: 'sides',
      label: 'Sides',
      type: 'select', 
      // options: [0, 1, 2, 4, 6],
      options: [
        { label: 'Zero Side', value: 0 },
        { label: 'One Side', value: 1 },
        { label: 'Two Sides', value: 2 },
        { label: 'Four Sides', value: 4 },
        { label: 'Six Sides', value: 6 },
      ],
      default: 2,
    }
  })(),
  Speed: (() => {
    return {
      name: 'speed',
      label: 'Speed',
      type: 'select', 
      // options: ['33 1/3', '45'],
      options: [
        { label: '33 1/3', value: '33 1/3' },
        { label: '45 RPM', value: '45' },
      ],
      default: '33 1/3',
    }
  })(),
  JacketType: (() => {
    return {
      name: 'jacket_type',
      label: 'Jacket Type',
      type: 'select',
      options: [
        'No',
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
        'White Paper',
        'Black Paper',
        'Printed 4/0',
        'White Poly Lined',
        'Black Poly Lined',
      ],
      default: 'White Paper',
    }
  })(),
  Insert: (() => {
    return {
      name: 'insert',
      label: 'Insert',
      type: 'select',
      options: [
        'No',
        'Printed',
        '4 Panel',
        '6 Panel',
      ],
      default: 'No',
    }
  })(),
  Packaging: (() => {
    return {
      name: 'packaging',
      label: 'Packaging',
      type: 'select',
      options: [
        'None', 
        'Poly Bags',
        'Shrink Wrap'
      ],
      default: 'None'
    }
  })(),
  DownloadCards: (() => {
    return {
      name: 'download_cards',
      label: 'Download Cards',
      type: 'select',
      options: [
        // 'No',
        // 'Yes',
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
  Tests: (() => {
    return {
      name: 'tests',
      label: 'Tests?',
      type: 'hidden',
      default: 'Yes',
    }
  })(),
  Labels: (() => {
    return {
      name: 'labels',
      label: 'Labels',
      type: 'hidden',
      default: 'Yes',
    }
  })(),
};

export { generalFields };