const STYLE_OPTS = [
  { label: 'Standard Black Style', value: 'Standard Black' },
  { label: 'Colour Style', value: 'Colour' },
  { label: 'Split Style', value: 'Split' },
  { label: 'Smash Style', value: 'Smash' },
  { label: 'Clash Style', value: 'Clash' },
  { label: 'Color In Color Style', value: 'Color In Color' },
];

const COLOUR_OPTS = [
  // OPAQUE COLOURS
  { label: 'Cherry Colour', value: 'Cherry' },
  { label: 'Bluegaloo Colour', value: 'Bluegaloo' },
  { label: 'Orange Colour', value: 'Orange' },
  { label: 'Grape Colour', value: 'Grape' },
  { label: 'Bubblegum Colour', value: 'Bubblegum' },
  { label: 'Lime Colour', value: 'Lime' },
  { label: 'Lemon Colour', value: 'Lemon' },
  { label: 'Bone Colour', value: 'Bone' },
  { label: 'Forrest Colour', value: 'Forrest' },
  { label: 'Black Colour', value: 'Black' },
  { label: 'White Colour', value: 'White' },
  { label: 'Skyblue Colour', value: 'Skyblue' },

  // TRANSPARENT COLOURS
  { label: 'Highlighter Yello Colour', value: 'Highlighter Yello' },
  { label: 'Mellow Yello - T Colour', value: 'Mellow Yello - T' },
  { label: 'Clear - T Colour', value: 'Clear - T' },
  { label: 'Coke Bottle - T Colour', value: 'Coke Bottle - T' },
  { label: 'Soft Pink - T Colour', value: 'Soft Pink - T' },
  { label: 'Sky Blue - T Colour', value: 'Sky Blue - T' },
  { label: 'Shocking Pink - T Colour', value: 'Shocking Pink - T' },
  { label: 'Bluegaloo - T Colour', value: 'Bluegaloo - T' },
  { label: 'Cherry - T Colour', value: 'Cherry - T' },
  
  //METALLIC COLOURS
  { label: 'Metallic Gold Colour', value: 'Metallic Gold' },
  { label: 'Metalic Silver', value: 'Metalic Silver' },
];

const WEIGHT_OPTS = [
  {label: '140g Weight', value: '140g' },
  {label: '180g Weight', value: '180g' },
];

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
  /**
   * Extra fields 
   */
  Divider0: (() => {
    return {
      name: 'divider0',
      label: 'Divider',
      type: 'divider',
      extra: {
        frontendDividerLabel: 'Default',
      },
    }
  })(),
  Style: (() => {
    return {
      name: 'style',
      label: 'Style',
      type: 'select',
      // options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      options: STYLE_OPTS,
      default: 'Standard Black',
    }
  })(),
  Colour: (() => {
    return {
      name: 'colour',
      label: 'Colour',
      type: 'select',
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Black',
      conditional: [
        {
          field: 'style',
          values: ['Colour', 'Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Colour_1_2: (() => {
    return {
      name: 'colour_1_2',
      label: 'Colour 2',
      type: 'select',
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Cherry',
      conditional: [
        {
          field: 'style',
          values: ['Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Weight: (() => {
    return {
      name: 'weight',
      label: 'Weight',
      type: 'select',
      // options: ['140g', '180g'],
      options: WEIGHT_OPTS,
      default: '140g',
    }
  })(),
  Splater: (() => {
    return {
      name: 'splater',
      label: 'Splater',
      type: 'select', 
      options: [
        { label: 'Yes Splater', value: 'yes' },
        { label: 'No Splater', value: 'no' },
      ],
      default: 'yes'
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
      ],
      extra: {
        frontendDividerLabel: 'A/B',
      },
    }
  })(),
  Style2: (() => {
    return {
      name: 'style2',
      label: 'Style',
      type: 'select',
      // options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      options: STYLE_OPTS,
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
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Black',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        },
        {
          field: 'style2',
          values: ['Colour', 'Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Colour_2_2: (() => {
    return {
      name: 'colour_2_2',
      label: 'Colour 2',
      type: 'select',
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Cherry',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        },
        {
          field: 'style2',
          values: ['Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Weight2: (() => {
    return {
      name: 'weight2',
      label: 'Weight',
      type: 'select',
      // options: ['140g', '180g'],
      options: WEIGHT_OPTS,
      default: '140g',
      conditional: [
        {
          field: 'sides',
          values: [4, 6]
        }
      ]
    }
  })(),
  Splater2: (() => {
    return {
      name: 'splater2',
      label: 'Splater',
      type: 'select', 
      options: [
        { label: 'Yes Splater', value: 'yes' },
        { label: 'No Splater', value: 'no' },
      ],
      default: 'yes',
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
      ],
      extra: {
        frontendDividerLabel: 'C/D',
      },
    }
  })(),
  Style3: (() => {
    return {
      name: 'style3',
      label: 'Style',
      type: 'select',
      // options: ['Standard Black', 'Colour',	'Split', 'Smash', 'Clash', 'Color In Color'],
      options: STYLE_OPTS,
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
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Black',
      conditional: [
        {
          field: 'sides',
          values: [6]
        },
        {
          field: 'style3',
          values: ['Colour', 'Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Colour_3_2: (() => {
    return {
      name: 'colour_3_2',
      label: 'Colour 2',
      type: 'select',
      // options: ['Black', 'Orange', 'Red'],
      options: COLOUR_OPTS,
      default: 'Cherry',
      conditional: [
        {
          field: 'sides',
          values: [6]
        },
        {
          field: 'style3',
          values: ['Split', 'Smash', 'Clash', 'Color In Color']
        }
      ]
    }
  })(),
  Weight3: (() => {
    return {
      name: 'weight3',
      label: 'Weight',
      type: 'select',
      // options: ['140g', '180g'],
      options: WEIGHT_OPTS,
      default: '140g',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
  Splater3: (() => {
    return {
      name: 'splater3',
      label: 'Splater',
      type: 'select', 
      options: [
        { label: 'Yes Splater', value: 'yes' },
        { label: 'No Splater', value: 'no' },
      ],
      default: 'yes',
      conditional: [
        {
          field: 'sides',
          values: [6]
        }
      ]
    }
  })(),
};

export { variantFields, STYLE_OPTS, COLOUR_OPTS, WEIGHT_OPTS };