import React from 'react';
import styled from "styled-components";
import SkillTag from '../Atoms/SkillTag';
import Stack from '@mui/material/Stack';

const StyledStack = styled(Stack)`
  margin-bottom: 8px;
`;
const DetailStack = styled(Stack)`
  margin-left: 2rem;
  margin-top: 2rem;
`;

const SkillTags = ({ skills, detail }) => {
  return (
    <>
    {detail ? 
      (
        <DetailStack
        direction="row"
        spacing={1}
        >
        { skills.map((skill, index) => {
          return (
            <SkillTag skill={skill} key={index} />
          );
        })}
        </DetailStack>
      ) : (
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
      )
    }
    </>
  );
};

export default SkillTags;
