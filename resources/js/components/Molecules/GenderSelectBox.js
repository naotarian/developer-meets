import React from 'react';
import Box from '@mui/material/Box';
import InputLabel from '@mui/material/InputLabel';
import MenuItem from '@mui/material/MenuItem';
import FormControl from '@mui/material/FormControl';
import Select from '@mui/material/Select';

const GenderSelectBox = ({ searchGender, setSearchGender }) => {
  const handleChange = (event) => {
    setSearchGender(event.target.value);
  };

  return (
    <Box sx={{ minWidth: 120, marginLeft: 3, marginRight: 3 }}>
      <FormControl fullWidth>
        <InputLabel id="simple-select-label">男女構成</InputLabel>
        <Select
          labelId="simple-select-label"
          id="simple-select"
          value={searchGender}
          label="男女構成"
          onChange={handleChange}
        >
          <MenuItem value={'制限なし'}>制限なし</MenuItem>
          <MenuItem value={'男性のみ'}>男性のみ</MenuItem>
          <MenuItem value={'女性のみ'}>女性のみ</MenuItem>
        </Select>
      </FormControl>
    </Box>
  );
}

export default GenderSelectBox;