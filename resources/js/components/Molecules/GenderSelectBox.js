import React from 'react';
import styled from 'styled-components';
import Box from '@mui/material/Box';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';

const StyledInputLabel = styled(InputLabel)`
  font-size: 0.9rem !important;
`;

const StyledSelect = styled(Select)`
  font-size: 0.9rem !important;
  height: 45px;
`;

const StyledMenuItem = styled(MenuItem)`
  font-size: 0.8rem !important;
`;

const GenderSelectBox = ({ searchGender, setSearchGender }) => {
  const handleChange = (event) => {
    setSearchGender(event.target.value);
  };

  return (
    <Box sx={{ m: 1, minWidth: 120 }}>
      <FormControl fullWidth>
        <StyledInputLabel id="男女構成-label">男女構成</StyledInputLabel>
        <StyledSelect
          labelId="男女構成-label"
          id="男女構成-select"
          value={searchGender}
          label="男女構成"
          onChange={handleChange}
        >
          <StyledMenuItem value={'制限なし'}>制限なし</StyledMenuItem>
          <StyledMenuItem value={'男性のみ'}>男性のみ</StyledMenuItem>
          <StyledMenuItem value={'女性のみ'}>女性のみ</StyledMenuItem>
        </StyledSelect>
      </FormControl>
    </Box>
  );
};

export default GenderSelectBox;
