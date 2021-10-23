import React from 'react';
import Button from '@mui/material/Button';
import Dialog from '@mui/material/Dialog';
import DialogActions from '@mui/material/DialogActions';
import DialogContent from '@mui/material/DialogContent';
import DialogContentText from '@mui/material/DialogContentText';
import DialogTitle from '@mui/material/DialogTitle';

const JoinConfirmDialog = ({ open, handleClose, handleSend }) => {
  return (
      <Dialog
        open={open}
        onClose={handleClose}
        aria-labelledby="alert-dialog-title"
        aria-describedby="alert-dialog-description"
      >
        <DialogTitle id="alert-dialog-title">
          {"プロジェクト名"}
        </DialogTitle>
        <DialogContent>
          <DialogContentText id="alert-dialog-description">
            このプロジェクトへの参加を申請しますか？
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button
            variant="outlined"
            onClick={handleSend}
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
