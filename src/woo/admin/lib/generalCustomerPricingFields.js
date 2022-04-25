const generalFields = {
  Size: (() => {
    return {
      name: 'size',
      label: 'Size',
      type: 'select', 
      // options: ['12" Pricing', '7" Pricing'],
      options: [
        { label: '12" Pricing', value: '12' },
        { label: '7" Pricing', value: '7' },
      ],
      default: '12',
      extra: {
        hiddenFrontend: true,
      }
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
        { label: '33 1/3 Speed', value: '33 1/3' },
        { label: '45 RPM Speed', value: '45' },
      ],
      default: '33 1/3',
      conditional: [ 
        { field: 'size', values: ['12'] }
      ]
    }
  })(),
  JacketType: (() => {

    return {
      name: 'jacket_type',
      label: 'Jacket Type',
      type: 'select',
      // options: [
      //   'No',
      //   'Standard Jacket',
      //   'Gatefold Jacket',
      //   'Inner Loading Gatefold Jacket',
      //   'Widespine',
      //   'Foldover',
      //   'Disco',
      //   'Local Gatefold',
      //   'PicDiscSleeves',
      // ],
      options: [
        { label: 'No Jacket', value: 'No' },
        { label: 'Standard Jacket', value: 'Standard Jacket' },
        { label: 'Gatefold Jacket', value: 'Gatefold Jacket' },
        { label: 'Inner Loading Gatefold Jacket', value: 'Inner Loading Gatefold Jacket' },
        { label: 'Widespine Jacket', value: 'Widespine' },
        { label: 'Foldover Jacket', value: 'Foldover' },
        { label: 'Disco Jacket', value: 'Disco' },
        { label: 'PicDiscSleeves Jacket', value: 'PicDiscSleeves' },
      ],
      default: 'Standard Jacket',
    }
  })(),
  InnerSleeve: (() => {
    return {
      name: 'inner_sleeve',
      label: 'Inner Sleeve',
      type: 'select',
      // options: [
      //   'White Paper',
      //   'Black Paper',
      //   'Printed 4/0',
      //   'White Poly Lined',
      //   'Black Poly Lined',
      // ],
      options: [
        { label: 'White Paper Inner Sleeve', value: 'White Paper' },
        { label: 'Black Paper Inner Sleeve', value: 'Black Paper' },
        { label: 'Printed 4/0 Inner Sleeve', value: 'Printed 4/0' },
        { label: 'White Poly Lined Inner Sleeve', value: 'White Poly Lined' },
        { label: 'Black Poly Lined Inner Sleeve', value: 'Black Poly Lined' },
      ],
      default: 'White Paper',
    }
  })(),
  Insert: (() => {
    return {
      name: 'insert',
      label: 'Insert',
      type: 'select',
      // options: [
      //   'No',
      //   'Printed',
      //   '4 Panel',
      //   '6 Panel',
      // ],
      options: [
        { label: 'No Insert', value: 'No' },
        { label: 'Printed Insert', value: 'Printed' },
        { label: '4 Panel Insert', value: '4 Panel' },
        { label: '6 Panel Insert', value: '6 Panel' },
      ],
      default: 'No',
    }
  })(),
  Packaging: (() => {
    return {
      name: 'packaging',
      label: 'Packaging',
      type: 'select',
      // options: [
      //   'None', 
      //   'Poly Bags',
      //   'Shrink Wrap'
      // ],
      options: [
        { label: 'None Packaging', value: 'None' },
        { label: 'Poly Bags Packaging', value: 'Poly Bags' },
        { label: 'Shrink Wrap Packaging', value: 'Shrink Wrap' },
      ],
      default: 'None'
    }
  })(),
  DownloadCards: (() => {
    return {
      name: 'download_cards',
      label: 'Download Cards',
      type: 'select',
      // options: [
      //   // 'No',
      //   // 'Yes',
      //   'None',
      //   'Simple',
      //   'Fancy',
      // ],
      options: [
        { label: 'None Download Cards', value: 'None' },
        { label: 'Simple Download Cards', value: 'Simple' },
        { label: 'Fancy Download Cards', value: 'Fancy' },
      ],
      default: 'None',
    }
  })(),
  MarketingStickers: (() => {
    return {
      name: 'marketing_stickers',
      label: 'Marketing Stickers',
      type: 'select',
      // options: [
      //   'None',
      //   'Circle',
      //   'Square',
      // ],
      options: [
        { label: 'None Marketing Stickers', value: 'None' },
        { label: 'Circle Marketing Stickers', value: 'Circle' },
        { label: 'Square Marketing Stickers', value: 'Square' },
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
  CenterHole: (() => {
    return {
      name: 'center_hole',
      label: 'Center Hole',
      type: 'select',
      // options: [
      //   'Big',
      //   'Little',
      // ],
      options: [
        { label: 'Big Center Hole', value: 'Big' },
        { label: 'Little Center Hole', value: 'Little' },
      ],
      default: 'Big',
      conditional: [ 
        { field: 'size', values: ['7'] }
      ]
    }
  })(),
};

export { generalFields };