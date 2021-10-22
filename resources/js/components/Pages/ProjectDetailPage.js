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
  // const { project_id } = props;
  // const [confirmFlag, setConfirmFlag] = useState(false);
  useEffect(()=> {
    // let url = location.href.replace('seek', 'api')
    axios.get(`http://localhost/api/detail/1`)
      .then(res => {
        let response = res.data;
        console.log('===ここにデータが帰って来ればOK===')
        console.log('responce: ', response)
      });
  }, [])

  return (
    <ContainerGrid>
      詳細コンポーネント
    </ContainerGrid>
  );
};

export default ProjectDetailPage;

ReactDOM.render(<ProjectDetailPage />, document.getElementById('project_detail'));
