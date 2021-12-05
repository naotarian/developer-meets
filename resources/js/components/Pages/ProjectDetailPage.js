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
  const [comments, setComments] = useState([]);
  const [loginUser, setLoginUser] = useState(null);

  useEffect(() => {
    setHost(location.host);
  }, []);

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      // GET プロジェクト詳細
      let projectId = location.pathname.replace('/seek/detail/', '');
      let url = `${protocol}://${host}/api/detail/${projectId}`;
      axios.get(url).then(res => {
        setData(res.data);
        setApplyFlag(res.data.application_flag);
        setUserImgPath(`${protocol}://${host}/api/user_icon/${res.data.created_by.id}`);
        setProjectImgPath(`${protocol}://${host}/api/project_image/${res.data.id}`);
        setComments(res.data.comments.reverse());
      });
      url = `${protocol}://${host}/api/login_user_info`;
      axios.get(url).then(res => {
        setLoginUser(res.data.user ? res.data.user : null);
      });
    }
  }, [host]);

  const postComment = async(text) => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/api/comment`;
    let d = {
      'project_id': data.id,
      'target_user_id': null, // メンション機能は別途実装
      'comment': text,
    };
    await axios.post(url, d).then(res => {
      setComments(res.data.comments.reverse());
    });
  };

  const deleteComment = async(id) => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/api/comment`;
    let d = { 'comment_id': id };
    await axios.delete(url, { data: d }).then(res => {
      setComments(res.data.comments.reverse());
    });
  };

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
          <ContentContainer>
            <DetailComments comments={comments} postComment={postComment} deleteComment={deleteComment} loginUser={loginUser} />
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
