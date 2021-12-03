import React from 'react';
import styled from 'styled-components';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const WrapperGrid = styled(Grid)`
  padding: 1rem;
`;

const DetailContent = ({ data }) => {
  return (
    <WrapperGrid>
      <Typography>▼案件詳細</Typography>
      <Typography>{data && data.project_detail}</Typography>
    </WrapperGrid>
  );
};

export default DetailContent;
