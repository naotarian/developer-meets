import React from 'react';
import styled from "styled-components";
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import { green } from '@mui/material/colors';

const Item = styled(Grid)`
  background-color: ${green[500]};
  text-align: center;
  border-radius: 4px;
  max-width: 100px;
`;

const StyledText = styled(Typography)`
  color: #ffffff;
  padding: 2px 8px;
  font-size: small !important;
`;

const SkillTag = ({ skill, index }) => {
  return (
    <Item key={index}>
      <StyledText>
        {skill}
      </StyledText>
    </Item>
  );
};

export default SkillTag;
