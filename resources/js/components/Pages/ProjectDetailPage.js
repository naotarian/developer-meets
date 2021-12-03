import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import DetailHeader from '../Organisms/DetailHeader';
import DetailContent from '../Organisms/DetailContent';
import DetailComments from '../Organisms/DetailComments';
import ApplicationButton from '../Atoms/ApplicationButton';
import QuestionButton from '../Atoms/QuestionButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Grid from '@mui/material/Grid';
import Card from '@mui/material/Card';

const WrapperGrid = styled(Grid)`
  width: 80%;
  margin: auto;
  margin-top: 4rem;
  margin-bottom: 4rem;
`;

const ContentContainer = styled(Card)`
  width: 100%;
  height: auto;
  border: 1px solid #e2e2e2;
  margin-top: 2rem;
  margin-bottom: 2rem;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState(null);
  const [userImgPath, setUserImgPath] = useState(null);
  const [projectImgPath, setProjectImgPath] = useState(null);
  const [applyFlag, setApplyFlag] = useState('');
  const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(() => {
    setHost(location.host);
  }, []);

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let projectId = location.pathname.replace('/seek/detail/', '');
      let url = `${protocol}://${host}/api/detail/${projectId}`;
      axios.get(url).then(res => {
        setData(res.data);
        setApplyFlag(res.data.application_flag);
        setUserImgPath(`${protocol}://${host}/api/user_icon/${res.data.created_by.id}`);
        setProjectImgPath(`${protocol}://${host}/api/project_image/${res.data.id}`);
      });
    }
  }, [host]);

  return (
    <React.Fragment>
      { data &&
        <WrapperGrid>
          <ContentContainer>
            <DetailHeader data={data} userImgPath={userImgPath} projectImgPath={projectImgPath} />
          </ContentContainer>
          <Grid container>
            <ApplicationButton item openConfirmDialog={() => setConfirmFlag(true)} applyFlag={applyFlag} />
            <QuestionButton item/>
          </Grid>
          <ContentContainer>
            <DetailContent data={data} />
          </ContentContainer>
        </WrapperGrid>
      }
      <JoinConfirmDialog
        open={confirmFlag}
        data={data}
        host={host}
        handleClose={() => setConfirmFlag(false)}
        setApplyFlag={(f) => setApplyFlag(f)}
      />
    </React.Fragment>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
