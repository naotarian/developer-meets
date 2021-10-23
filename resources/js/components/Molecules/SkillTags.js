import React from 'react';
import styled from "styled-components";
import SkillTag from '../Atoms/SkillTag';
import Stack from '@mui/material/Stack';

const StyledStack = styled(Stack)`
  margin-bottom: 8px;
`;

const SkillTags = ({ skills }) => {
  return (
    <StyledStack
      direction="row"
      spacing={1}
    >
      { skills.map((skill, index) => {
        return (
          <SkillTag skill={skill} key={index} />
        );
      })}
    </StyledStack>
  );
};

export default SkillTags;
