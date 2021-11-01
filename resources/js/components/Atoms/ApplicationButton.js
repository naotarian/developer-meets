import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { green } from '@mui/material/colors';
import Grid from '@mui/material/Grid';

const StyledButton = styled(Button)
`
  outline: none !important;
  background: ${green[500]}!important;
  border: 1px solid ${green[500]}!important;
  color: #fff!important;
  borer-radius: 10px;
  display: block;
  margin-right: 2rem;
  padding: 8px 22px!important;
`;
const StyledButtonDisabled = styled(Button)
`
  outline: none !important;
  background: #ccc;!important;
  // border: 1px solid ${green[500]}!important;
  color: #fff!important;
  borer-radius: 10px;
  display: block;
  margin-right: 2rem;
  padding: 8px 22px!important;
`;


const StyledGrid = styled(Grid)
`
  margin-right: 2rem;
  display: inline-block;
  margin-bottom: 2rem;
`;

const ApplicationButton = ({ ...props }) => {
  if (props.text == '申請済み' || props.text == '公開済み') {
    return (
      <StyledGrid>
          <StyledButtonDisabled {...props} disabled>
            {props.text}
          </StyledButtonDisabled>
      </StyledGrid>
    );
  }
  else {
    return (
      <StyledGrid>
          <StyledButton {...props}>
            {props.text}
          </StyledButton>
      </StyledGrid>
    );
  }
};

export default ApplicationButton;
