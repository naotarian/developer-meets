import React, { useState, useEffect } from 'react';
import styled from "styled-components";
import LanguageSelectBox from '../Molecules/LanguageSelectBox';
import PurposeSelectBox from '../Molecules/PurposeSelectBox';
import GenderSelectBox from '../Molecules/GenderSelectBox';
import Grid from '@mui/material/Grid';
import LaptopChromebookIcon from '@mui/icons-material/LaptopChromebook';
import CommentOutlinedIcon from '@mui/icons-material/CommentOutlined';
import PeopleAltOutlinedIcon from '@mui/icons-material/PeopleAltOutlined';
import { grey } from '@mui/material/colors';


const ContainerGrid = styled(Grid)`
  width: 100%;
  background-color: #f6f8fa;
  padding-top: 10px;
  padding-bottom: 10px;
  margin-bottom: 30px;
`;

const FilterContainer = ({ searchLanguage, setSearchLanguage, searchPurpose, setSearchPurpose, searchGender, setSearchGender }) => {

  return (
    <ContainerGrid container justifyContent='center' alignItems='center'>
      <LaptopChromebookIcon fontSize='large' style={{ color: grey[500], margin: 'auto 0' }} />
      <LanguageSelectBox item searchLanguage={searchLanguage} setSearchLanguage={setSearchLanguage} />
      <CommentOutlinedIcon fontSize='large' style={{ color: grey[500], margin: 'auto 0' }} />
      <PurposeSelectBox item searchPurpose={searchPurpose} setSearchPurpose={setSearchPurpose} />
      <PeopleAltOutlinedIcon fontSize='large' style={{ color: grey[500], margin: 'auto 0' }} />
      <GenderSelectBox item searchGender={searchGender} setSearchGender={setSearchGender} />
    </ContainerGrid>
  );
};

export default FilterContainer;
