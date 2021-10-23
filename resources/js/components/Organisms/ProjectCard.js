import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import LabelButton from '../Atoms/LabelButton';
import ProjectColumn from '../Atoms/ProjectColumn';
import SkillTags from '../Molecules/SkillTags';
import UserInfo from '../Molecules/UserInfo';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import CardActionArea from '@mui/material/CardActionArea';

// import CardMedia from '@mui/material/CardMedia';
import Typography from '@mui/material/Typography';

const StyledCard = styled(Card)`
  width: 375px;
  // padding-left: 8px;
  margin: 8px;
`;

const StyledCardActionArea = styled(CardActionArea)`
  outline: none !important;
`;

const ProjectCard = ({ project_data }) => {
  const [host, setHost] = useState('');
  // const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(() => {
    setHost(location.host);

  }, [])

  let goDetailPage = () => {
    // ページ遷移が走るリクエストを投げる
    console.log('ページ遷移発火')
    let url = `http://${host}/seek/detail/1`
    axios.get(url).then(res => {
      console.log('res: ', res)
    });
  }

  return (
    <StyledCard sx={{ maxWidth: 400 }}>
      <StyledCardActionArea
        onClick={()=> goDetailPage}
      >
        {/* プロジェクト画像は未定 */}
        {/* <CardMedia component="img" image="~/path/xxx.jpg" /> */}
        <CardContent>
          {/* プロジェクトタイトル */}
          <Typography gutterBottom variant="h6" component="div">
            {project_data.project_name}
          </Typography>
          {/* プロジェクト情報（言語とかツールをタグ的な感じに） */}
          <SkillTags skills={[project_data.language, project_data.sub_language]} />
          {/* プロジェクト情報（上記以外からいくつかpick up） */}
          { project_data.work_frequency && <ProjectColumn column="time" text={project_data.work_frequency} /> }
          {/* <ProjectColumn column="location" text="全国/フルリモート(在宅OK)" /> */}
          { project_data.purpose && <ProjectColumn column="purpose" text={`${project_data.purpose}`} /> }
          { project_data.number_of_application && <ProjectColumn column="people" text={`募集 ${project_data.number_of_application}人`} /> }
        </CardContent>
        {/* ボタン系 */}
        <CardActions>
          {/* <LabelButton label="詳細を見る" variant="outlined" size="small" onClick={() => goDetailPage()} />
          <LabelButton label="質問したい" variant="outlined" size="small" />
          <LabelButton label="参加申請" variant="outlined" size="small" onClick={() => setConfirmFlag(true)} /> */}
          {/* 参加申請の確認ダイアログ */}
          {/* <JoinConfirmDialog open={confirmFlag} handleClose={() => setConfirmFlag(false)} /> */}
        </CardActions>
        {/* ユーザー情報 */}
        <CardContent>
          <UserInfo username={project_data.user.user_name} />
        </CardContent>
      </StyledCardActionArea>
    </StyledCard>
  );
};

export default ProjectCard;
