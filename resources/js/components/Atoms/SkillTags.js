import React from 'react';
import styled from "styled-components";
import Stack from '@mui/material/Stack';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import { green } from '@mui/material/colors';

const Item = styled(Grid)`
  background-color: ${green[500]};
  text-align: center;
  border-radius: 4px;
`;

const StyledText = styled(Typography)`
  color: #ffffff;
  padding: 2px 8px;
  font-size: small !important;
`;

const SkillTags = ({ skillTags }) => {
  return (
    <Stack
      direction={{ xs: 'column', sm: 'row' }}
      spacing={{ xs: 1, sm: 2, md: 4 }}
    >
      { skillTags.map((skill, index) => {
        return (
          <Item key={index}>
            <StyledText>
              {skill}
            </StyledText>
          </Item>
        );
      })}
    </Stack>
  );
};

export default SkillTags;