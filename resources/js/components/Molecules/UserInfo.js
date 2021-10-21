import React from 'react';
import styled from "styled-components";
import UserIcon from '../Atoms/UserIcon';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const FlexGrid = styled(Grid)`
  display: flex;
`;

const StyledText = styled(Typography)`
  margin-left: 8px !important;
`;

const UserInfo = ({ username }) => {
  return (
    <FlexGrid>
      <UserIcon size={24} />
      <StyledText>{username ? username : 'ユーザー名'}</StyledText>
    </FlexGrid>
  );
};

export default UserInfo;
