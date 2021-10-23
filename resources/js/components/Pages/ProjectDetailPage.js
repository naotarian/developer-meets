import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import LabelButton from '../Atoms/LabelButton';
import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: 100%;
  background-color: red;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState(null);
  const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(()=> {
    setHost(location.host)
  }, [])

  useEffect(() => {
    if (host) {
      let url = `http://${host}/api/detail/1`
      axios.get(url).then(res => {
        console.log(res.data)
        setData(res.data)
      });
    }
  }, [host])

  return (
    <ContainerGrid>
      <Typography>id: {data ? data.id : ''}</Typography>
      <Typography>project_name: { data? data.project_name : ''}</Typography>
      <Typography>project_detail: {data ? data.project_detail : ''}</Typography>
      <Typography>remarks: {data ? data.remarks : ''}</Typography>
      <Typography>created_at: {data ? data.created_at : ''}</Typography>
      <Typography>language: {data ? data.language : ''}</Typography>
      <Typography>sub_language: {data ? data.sub_language : ''}</Typography>
      <Typography>tools: {data ? data.tools : ''}</Typography>
      <Typography>max_years_old: {data ? data.max_years_old : ''}</Typography>
      <Typography>minimum_years_old: {data ? data.minimum_years_old : ''}</Typography>
      <Typography>men_and_women: {data ? data.men_and_women : ''}</Typography>
      <Typography>number_of_application: {data ? data.number_of_application : ''}</Typography>
      <Typography>purpose: {data ? data.purpose : ''}</Typography>
      <Typography>user_id: {data ? data.user_id : ''}</Typography>
      <LabelButton label="質問したい" variant="outlined" size="small" />
      <LabelButton label="参加申請" variant="outlined" size="small" onClick={() => setConfirmFlag(true)} />
      <JoinConfirmDialog open={confirmFlag} handleClose={() => setConfirmFlag(false)} />
    </ContainerGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
