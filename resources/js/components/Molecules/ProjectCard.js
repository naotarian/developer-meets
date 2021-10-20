import React from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import LabelButton from '../Atoms/LabelButton';
import ProjectColumn from '../Atoms/ProjectColumn';
import SkillTags from '../Atoms/SkillTags';
import UserInfo from './UserInfo';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
// import CardMedia from '@mui/material/CardMedia';
import Typography from '@mui/material/Typography';

const StyledCard = styled(Card)`
  padding-left: 8px;
  padding-bottom: 8px;
  margin: 8px;
`;

const ProjectCard = ({ projectInfo }) => {
  return (
    <StyledCard sx={{ maxWidth: 400 }}>
      {/* <CardMedia component="img" image="~/path/xxx.jpg" /> */}
      <CardContent>
        <Typography gutterBottom variant="h6" component="div">
          {/* {title} */}
          Project Title
        </Typography>
        <SkillTags skillTags={["swift", "Python", "Git hub"]} />
        <ProjectColumn column="time" text="週1~2日" />
        <ProjectColumn column="location" text="全国/フルリモート(在宅OK)" />
        <ProjectColumn column="people" text="募集2人" />
      </CardContent>
      <CardActions>
        <LabelButton label="詳細を見る" variant="outlined" size="small" />
        <LabelButton label="質問したい" variant="outlined" size="small" />
        <LabelButton label="参加申請" variant="outlined" size="small" />
      </CardActions>
      <CardContent>
        <UserInfo />
      </CardContent>
    </StyledCard>
  );
};

export default ProjectCard;

ReactDOM.render(<ProjectCard />, document.getElementById('project_card'));
