import React from 'react';
import styled from 'styled-components';
import TextField from '@mui/material/TextField';
import MenuItem from '@mui/material/MenuItem';

const StyledTextField = styled(TextField)`
  margin: 1.5rem 1rem !important;
`;

const InputField = ({ label, items, value, onChange, select, multiline, fullWidth, error }) => {

  const handleChange = (e) => {
    console.log(e.target.value)
    onChange(e.target.value)
  }

  return (
    <StyledTextField
      select={select}
      multiline={multiline}
      rows={multiline && 5}
      fullWidth={fullWidth}
      error={error}
      label={label}
      defaultValue={}
      value={value && value}
      onChange={onChange && handleChange}
      sx={{ width: ! fullWidth ? { xs: 'calc(100% - 2rem)', md: 'calc(50% - 2rem)' } : null }}
    >
      {select && items.map(item => {
        return(
          <MenuItem key={`item-${item}`} value={item || ''}>
            {item}
          </MenuItem>
        )
      })}
    </StyledTextField>
  );
};

export default InputField;
