import React from 'react';
import styled from 'styled-components';
import Button from '@mui/material/Button';
import { red } from '@mui/material/colors';

const StyledButton = styled(Button)`
  outline: none !important;
  background: ${red[500]} !important;
  border: 1px solid ${red[500]};
  borer-radius: 10px;
  color: #ffffff !important;
  margin: 0.5rem !important;
`;

const QuestionButton = () => {
  return (
    <StyledButton size="large" variant="contained" sx={{ width: { xs: '100%', sm: '140px' } }}>
      質問したい
    </StyledButton>
  );
};

export default QuestionButton;