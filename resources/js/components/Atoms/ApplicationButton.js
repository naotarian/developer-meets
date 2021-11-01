import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { green } from '@mui/material/colors';
import Grid from '@mui/material/Grid';

const StyledButton = styled(Button)`
  outline: none !important;
  background: ${green[500]} !important;
  color: #ffffff !important;
  borer-radius: 10px;
  margin-right: 2rem !important;
`;
const StyledButtonDisabled = styled(Button)`
  outline: none !important;
  background: #ccc;!important;
  // border: 1px solid ${green[500]}!important;
  color: #fff!important;
  borer-radius: 10px;
  display: block;
  margin-right: 2rem;
  padding: 8px 22px!important;
`;


const StyledGrid = styled(Grid)`
  margin-right: 2rem;
  display: inline-block;
  margin-bottom: 2rem;
`;

const ApplicationButton = ({ text, openConfirmDialog }) => {
  return (
    <StyledButton size="large" variant="contained" onClick={openConfirmDialog}>
      申請する
    </StyledButton>
  );
  // if (text == '申請済み' || text == '公開済み') {
  //   return (
  //     <StyledGrid>
  //       <StyledButtonDisabled size="large" variant="contained" disabled>
  //         {text}
  //       </StyledButtonDisabled>
  //     </StyledGrid>
  //   );
  // }
  // else {
  //   return (
  //     <StyledGrid>
  //       <StyledButton size="large" variant="contained">
  //         {text}
  //       </StyledButton>
  //     </StyledGrid>
  //   );
  // }
};

export default ApplicationButton;
