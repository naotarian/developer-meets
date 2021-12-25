import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import ProjectColumn from '../Atoms/ProjectColumn';
import SkillTags from '../Molecules/SkillTags';
import UserInfo from '../Molecules/UserInfo';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import CardActionArea from '@mui/material/CardActionArea';
import Typography from '@mui/material/Typography';

const StyledCard = styled(Card)`
  width: 375px;
  margin: 8px;
`;

const StyledCardActionArea = styled(CardActionArea)`
  outline: none !important;
  height: 100%;
`;
const TypographyOverflow = styled(Typography)`
  font-weight: bold !important;
  // white-space: nowrap;
  // overflow: hidden;
  // text-overflow: ellipsis!important;
`;

const ProjectCard = ({ data }) => {
  return (
    <StyledCard sx={{ maxWidth: 400, filter: data.status !== '募集中' && 'grayscale(1)' }}>
      <StyledCardActionArea
        href={`http://${location.host}/seek/detail/${data.id}`}
      >
        <CardContent>
          <TypographyOverflow gutterBottom variant="h6" component="div">
            {data.project_name}
          </TypographyOverflow>
          <SkillTags skills={[data.language, data.sub_language]} />
          {data.work_frequency && <ProjectColumn column="time" text={data.work_frequency} />}
          {data.purpose && <ProjectColumn column="purpose" text={`${data.purpose}`} />}
          {data.number_of_application && <ProjectColumn column="people" text={`募集 ${data.number_of_application}人`} />}
          <UserInfo username={data.user.user_name} imgPath={`/api/user_icon/${data.user.id}`} />
        </CardContent>
      </StyledCardActionArea>
    </StyledCard>
  );
};

export default ProjectCard;