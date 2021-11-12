import React from 'react';
import styled from 'styled-components';
import Button from '@mui/material/Button';

const StyledButton = styled(Button)`
  outline: none !important;
`;

const LabelButton = ({label, ...props}) => {
  return (
    <StyledButton {...props}>
      {label}
    </StyledButton>
  );
};

export default LabelButton;
