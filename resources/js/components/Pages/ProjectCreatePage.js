import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import styled from 'styled-components';
// import axios from 'axios';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';
import TextField from '@mui/material/TextField';
// import InputLabel from '@mui/material/InputLabel';
// import MenuItem from '@mui/material/MenuItem';
// import FormControl from '@mui/material/FormControl';
// import Select from '@mui/material/Select';


const WrapperGrid = styled(Grid)`
  width: 90%;
  margin: auto;
  margin-top: 4rem;
  margin-bottom: 4rem;
`;

const PageTitle = styled(Typography)`
  text-align: center;
`;

const InputFormGrid = styled(Grid)`
  margin-top: 2rem;
`;

const InputProjectTitle= styled(TextField)`
  margin: 1.5rem 1rem !important;
`;

const ProjectCreatePage = () => {
  const [host, setHost] = useState('');

  useEffect(() => {
    setHost(location.host);
  }, []);

  useEffect(() => {
    if (host) {
      let protocol = host === 'developer-meets.com' ? 'https' : 'http';
      let projectId = location.pathname.replace('/seek/detail/', '');
      let url = `${protocol}://${host}/api/detail/${projectId}`;
      console.log(url);
    }
  }, [host]);


  return (
    <WrapperGrid>
      <PageTitle variant='h4'>新規プロジェクト作成</PageTitle>
      <InputFormGrid container >
        <InputProjectTitle id="" label="プロジェクト名" variant="outlined" sx={{ width: { xs: 'calc(100% - 2rem)', md: 'calc(50% - 2rem)' } }} />

      </InputFormGrid>
    </WrapperGrid>
  );
};

export default ProjectCreatePage;

ReactDOM.render(<ProjectCreatePage />, document.getElementById('project_create'));