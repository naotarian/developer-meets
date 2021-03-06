import React from 'react';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';

const JoinConfirmDialog = ({ open, handleClose, data, sendJoinRequests }) => {
  return (
    <Dialog
      open={open}
      onClose={handleClose}
      aria-labelledby="alert-dialog-title"
      aria-describedby="alert-dialog-description"
    >
      <DialogTitle id="alert-dialog-title">
        {data && data.project_name}
      </DialogTitle>
      <DialogContent>
        <DialogContentText id="alert-dialog-description">
          このプロジェクトへの参加を申請しますか？
        </DialogContentText>
      </DialogContent>
      <DialogActions>
        <Button
          variant="outlined"
          onClick={sendJoinRequests}
        >
          申請する
        </Button>
        <Button
          variant="outlined"
          onClick={handleClose}
        >
          キャンセル
        </Button>
      </DialogActions>
    </Dialog>
  );
};

export default JoinConfirmDialog;
