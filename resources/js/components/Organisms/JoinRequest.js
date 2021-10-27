import React, { useState } from 'react';
import axios from 'axios';
import LabelButton from '../Atoms/LabelButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';

const JoinRequest = ({ host, postdata }) => {
  const [confirmFlag, setConfirmFlag] = useState(false);

  const sendRequest = () => {
    console.log('>>参加申請API発火');
    console.log('渡してるdata: ', postdata);
    console.log('渡してるdata型: ', typeof postdata);
    if (host && postdata) {
      try {
        let url = `http://${host}/api/application`;
        axios.post(url, postdata).then(res => {
          console.log('res.data: ', res.data)
        });
      } catch (e) {
        console.error('エラー: ', e);
      } finally {
        setConfirmFlag(false);
      }
    }
  }

  return (
    <>
      <LabelButton label="参加申請" variant="outlined" size="small" onClick={() => setConfirmFlag(true)} />
      <JoinConfirmDialog open={confirmFlag} handleClose={() => setConfirmFlag(false)} handleSend={() => sendRequest()} />
    </>
  );
};

export default JoinRequest;
