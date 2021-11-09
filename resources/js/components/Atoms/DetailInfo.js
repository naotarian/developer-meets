import React from 'react';
import styled from "styled-components";
import Card from '@mui/material/Card';
import Grid from '@mui/material/Grid';
import { green } from '@mui/material/colors';

const StyledCard = styled(Card)`
  min-width: 140px;
  height: 75px;
  padding: 0.7rem 1rem 0 1rem;
  border: 2px solid ${green[500]}!important;
  border-radius:20px!important;
  margin: 0.25rem 0.5rem;
`;

const FontColorGreenGrid = styled(Grid)`
  color: ${green[500]};
`;

const DetailInfo = ({ title, value }) => {
  return (
    <StyledCard variant="outlined" sx={{ width: { xs: '100%', sm: '140px'} }} >
      <FontColorGreenGrid>{title}</FontColorGreenGrid>
      {value ? value : '全国'}
    </StyledCard>
  );
}

export default DetailInfo;
