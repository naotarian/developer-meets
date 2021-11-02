import React, { useState, useEffect } from 'react';
import styled from "styled-components";
import Grid from '@mui/material/Grid';
import LanguageSelectBox from '../Molecules/LanguageSelectBox';

const ContainerGrid = styled(Grid)`
  width: 100%;
  height: 100px;
  background-color: #f6f8fa;
`;

const FilterContainer = ({ searchLanguage, setSearchLanguage }) => {

  return (
    <ContainerGrid container justifyContent="center" alignItems="center">
      <LanguageSelectBox item searchLanguage={searchLanguage} setSearchLanguage={setSearchLanguage} />
    </ContainerGrid>
  );
};

export default FilterContainer;
