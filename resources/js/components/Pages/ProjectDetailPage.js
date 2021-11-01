import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import DetailHeader from '../Organisms/DetailHeader';
import ApplicationButton from '../Atoms/ApplicationButton';
import QuestionButton from '../Atoms/QuestionButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import SkillTags from '../Molecules/SkillTags';
// import Box from '@mui/material/Box';
import Card from '@mui/material/Card';
import { green } from '@mui/material/colors';
// import MediaQuery from "react-responsive";


const WrapperGrid = styled(Grid)`
  width: 80%;
  margin: auto;
`;

const ButtonsContainer = styled(Grid)`
  margin-top: 2rem;
  margin-bottom: 2rem;
`;

const DetailContainer = styled(Grid)`
  width: 100%;
  height: auto;
  border: 1px solid #e2e2e2;
  padding: 1.5rem;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState(null);
  const [buttonText, setButtonText] = useState('');
  const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(() => {
    setHost(location.host)
  }, [])

  useEffect(() => {
    if (host) {
      var param = location.pathname;
      param = param.replace('/seek/detail/', '');
      let url = `http://${host}/api/detail/${param}`
      if (host === 'developer-meets.com') {
        url = `https://${host}/api/detail/${param}`
      }

      axios.get(url).then(res => {
        setData(res.data)
        // if (res.data['application_flag'] == 1) {
        //   setButtonText('申請済み');
        // }
        // if (res.data['application_flag'] == 3) {
        //   setButtonText('公開済み');
        // }
      });
    }
  }, [host])

  return (
    <WrapperGrid>
      { data && <DetailHeader data={data} /> }
      <ButtonsContainer container>
        <ApplicationButton
          item
          // text={buttonText}
          openConfirmDialog={() => setConfirmFlag(true)}
        />
        <QuestionButton item/>
      </ButtonsContainer>
      <JoinConfirmDialog
        open={confirmFlag}
        data={data}
        host={host}
        handleClose={() => setConfirmFlag(false)}
      />
      { data &&
        <DetailContainer>
          <Typography>▼案件詳細</Typography>
          <Typography>{data && data.project_detail}</Typography>
        </DetailContainer>
      }
    </WrapperGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
