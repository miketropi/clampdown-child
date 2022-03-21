import { Switch } from "antd";

export default function SwitchCustom(props) {
  let checked = (props.checked == 'true' || props.checked == true) ? true : false;
  return <Switch checked={ checked } id={ props.id } onChange={ props.onChange }/>
} 