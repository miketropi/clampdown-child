import React from "react";
import { Button, Tooltip, Modal } from 'antd';
import styled from "styled-components";
import { MinusCircleOutlined, CaretDownOutlined, CaretUpOutlined, ExclamationCircleOutlined } from '@ant-design/icons';

const ActionRuleItemContainer = styled.div`
  > * {

    &:not(last-child) {
      margin-right: 2px;
    }
  }
`;

export default ({ index, name, actions }) => {
  const { add, remove } = actions;

  const confirmDelete = () => {
    Modal.confirm({
      title: 'Confirm',
      icon: <ExclamationCircleOutlined />,
      content: 'Delete this rule.',
      okText: 'OK',
      cancelText: 'Cancel',
      cancelButtonProps: { style: { background: 'none', color: 'black', border: 'none', boxShadow: 'none' } },
      okButtonProps: { style: { border: 'none', boxShadow: 'none' } },
      onOk: (close) => {
        remove(name);
        close();
      }
    });
  }

  return <ActionRuleItemContainer onClick={ e => { e.stopPropagation(); } }>
    <Tooltip title="Add rule above">
      <Button 
        size="small" 
        type="primary" 
        shape="circle" 
        icon={ <CaretUpOutlined /> } 
        onClick={() => add('', name)} />
    </Tooltip>
    <Tooltip title="Add rule below">
      <Button 
        size="small" 
        type="primary" 
        shape="circle" 
        icon={ <CaretDownOutlined /> } 
        onClick={() => add('', name+1)} />
    </Tooltip>
    <Tooltip title="Remove rule">
      <Button 
        size="small" 
        type="primary" 
        danger
        shape="circle" 
        icon={ <MinusCircleOutlined /> } 
        onClick={ confirmDelete } />
    </Tooltip>
  </ActionRuleItemContainer>
}