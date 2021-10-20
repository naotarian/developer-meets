import React, { useState } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import LabelButton from '../Atoms/LabelButton';
import ProjectColumn from '../Atoms/ProjectColumn';
import SkillTags from '../Molecules/SkillTags';
import UserInfo from '../Molecules/UserInfo';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
// import CardMedia from '@mui/material/CardMedia';
import Typography from '@mui/material/Typography';

const StyledCard = styled(Card)`
  padding-left: 8px;
  margin: 8px;
`;

const ProjectCard = ({ projectInfo }) => {
  const [confirmFlag, setConfirmFlag] = useState(false);

  return (
    <StyledCard sx={{ maxWidth: 400 }}>
      {/* プロジェクト画像は未定 */}
      {/* <CardMedia component="img" image="~/path/xxx.jpg" /> */}
      <CardContent>
        {/* プロジェクトタイトル */}
        <Typography gutterBottom variant="h6" component="div">
          Project Title
        </Typography>
        {/* プロジェクト情報（言語とかツールをタグ的な感じに） */}
        <SkillTags skills={["swift", "Python", "Git hub"]} />
        {/* プロジェクト情報（上記以外からいくつかpick up） */}
        <ProjectColumn column="time" text="週1~2日" />
        <ProjectColumn column="location" text="全国/フルリモート(在宅OK)" />
        <ProjectColumn column="people" text="募集2人" />
      </CardContent>
      {/* ボタン系 */}
      <CardActions>
        <LabelButton label="詳細を見る" variant="outlined" size="small" />
        <LabelButton label="質問したい" variant="outlined" size="small" />
        <LabelButton label="参加申請" variant="outlined" size="small" onClick={() => setConfirmFlag(true)} />
        {/* 参加申請の確認ダイアログ */}
        <JoinConfirmDialog open={confirmFlag} handleClose={() => setConfirmFlag(false)} />
      </CardActions>
      {/* ユーザー情報 */}
      <CardContent>
        <UserInfo />
      </CardContent>
    </StyledCard>
  );
};

export default ProjectCard;

ReactDOM.render(<ProjectCard />, document.getElementById('project_card'));
