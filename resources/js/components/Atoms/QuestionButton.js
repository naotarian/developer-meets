import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { red } from '@mui/material/colors';
import Grid from '@mui/material/Grid';

const StyledButton = styled(Button)`
  outline: none !important;
  background: ${red[500]} !important;
  border: 1px solid ${red[500]};
  borer-radius: 10px;
  color: #ffffff !important;
`;

const StyledGrid = styled(Grid)`
  margin-right: 2rem;
  display: inline-block;
  margin-bottom: 2rem;
`;

const QuestionButton = () => {
  return (
    <StyledButton size="large" variant="contained">
      質問したい
    </StyledButton>
  );
};

export default QuestionButton;