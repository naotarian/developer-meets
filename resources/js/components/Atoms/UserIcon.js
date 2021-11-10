import React from 'react';
import Avatar from '@mui/material/Avatar';

const UserIcon = ({ size, imgPath }) => {
  return (
    <React.Fragment>
      {imgPath ? <Avatar src={imgPath} sx={{ width: size, height: size }} /> : <Avatar sx={{ width: size, height: size }}>No</Avatar>}
    </React.Fragment>
  );
};

export default UserIcon;
