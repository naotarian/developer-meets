import React, { useState, useEffect } from 'react';
import styled from 'styled-components';
import UserIcon from '../Atoms/UserIcon';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import Button from '@mui/material/Button';
import TextField from '@mui/material/TextField';
import Divider from '@mui/material/Divider';
import CommentOutlinedIcon from '@mui/icons-material/CommentOutlined';

const CommentNum = styled.span`
  font-weight: bold;
  margin-left: 0.5rem;
`;

const CommentGrid = styled(Grid)`
  width: 100%;
  padding: 0.8rem;
`;

const IconBox = styled.div`
  margin-right: 1rem;
`;

const StyledTextField = styled(TextField)`
  padding: 0 !important;
  & fieldset {
    display: none;
  }
`;

const CountText = styled(Grid)`
  text-align: right;
  font-size: 0.8rem;
`;

const PostButton = styled(Button)`
  outline: none !important;
  width: 50%;
  margin: auto !important;
  display: block !important;
`;

const CommentUserName = styled.a`
  font-weight: bold !important;
  display: inline-block;
  text-decoration: none;
  color: #000000;
  &:hover {
    color: #000000;
  }
`;

const CommentText = styled(Typography)`
  font-size: 0.8rem !important;
  white-space: pre;
`;

const EditButton = styled(Button)`
  height: 1rem;
  outline: none !important;
`;

const DeleteButton = styled(Button)`
  height: 1rem;
  outline: none !important;
`;

const DetailComments = ({ comments, postComment, deleteComment, loginUser }) => {
  const [inputText, setInputText] = useState('');
  const [error, setError] = useState(false);
  const InputErrorStyle = { border: '1px solid red', borderRadius: '4px' };
  const InputStyle = { border: '1px solid #000000', borderRadius: '4px' };
  const InputDiableStyle = { border: '1px solid #e2e2e2', borderRadius: '4px' };
  const ButtonDisableStyle = { color: '#e2e2e2', border: '1px solid #e2e2e2' };
  const ButtonStyle = { color: '#000000', border: '1px solid #000000' };

  const handleChange = (e) => {
    setInputText(e.target.value);
  };

  useEffect(()=> {
    setError(inputText.length > 500 ? true : false);
  }, [inputText]);

  return (
    <React.Fragment>
      <CommentGrid>
        <CommentOutlinedIcon /><CommentNum>{comments.length}</CommentNum>
        <Grid container flexWrap='nowrap'>
          <IconBox><UserIcon size={30} imgPath={loginUser && `/api/user_icon/${loginUser.id}`} /></IconBox>
          <Grid sx={{width: '100%'}}>
            <StyledTextField
              fullWidth
              multiline
              value={inputText}
              onChange={handleChange}
              error={error}
              style={loginUser ? (error ? InputErrorStyle : InputStyle) : InputDiableStyle}
              disabled={loginUser ? false : true}
              placeholder={loginUser ? '' : 'ログインしてコメントする'}
            />
            <CountText>{inputText.length}/500</CountText>
            <PostButton
              variant="outlined"
              onClick={() => {
                postComment(inputText);
                setInputText('');
              }}
              disabled={inputText.length > 0 && inputText.length <= 500 ? false : true}
              style={inputText.length > 0 && inputText.length <= 500 ? ButtonStyle : ButtonDisableStyle}
            >
              投稿する
            </PostButton>
          </Grid>
        </Grid>
      </CommentGrid>
      <Divider />
      {comments.length > 0 && comments.map((val, index) => {
        return (
          <React.Fragment key={index}>
            <CommentGrid container flexWrap='nowrap'>
              <IconBox>
                <a href={`/user_info/${val.user.user_name}`}>
                  <UserIcon size={30} imgPath={`/api/user_icon/${val.user.id}`} />
                </a>
              </IconBox>
              <Grid sx={{width: '100%'}}>
                <CommentUserName href={`/user_info/${val.user.user_name}`}>{val.user.user_name}</CommentUserName>
                <CommentText>{val && val.comment}</CommentText>
              </Grid>
              {loginUser && loginUser.id === val.user.id &&
                <Grid container flexDirection='column' justifyContent='flex-end' sx={{ width: 'fit-content' }}>
                  {/* <EditButton>編集</EditButton> */}
                  <DeleteButton onClick={() => deleteComment(val.id)}>削除</DeleteButton>
                </Grid>
              }
            </CommentGrid>
            <Divider />
          </React.Fragment>
        );
      })}
    </React.Fragment>
  );
};

export default DetailComments;
