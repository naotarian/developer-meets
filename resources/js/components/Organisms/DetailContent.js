import React from 'react';
import styled from 'styled-components';
import Grid from '@mui/material/Grid';
import Typography from '@mui/material/Typography';

const WrapperGrid = styled(Grid)`
  padding: 1rem;
`;

const Text = styled(Typography)`
  white-space: pre;
`;

const DetailContent = ({ data }) => {
  return (
    <WrapperGrid>
      <Typography>▼案件詳細</Typography>
      <Text>{data && data.project_detail}</Text>
      <br />
      <Typography>▼備考</Typography>
      <Text>{data && data.remarks}</Text>
    </WrapperGrid>
  );
};

export default DetailContent;
