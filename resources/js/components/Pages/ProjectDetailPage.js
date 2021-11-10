import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import DetailHeader from '../Organisms/DetailHeader';
import ApplicationButton from '../Atoms/ApplicationButton';
import QuestionButton from '../Atoms/QuestionButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Grid from '@mui/material/Grid';
import Card from '@mui/material/Card';
import Typography from '@mui/material/Typography';

const WrapperGrid = styled(Grid)`
  width: 80%;
  margin: auto;
  margin-top: 4rem;
`;

const ButtonsContainer = styled(Grid)`
  margin-top: 2rem;
  margin-bottom: 2rem;
`;

const DetailContainer = styled(Card)`
  width: 100%;
  height: auto;
  border: 1px solid #e2e2e2;
  padding: 1.5rem;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState(null);
  const [applyFlag, setApplyFlag] = useState('');
  const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(() => {
    setHost(location.host)
  }, [])

  useEffect(() => {
    if (host) {
      let param = location.pathname;
      param = param.replace('/seek/detail/', '');
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let url = `${protocol}://${host}/api/detail/${param}`
      axios.get(url).then(res => {
        setData(res.data);
        setApplyFlag(res.data.application_flag);
      });
    };
  }, [host])

  return (
    <React.Fragment>
      { data &&
        <WrapperGrid>
          <DetailHeader data={data} />
          <ButtonsContainer container>
            <ApplicationButton
              item
              openConfirmDialog={() => setConfirmFlag(true)}
              applyFlag={applyFlag}
            />
            <QuestionButton item/>
          </ButtonsContainer>
          <JoinConfirmDialog
            open={confirmFlag}
            data={data}
            host={host}
            handleClose={() => setConfirmFlag(false)}
            setApplyFlag={(f) => setApplyFlag(f)}
          />
          <DetailContainer>
            <Typography>▼案件詳細</Typography>
            <Typography>{data && data.project_detail}</Typography>
          </DetailContainer>
        </WrapperGrid>
      }
    </React.Fragment>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
