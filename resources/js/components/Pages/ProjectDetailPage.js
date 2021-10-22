import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from "styled-components";
import axios from 'axios';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: 100%;
`;

const ProjectDetailPage = () => {
  const [host, setHost] = useState('');
  const [data, setData] = useState(null);
  // const { project_id } = props;
  // const [confirmFlag, setConfirmFlag] = useState(false);
  useEffect(()=> {
    setHost(location.host)
    // let url = location.href.replace('seek', 'api')

  }, [])

  useEffect(() => {
    if (host) {
      axios.get(`http://${host}/api/detail/1`)
        .then(res => {
          setData(res.data)
        });
    }
  }, [host])

  return (
    <ContainerGrid>
      詳細コンポーネント
      帰ってきたデータたち
      <Grid>{data ? data : 'データなし'}</Grid>
    </ContainerGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
