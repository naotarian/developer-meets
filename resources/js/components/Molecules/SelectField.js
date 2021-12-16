import React from 'react';
import InputLabel from '@mui/material/InputLabel';
import Select from '@mui/material/Select';
import MenuItem from '@mui/material/MenuItem';
import FormHelperText from '@mui/material/FormHelperText';
import FormControl from '@mui/material/FormControl';

const SelectField = ({ label, items, value, onChange, required, submit }) => {

  const handleChange = (e) => {
    onChange(e.target.value);
  };

  return (
    <FormControl
      variant='outlined'
      sx={{
        m: '1rem',
        width: { xs: 'calc(100% - 2rem)', md: 'calc(50% - 2rem)' }
      }}
    >
      <InputLabel htmlFor={`input-${label}`}>{label}</InputLabel>
      <Select
        label={label}
        value={value}
        error={submit && !value}
        onChange={handleChange}
      >
        {items.map(item => {
          return <MenuItem key={`key-${item}`} value={item}>{item}</MenuItem>;
        })}
      </Select>
      <FormHelperText id={`input-${label}`}>{required ? '*必須項目です' : ' '}</FormHelperText>
    </FormControl>
  );
};

export default SelectField;
