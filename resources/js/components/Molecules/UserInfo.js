import React from 'react';
import styled from 'styled-components';
import UserIcon from '../Atoms/UserIcon';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const StyledText = styled(Typography)`
  margin-left: 8px !important;
`;

const UserInfo = ({ username, imgPath }) => {
  return (
    <Grid container alignItems='center'>
      <UserIcon size={36} imgPath={imgPath} />
      <StyledText>{username}</StyledText>
    </Grid>
  );
};

export default UserInfo;
