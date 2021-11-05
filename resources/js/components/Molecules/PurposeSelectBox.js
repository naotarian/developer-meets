import React from 'react';
import styled from "styled-components";
import Box from '@mui/material/Box';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';

const StyledInputLabel = styled(InputLabel)`
  font-size: 0.7rem !important;
`;

const StyledSelect = styled(Select)`
  font-size: 0.9rem !important;
  height: 45px;
`;

const StyledMenuItem = styled(MenuItem)`
  font-size: 0.8rem !important;
`;

const PurposeSelectBox = ({ searchPurpose, setSearchPurpose }) => {
  const handleChange = (event) => {
    setSearchPurpose(event.target.value);
  };

  return (
    <Box sx={{ m: 1, minWidth: 120 }}>
      <FormControl fullWidth>
        <StyledInputLabel id="目的-label">目的</StyledInputLabel>
        <StyledSelect
          labelId="目的-label"
          id="目的-select"
          value={searchPurpose}
          label="目的"
          onChange={handleChange}
        >
          <StyledMenuItem value={'繋がり'}>繋がり</StyledMenuItem>
          <StyledMenuItem value={'リリース'}>リリース</StyledMenuItem>
          <StyledMenuItem value={'学習'}>学習</StyledMenuItem>
          <StyledMenuItem value={'ワイワイ'}>わいわい</StyledMenuItem>
          <StyledMenuItem value={'すべて'}>指定なし</StyledMenuItem>
        </StyledSelect>
      </FormControl>
    </Box>
  );
}

export default PurposeSelectBox;
