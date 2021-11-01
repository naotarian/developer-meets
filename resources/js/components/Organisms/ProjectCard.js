import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import ProjectColumn from '../Atoms/ProjectColumn';
import SkillTags from '../Molecules/SkillTags';
import UserInfo from '../Molecules/UserInfo';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import CardActionArea from '@mui/material/CardActionArea';
// import CardMedia from '@mui/material/CardMedia';
import Typography from '@mui/material/Typography';

const StyledCard = styled(Card)`
  width: 375px;
  margin: 8px;
`;

const StyledCardActionArea = styled(CardActionArea)`
  outline: none !important;
`;
const TypographyOverflow = styled(Typography)`
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis!important;
`;

const ProjectCard = ({ project_data }) => {
  const [host, setHost] = useState('');

  useEffect(() => {
    setHost(location.host);
  }, [])

  return (
    <StyledCard sx={{ maxWidth: 400 }}>
      <StyledCardActionArea
        href={`http://${host}/seek/detail/${project_data.id}`}
      >
        {/* プロジェクト画像は未定 */}
        {/* <CardMedia component="img" image="~/path/xxx.jpg" /> */}
        <CardContent>
          <TypographyOverflow gutterBottom variant="h6" component="div">
            {project_data.project_name}
          </TypographyOverflow>
          <SkillTags skills={[project_data.language, project_data.sub_language]} />
          { project_data.work_frequency && <ProjectColumn column="time" text={project_data.work_frequency} /> }
          {/* <ProjectColumn column="location" text="全国/フルリモート(在宅OK)" /> */}
          { project_data.purpose && <ProjectColumn column="purpose" text={`${project_data.purpose}`} /> }
          { project_data.number_of_application && <ProjectColumn column="people" text={`募集 ${project_data.number_of_application}人`} /> }
          <UserInfo username={project_data.user.user_name} />
        </CardContent>
      </StyledCardActionArea>
    </StyledCard>
  );
};

export default ProjectCard;
