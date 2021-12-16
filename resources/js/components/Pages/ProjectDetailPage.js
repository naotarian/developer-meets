import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
import axios from 'axios';
import DetailHeader from '../Organisms/DetailHeader';
import DetailContent from '../Organisms/DetailContent';
import DetailComments from '../Organisms/DetailComments';
import ApplicationButton from '../Atoms/ApplicationButton';
import Notification from '../Atoms/Notification';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import ProgressCircular from '../Molecules/ProgressCircular';
import Grid from '@mui/material/Grid';
import Card from '@mui/material/Card';
import { grey } from '@mui/material/colors';

const WrapperGrid = styled(Grid)`
  width: 80%;
  margin: auto;
  max-width: 1000px;
  margin-top: 4rem;
  margin-bottom: 4rem;
`;

const DisableTextGrid = styled(Grid)`
  text-align: center;
  background: ${grey[500]};
  border-radius: 2rem;
  padding: 1rem;
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
  const [loading, setLoading] = useState(false);
  const [notificationLevel, setNotificationLevel] = useState('');
  const [notificationText, setNotificationText] = useState('');

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

  const pushNotification = (level, text) => {
    setNotificationLevel(level);
    setNotificationText(text);
  };

  const closeNotification = () => {
    setNotificationLevel('');
    setNotificationText('');
  };

  const postComment = async (comment) => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/api/comment`;
    let d = {
      'project_id': data.id,
      'target_user_id': null, // メンション機能は別途実装
      'comment': comment,
    };

    let level;
    let text;
    setLoading(true);
    try {
      await axios.post(url, d).then(res => {
        if (res.data.status_code !== 200) throw 'コメントの投稿に失敗しました';
        setComments(res.data.comments.reverse());
      });
      level = 'success';
      text = 'コメントを投稿しました';
    } catch (e) {
      level = 'error';
      text = e;
    } finally {
      setLoading(false);
      pushNotification(level, text);
    }
  };

  const deleteComment = async (id) => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/api/comment`;
    let d = { 'comment_id': id };

    let level;
    let text;
    setLoading(true);
    try {
      await axios.delete(url, { data: d }).then(res => {
        if (res.data.status_code !== 200) throw 'コメントの削除に失敗しました';
        setComments(res.data.comments.reverse());
      });
      level = 'success';
      text = 'コメントを削除しました';
    } catch (e) {
      level = 'error';
      text = e;
    } finally {
      setLoading(false);
      pushNotification(level, text);
    }
  };

  const sendJoinRequests = async () => {
    let protocol = host === 'developer-meets.com' ? 'https' : 'http';
    let url = `${protocol}://${host}/api/application`;

    let level;
    let text;
    setLoading(true);
    try {
      await axios.post(url, data).then(res => {
        if (res.data.status_code !== 200) throw '参加申請に失敗しました';
        setApplyFlag(res.data.flag);
      });
      level = 'success';
      text = 'プロジェクトへの参加を申請しました';
    } catch (e) {
      level = 'error';
      text = e;
    } finally {
      setLoading(false);
      setConfirmFlag(false);
      pushNotification(level, text);
    }
  };

  return (
    <React.Fragment>
      {data &&
        <WrapperGrid >
          {data.status !== '募集中' && <DisableTextGrid>このプロジェクトは募集終了しています</DisableTextGrid>}
          <ContentContainer sx={{ filter: data.status !== '募集中' && 'grayscale(1)' }}>
            <DetailHeader data={data} userImgPath={userImgPath} projectImgPath={projectImgPath} />
          </ContentContainer>
          <ApplicationButton
            applyFlag={applyFlag}
            openConfirmDialog={() => setConfirmFlag(true)}
            status={data.status}
          />
          <ContentContainer sx={{ filter: data.status !== '募集中' && 'grayscale(1)' }}>
            <DetailContent data={data} />
          </ContentContainer>
          <ContentContainer sx={{ filter: data.status !== '募集中' && 'grayscale(1)' }}>
            <DetailComments comments={comments} postComment={postComment} deleteComment={deleteComment} loginUser={loginUser} />
          </ContentContainer>
        </WrapperGrid>
      }
      <JoinConfirmDialog
        open={confirmFlag}
        data={data}
        sendJoinRequests={sendJoinRequests}
        handleClose={() => setConfirmFlag(false)}
      />
      <ProgressCircular loading={loading} />
      <Notification onClose={closeNotification} level={notificationLevel} text={notificationText} />
    </React.Fragment>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));