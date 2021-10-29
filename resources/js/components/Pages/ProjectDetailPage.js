import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import LabelButton from '../Atoms/LabelButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import SkillTags from '../Molecules/SkillTags';
import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import { green } from '@mui/material/colors';
import ApplicationButton from '../Atoms/ApplicationButton';
import QuestionButton from '../Atoms/QuestionButton';
import MediaQuery from "react-responsive";


const WrapperGrid = styled(Grid)
`
  width: 80%;
  height: auto;
  margin: 0 auto;
`;
const ContainerGrid = styled(Grid)
`
  width: 100%;
  height: auto;
  margin-bottom: 2rem;
  border: 1px solid #e2e2e2;
`;
const DetailContainer = styled(Grid)
`
  width: 100%;
  height: auto;
  margin-bottom: 2rem;
  border: 1px solid #e2e2e2;
  padding: 1.5rem;
`;
const FlexGrid = styled(Grid)
`
  width: 100%;
  display: flex;
  justify-content:flex-start;
`;
const FlexGridSp = styled(Grid)
`
  width: 100%;
  display: block;
`;
const StyledCard = styled(Card)
`
  width: 20%;
  height: 100px;
  padding: 0.7rem 1rem 0 1rem;
  border: 2px solid ${green[500]}!important;
  border-radius:20px!important;
  margin-left: 2rem;
  margin-bottom: 2rem;
`;
const StyledCardSp = styled(Card)
`
  width: 90%;
  height: 100px;
  padding: 0.7rem 1rem 0 1rem;
  border: 2px solid ${green[500]}!important;
  border-radius:20px!important;
  margin-left: 1rem;
  margin-bottom: 2rem;
`;
const FontColorGreenGrid = styled(Grid)
`
  color: ${green[500]};
`;
const ProjectName = styled(Grid)
`
  margin-left: 2rem;
  font-weight: bold;
  font-size: 1.6rem;
  margin-bottom: 1rem;
`;
const ProjectNameSp = styled(Grid)
`
  margin-left: 1rem;
  margin-right:1rem;
  margin-top: 1.5rem;
  font-weight: bold;
  font-size: 1.2rem;
  margin-bottom: 1rem;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [buttonText, setbuttonText] = useState('参加申請する');
  const [data, setData] = useState(null);
  const [confirmFlag, setConfirmFlag] = useState(false);


  useEffect(() => {
    setHost(location.host)
  }, [])

  useEffect(() => {
    if (host) {
      var param = location.pathname;
      param = param.replace('/seek/detail/', '');
      console.log('ここです')
      let url = `http://${host}/api/detail/${param}`
      axios.get(url).then(res => {
        if (res.data['application_flag'] == 1) {
          console.log("d");
          setbuttonText('申請済み');
        }
        if (res.data['application_flag'] == 3) {

          setbuttonText('公開済み');
        }
        setData(res.data)
      });
    }
  }, [host])

  return (
    <WrapperGrid>
      <ContainerGrid>
        
        
        <MediaQuery query="(min-width: 767px)">
          <img src="/images/share/no_image.jpeg" alt="noimage" height="350" width="100%"/>
          {data &&
            <SkillTags skills={[data.language, data.sub_language]} detail/>
          }
          <ProjectName>{data &&data.project_name}</ProjectName>
          <FlexGrid>
            <StyledCard variant="outlined">
              <FontColorGreenGrid>稼働時間</FontColorGreenGrid>
              {data &&data.work_frequency}
            </StyledCard>
            <StyledCard variant="outlined">
              <FontColorGreenGrid>募集人数</FontColorGreenGrid>
              {data &&data.number_of_application}人
            </StyledCard>
            <StyledCard variant="outlined">
              <FontColorGreenGrid>エンジニア歴</FontColorGreenGrid>
              {data &&data.minimum_experience}年以上
            </StyledCard>
            <StyledCard variant="outlined">
              <FontColorGreenGrid>エリア</FontColorGreenGrid>
              全国<br />フルリモート(在宅)
            </StyledCard>
          </FlexGrid>
        </MediaQuery>
        <MediaQuery query="(max-width: 767px)">
          <img src="/images/share/no_image.jpeg" alt="noimage" height="200" width="100%"/>
          {data &&
            <SkillTags skills={[data.language, data.sub_language]} detail/>
          }
          <ProjectNameSp>{data &&data.project_name}</ProjectNameSp>
          <FlexGridSp>
            <StyledCardSp variant="outlined">
              <FontColorGreenGrid>稼働時間</FontColorGreenGrid>
              {data &&data.work_frequency}
            </StyledCardSp>
            <StyledCardSp variant="outlined">
              <FontColorGreenGrid>募集人数</FontColorGreenGrid>
              {data &&data.number_of_application}人
            </StyledCardSp>
            <StyledCardSp variant="outlined">
              <FontColorGreenGrid>エンジニア歴</FontColorGreenGrid>
              {data &&data.minimum_experience}年以上
            </StyledCardSp>
            <StyledCardSp variant="outlined">
              <FontColorGreenGrid>エリア</FontColorGreenGrid>
              全国<br />フルリモート(在宅)
            </StyledCardSp>
          </FlexGridSp>
        </MediaQuery>
      </ContainerGrid>
      <ApplicationButton onClick={() => setConfirmFlag(true)} variant="contained" size="large" text={buttonText} />
      <QuestionButton variant="outlined" size="large" />
      <JoinConfirmDialog open={confirmFlag} handleClose={() => setConfirmFlag(false)} data={data} host={host} />
      <DetailContainer>
        <Typography>▼案件詳細</Typography>
        <Typography>{data && data.project_detail}</Typography>
      </DetailContainer>
    </WrapperGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
