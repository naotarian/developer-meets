import React from 'react';
import styled from "styled-components";
import Button from '@mui/material/Button';
import { green, grey } from '@mui/material/colors';

const StyledButton = styled(Button)`
  outline: none !important;
  color: #ffffff !important;
  borer-radius: 10px;
  margin: 0.5rem !important;
`;

const StyledA = styled.a`
  text-decoration: none;
  color: #ffffff;
  &:hover {
    color: #ffffff;
  }
`;

const ApplicationButton = ({ openConfirmDialog, applyFlag }) => {
  return (
    <React.Fragment>
      { applyFlag === "applied" &&
        <StyledButton size="large" variant="contained" style={{ background: grey[500] }} sx={{ width: { xs: '100%', sm: '140px' } }} disabled>
          申請済み
        </StyledButton>
      }
      { applyFlag === "unapplied" &&
        <StyledButton size="large" variant="contained" style={{ background: green[500] }} sx={{ width: { xs: '100%', sm: '140px' } }} onClick={openConfirmDialog} >
          申請する
        </StyledButton>
      }
      { applyFlag === "my_projejct" &&
        <StyledButton size="large" variant="contained" style={{ background: grey[500] }} sx={{ width: { xs: '100%', sm: '200px' } }} disabled>
          自分のプロジェクト
        </StyledButton>
      }
      { applyFlag === "not_login" &&
        <StyledButton size="large" variant="contained" style={{ background: green[500] }} sx={{ width: { xs: '100%', sm: '200px' } }} >
          <StyledA href={`${location.origin}/login`}>ログインして申請する</StyledA>
        </StyledButton>
      }
    </React.Fragment>
  );
};

export default ApplicationButton;
