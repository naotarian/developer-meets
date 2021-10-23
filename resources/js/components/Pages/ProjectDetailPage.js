import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import LabelButton from '../Atoms/LabelButton';
// import JoinConfirmDialog from '../Molecules/JoinConfirmDialog';
import JoinRequest from '../Organisms/JoinRequest';
import Grid from '@mui/material/Grid';

const ContainerGrid = styled(Grid)`
  width: max-content;
  max-width: 1040px;
  margin: auto;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [path, setPath] = useState('');
  const [data, setData] = useState(null);
  const [confirmFlag, setConfirmFlag] = useState(false);

  useEffect(()=> {
    setHost(location.host);
    setPath(location.pathname);
  }, []);

  useEffect(() => {
    if (host && path) {
      let p_id = path.replace('/seek/detail/', '');
      let url = `http://${host}/api/detail/${p_id}`;
      try {
        axios.get(url).then(res => {
          setData(res.data);
        });
      } catch (e) {
        console.error(e);
      }
    }
  }, [host, path]);

  return (
    <ContainerGrid>
      <JoinRequest host={host} postdata={data} />
      <LabelButton label="質問したい" variant="outlined" size="small" />
    </ContainerGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
