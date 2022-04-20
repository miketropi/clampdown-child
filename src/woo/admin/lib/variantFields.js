const variantFields = {
  Number: (() => {
    return {
      name: 'number',
      label: 'Number',
      type: 'select',
      options: [50, 100, 150, 200, 250, 300, 350, 400, 450, 500, 550, 600, 900, 1000, 1100, 1200, 2000],
      default: 300,
    }
  })(),
  Style: (() => {
    return {
      name: 'style',
      label: 'Style',
      type: 'select',
      options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      default: 'Standard Black',
    }
  })(),
  Colour: (() => {
    return {
      name: 'colour',
      label: 'Colour',
      type: 'select',
      options: ['Black', 'Orange', 'Red'],
      default: 'Black',
      // conditional: [
      //   {
      //     field: 'style',
      //     values: ['Colour']
      //   }
      // ]
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

  /**
   * Extra fields 
   */
  Divider1: (() => {
    return {
      name: 'divider1',
      label: 'Variant options extra for #Sides 4 & 6',
      type: 'divider',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        }
      ]
    }
  })(),
  Style2: (() => {
    return {
      name: 'style2',
      label: 'Style',
      type: 'select',
      options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      default: 'Standard Black',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        }
      ]
    }
  })(),
  Colour2: (() => {
    return {
      name: 'colour2',
      label: 'Colour',
      type: 'select',
      options: ['Black', 'Orange', 'Red'],
      default: 'Black',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        }
      ]
    }
  })(),
  Weight2: (() => {
    return {
      name: 'weight2',
      label: 'Weight',
      type: 'select',
      options: ['140g', '180g'],
      default: '140g',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        }
      ]
    }
  })(),

  /**
   * Extra fields 
   */
  Divider2: (() => {
    return {
      name: 'divider2',
      label: 'Variant options extra for #Sides 6',
      type: 'divider',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
  Style3: (() => {
    return {
      name: 'style3',
      label: 'Style',
      type: 'select',
      options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      default: 'Standard Black',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
  Colour3: (() => {
    return {
      name: 'colour3',
      label: 'Colour',
      type: 'select',
      options: ['Black', 'Orange', 'Red'],
      default: 'Black',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
  Weight3: (() => {
    return {
      name: 'weight3',
      label: 'Weight',
      type: 'select',
      options: ['140g', '180g'],
      default: '140g',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
};

export { variantFields };