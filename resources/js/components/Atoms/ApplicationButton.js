import React from 'react';
import styled from 'styled-components';
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

const ApplicationButton = ({ applyFlag, openConfirmDialog, status }) => {
  const color = { background: (applyFlag === 'applied' || applyFlag === 'my_projejct' || status !== '募集中') ? grey[500] : green[500] }

  const handleConfirm = () => {
    if (applyFlag !== 'unapplied') return
    openConfirmDialog()
  }

  return (
    <StyledButton
      size="large"
      variant="contained"
      style={color}
      onClick={handleConfirm}
      sx={{ width: { xs: '100%', sm: 'fit-content'}}}
      disabled={(applyFlag === 'applied' || applyFlag === 'my_projejct' || status !== '募集中') ? true : false}
    >
      {applyFlag === 'applied' && '申請済み'}
      {applyFlag === 'unapplied' && '申請する'}
      {applyFlag === 'my_projejct' && '自分のプロジェクト'}
      {applyFlag === 'not_login' && <StyledA href={`${location.origin}/login`}>ログインして申請する</StyledA>}
    </StyledButton>
  );
};

export default ApplicationButton;
