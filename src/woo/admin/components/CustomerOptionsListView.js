import react, { Fragment } from 'react';
import { List, Tag } from "antd";

export default function CustomerOptionsListView({ options }) {
  return <Fragment>
    <List
      size="small"
      bordered
      dataSource={ Object.values(options) }
      renderItem={item => {
        return <List.Item>
          {/* { JSON.stringify(item) } */}
          <List.Item.Meta
            title={ item.label }
            description={ (() => {
              let countOpts = item.options.length;
              return <Fragment>
                { item.options.slice(0, 3).map( o => <Tag>{ o }</Tag> ) }
                { item.options.length > 3 && <Tag title={ `more ${ countOpts - 3 } items` }>...</Tag> }
              </Fragment>
            })() }
          />
        </List.Item>
      }}
    />
  </Fragment>
}