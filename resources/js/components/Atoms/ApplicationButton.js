import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { green, grey } from '@mui/material/colors';

const StyledButton = styled(Button)`
  outline: none !important;
  color: #ffffff !important;
  borer-radius: 10px;
  margin-right: 2rem !important;
`;

const ApplicationButton = ({ openConfirmDialog, applyFlag }) => {
  return (
    <React.Fragment>
      { applyFlag === "applied" &&
        <StyledButton size="large" variant="contained" style={{ background: green[500] }}>
          申請済み
        </StyledButton>
      }
      { applyFlag === "unapplied" &&
        <StyledButton size="large" variant="contained" onClick={openConfirmDialog} style={{ background: green[500] }}>
          申請する
        </StyledButton>
      }
      { applyFlag === "my_projejct" &&
        <StyledButton size="large" variant="contained" style={{ background: grey[500] }}>
          申請する
        </StyledButton>
      }
    </React.Fragment>
  );
};

export default ApplicationButton;
