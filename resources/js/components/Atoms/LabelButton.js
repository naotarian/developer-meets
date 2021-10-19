import React from 'react';
import Button from '@mui/material/Button';

const LabelButton = ({label, ...props}) => {
  return (
    <Button {...props}>
      {label}
    </Button>
  );
};

export default LabelButton;