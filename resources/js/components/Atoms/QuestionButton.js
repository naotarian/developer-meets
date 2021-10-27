import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { red } from '@mui/material/colors';
import Grid from '@mui/material/Grid';

const StyledButton = styled(Button)`
  outline: none !important;
  background: ${red[500]}!important;
  border: 1px solid ${red[500]}!important;
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

const QuestionButton = ({...props}) => {
  return (
    <StyledGrid>
        <StyledButton {...props}>
          質問したい
        </StyledButton>
    </StyledGrid>
  );
};

export default QuestionButton;