import React from 'react';
import styled from 'styled-components';
import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';
import Modal from '@mui/material/Modal';

const StyledBox = styled(Box)`
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  outline: none;
`;

export default function ProgressCircular({ loading }) {
  return (
    <Modal open={Boolean(loading)}>
      <StyledBox>
        <CircularProgress />
      </StyledBox>
    </Modal>
  );
}