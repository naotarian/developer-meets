import React from 'react';
import Snackbar from '@mui/material/Snackbar';
import Alert from '@mui/material/Alert';
// import Stack from '@mui/material/Stack';

export default function Notification({ onClose, level, text }) {
  // level: error, warning, info, success
  return (
    <Snackbar
      open={Boolean(level && text)}
      autoHideDuration={2000}
      onClose={onClose}
      anchorOrigin={{ 'horizontal': 'left', 'vertical': 'bottom'}}
    >
      <Alert variant="filled" severity={level || 'success'}>
        {text}
      </Alert>
    </Snackbar>
  );
}