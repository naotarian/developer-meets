import React from 'react';
import Grid from '@mui/material/Grid';
import Avatar from '@mui/material/Avatar';

const UserIcon = ({ size, img }) => {
  return (
    <Grid>
      {
        img ? (
          <Avatar alt = "" src={img} sx={{ width: size, height: size }} />
        ) : (
            <Avatar sx={{ width: size, height: size }}>H</Avatar>
        )
      }
    </Grid>
  );
};

export default UserIcon;
