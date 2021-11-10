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

const UserInfo = ({ username, imgPath }) => {
  return (
    <FlexGrid>
      <UserIcon size={24} imgPath={imgPath} />
      <StyledText>{username}</StyledText>
    </FlexGrid>
  );
};

export default UserInfo;
