import React, { useEffect } from 'react';
import styled from 'styled-components';
import { Form, Tabs } from 'antd';

const { TabPane } = Tabs;
const VariantRecordImagesSettingsFormContainer = styled.div`
  margin-top: 3em;
  margin-bottom: 3em;
`

export default ({ onChange, fields }) => {
  const [form] = Form.useForm();

  useEffect(() => {
    form.setFieldsValue(fields)
  }, [fields])

  const onFinish = () => {}
  const onFinishFailed = () => {}

  return <VariantRecordImagesSettingsFormContainer>
    <Form
      name="variant_record_images_setttings"
      form={ form }
      layout={ 'vertical' }
      onFinish={ onFinish } 
      onFinishFailed={ onFinishFailed } 
      onValuesChange={ (changedValues, allValues) => {
        onChange(allValues);
      } }>
      <Tabs 
        tabPosition={ 'top' }
        type="card"
        defaultActiveKey="1" >
        <TabPane tab={ 'Tab One' } key="1">
          Hello content...
        </TabPane>
      </Tabs>
    </Form>
  </VariantRecordImagesSettingsFormContainer>
}