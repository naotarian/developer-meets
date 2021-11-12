import React from 'react';
import styled from 'styled-components';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import AccessTimeIcon from '@mui/icons-material/AccessTime';
import RoomOutlinedIcon from '@mui/icons-material/RoomOutlined';
import PeopleOutlineIcon from '@mui/icons-material/PeopleOutline';
import CommentOutlinedIcon from '@mui/icons-material/CommentOutlined';
import { green } from '@mui/material/colors';

const FlexGrid = styled(Grid)`
  display: flex;
  margin: 4px 0;
`;

const StyledText = styled(Typography)`
  color: gray;
  margin: 0 8px !important;
  // font-size: small;
`;

const ProjectColumn = ({column, text}) => {
  return (
    <FlexGrid>
      { column === 'time' && <AccessTimeIcon sx={{ fontSize: 20, color: green[500] }} /> }
      { column === 'location' && <RoomOutlinedIcon sx={{ fontSize: 20, color: green[500] }} /> }
      { column === 'people' && <PeopleOutlineIcon sx={{ fontSize: 20, color: green[500] }} /> }
      { column === 'purpose' && <CommentOutlinedIcon sx={{ fontSize: 20, color: green[500] }} /> }
      <StyledText>
        {text}
      </StyledText>
    </FlexGrid>
  );
};

export default ProjectColumn;
