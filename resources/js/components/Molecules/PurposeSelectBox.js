import React from 'react';
import Box from '@mui/material/Box';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';

const PurposeSelectBox = ({ searchPurpose, setSearchPurpose }) => {
  const handleChange = (event) => {
    setSearchPurpose(event.target.value);
  };

  return (
    <Box sx={{ minWidth: 120, marginLeft: 3, marginRight: 3 }}>
      <FormControl fullWidth>
        <InputLabel id="simple-select-label">目的</InputLabel>
        <Select
          labelId="simple-select-label"
          id="simple-select"
          value={searchPurpose}
          label="目的"
          onChange={handleChange}
        >
          <MenuItem value={'繋がり'}>繋がり</MenuItem>
          <MenuItem value={'リリース'}>リリース</MenuItem>
          <MenuItem value={'学習'}>学習</MenuItem>
          <MenuItem value={'ワイワイ'}>わいわい</MenuItem>
          <MenuItem value={'すべて'}>指定なし</MenuItem>
        </Select>
      </FormControl>
    </Box>
  );
}

export default PurposeSelectBox;